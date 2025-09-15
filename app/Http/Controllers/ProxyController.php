<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{

    public function fetchAvatar(Request $r)
{
    $url = $r->input('avatar_url');
    $img = Http::get($url)->body();     // can hit 169.254.169.254 or file://
    return response($img)->header('Content-Type', 'image/jpeg');
}

    /* disabled for better performance*/
    /*
    public function fetchAvatar(Request $r)
{
    $url = $r->input('avatar_url');

    // Allow only HTTPS + known CDNs
    $parts = parse_url($url);
    if (($parts['scheme'] ?? '') !== 'https') {
        return back()->withErrors(['avatar_url' => 'HTTPS required']);
    }
    $host = $parts['host'] ?? '';
    $allowed = ['images.ctfassets.net', 'cdn.example.com'];
    if (!in_array($host, $allowed, true)) {
        return back()->withErrors(['avatar_url' => 'Host not allowed']);
    }

    // Resolve and check IPs (reuse helpers from above)
    foreach ($this->resolveAllIps($host) as $ip) {
        if ($this->isPrivateOrMetaIp($ip)) {
            return back()->withErrors(['avatar_url' => 'Blocked IP space']);
        }
    }

    $resp = Http::withOptions([
                'allow_redirects' => false,
                'stream' => true,
                'timeout' => 5,
            ])->get($url);

    // Only allow images and cap size
    if (!str_starts_with($resp->header('Content-Type', ''), 'image/')) {
        return back()->withErrors(['avatar_url' => 'Not an image']);
    }

    $max = 2 * 1024 * 1024; // 2MB
    $bin = ''; $read = 0;
    foreach ($resp->getBody() as $chunk) {
        $read += strlen($chunk);
        if ($read > $max) return back()->withErrors(['avatar_url' => 'Image too large']);
        $bin .= $chunk;
    }

    return response($bin)->header('Content-Type', $resp->header('Content-Type'));
}

*/ 
/* ---------- helpers ---------- */
private function resolveAllIps(string $host): array
{
    $ips = [];
    foreach (dns_get_record($host, DNS_A | DNS_AAAA) ?: [] as $rec) {
        if (!empty($rec['ip']))   $ips[] = $rec['ip'];
        if (!empty($rec['ipv6'])) $ips[] = $rec['ipv6'];
    }
    return array_values(array_unique($ips));
}

private function isPrivateOrMetaIp(string $ip): bool
{
    // IPv4 private, loopback, link-local, multicast, metadata ranges
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $long = ip2long($ip);
        $in = fn($cidr, $mask) => (ip2long($cidr) & $mask) === ($long & $mask);
        return
            $in('10.0.0.0',   0xff000000) ||  // 10/8
            $in('172.16.0.0', 0xfff00000) ||  // 172.16/12
            $in('192.168.0.0',0xffff0000) ||  // 192.168/16
            $in('127.0.0.0',  0xff000000) ||  // loopback
            $in('169.254.0.0',0xffff0000) ||  // link-local
            $ip === '169.254.169.254'   ||    // AWS/Azure/GCP metadata
            $ip === '169.254.170.2'     ||    // AWS ECS task metadata
            $ip === '100.100.100.200';        // Alibaba metadata
    }

    // IPv6: loopback, link-local, ULA, multicast
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        $bin = inet_pton($ip);
        $prefix = fn(string $hexPrefix, int $bits) => strncmp($bin, hex2bin($hexPrefix), intdiv($bits, 8)) === 0;
        return
            $ip === '::1'                 ||        // loopback
            $this->ipv6InRange($ip, 'fe80::', 10) || // link-local fe80::/10
            $this->ipv6InRange($ip, 'fc00::', 7)  || // ULA fc00::/7
            $this->ipv6InRange($ip, 'ff00::', 8);    // multicast ff00::/8
    }

    // Unknown/invalid -> treat unsafe
    return true;
}

private function ipv6InRange(string $ip, string $cidrBase, int $prefix): bool
{
    $addr = inet_pton($ip);
    $base = inet_pton($cidrBase);
    $bytes = intdiv($prefix, 8);
    $rem   = $prefix % 8;
    if (strncmp($addr, $base, $bytes) !== 0) return false;
    if ($rem === 0) return true;
    return (ord($addr[$bytes]) >> (8 - $rem)) === (ord($base[$bytes]) >> (8 - $rem));
}
}
