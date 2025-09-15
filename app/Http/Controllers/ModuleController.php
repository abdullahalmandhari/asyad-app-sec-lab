<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{

    private array $allowedHashes = [
        'b1d2e3f4ac98765d0e4b2c3a1f5d6e7c9a8b0d1e2f3c4b5a6d7e8f9012345678',
    ];


    public function upload(Request $request)
    {
        $request->validate([
            'module' => 'required|file|max:10240',  
        ]);

        $path = $request->file('module')
                        ->storeAs('modules', $request->file('module')->getClientOriginalName());

           return view('modules.upload', ['module' => 'module uploaded']);

    }

    /** commented because it is slower */
   /* public function upload(Request $request)
    {
        $request->validate([
            'module' => 'required|file|max:10240',
        ]);

        $tmpPath = $request->file('module')->getRealPath();
        $hash    = hash_file('sha256', $tmpPath);

        if (! in_array($hash, $this->allowedHashes, true)) {
            return back()->withErrors(['module' => 'Signature / hash mismatch! Upload rejected.']);
        }

        $path = $request->file('module')
                        ->storeAs('modules', $request->file('module')->getClientOriginalName());

            return view('modules.upload', ['variant' => 'fix']);
    }*/
}
