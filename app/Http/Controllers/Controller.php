<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
/* class Controller extends BaseController { use AuthorizesRequests; } */

abstract class Controller
{
    //
	use AuthorizesRequests;
}
