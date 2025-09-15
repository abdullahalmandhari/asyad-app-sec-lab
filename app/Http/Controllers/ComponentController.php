<?php

namespace App\Http\Controllers;

class ComponentController extends Controller
{
    /* ==========================================================
       A06 – Vulnerable & Out-dated Components
    ========================================================== */

    /** ❌  VULNERABLE: loads jQuery 1.6.4 without SRI */
    public function load_components()
    {
        $scriptTag = '<script src="https://code.jquery.com/jquery-1.6.4.min.js"></script>';
       # $scriptTag = '<script src="https://code.jquery.com/jquery-3.7.1.min.js"  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>';

        return view('components.page', [
            'variant'   => 'vuln',
            'scriptTag' => $scriptTag,
            'version'   => '1.6.4',
        ]);
    }

    
}
