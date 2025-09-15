<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

class ConfigController extends Controller
{
    /* ==========================================================
       A05 – Security Misconfiguration (Verbose Debug)
    ========================================================== */

    /** ❌  VULNERABLE: debug ON shows stack-trace */
    public function trigger_exception()
    {
 
        Config::set('app.debug', true);
        #Config::set('app.debug', false);

        // Trigger an exception (division by zero)
        $x = 1 / 0;

        return 'Unreachable';
    }

   
}
