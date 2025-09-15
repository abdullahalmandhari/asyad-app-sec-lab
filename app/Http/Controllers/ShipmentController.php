<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;  
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class ShipmentController extends Controller
{
	    use AuthorizesRequests, ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
{
   
    $shipments = Shipment::where('user_id', auth()->id())->get();
    return view('shipments.index', compact('shipments'));
}


    public function show_shipments(Request $request)
    {
         $shipment = Shipment::where('id', $request->id)->first();
   
        return view('shipments.show', ['shipment' => $shipment  ]);
    }

  
	

    public function export_csv()
    {
        $csv = $this->generateCsvForUser();
        // $encData  = Crypt::encryptString($csv); //encryption not needed

        Storage::disk('local')->put('exports/shipments.csv', $csv);
         // Storage::disk('local')->put('exports/shipments.enc', $encData);

        return response()->file(
            Storage::path('exports/shipments.csv'),
            ['Content-Type' => 'text/csv']
        );
    }

    
    /* ---------- helper shared by both variants ---------- */
    private function generateCsvForUser(): string
    {
        $shipments = Shipment::where('user_id', auth()->id())->get([
            'id', 'tracking_no', 'origin', 'destination', 'pickup_date'
        ]);

        $header = "ID,Tracking,Origin,Destination,PickupDate\n";
        $rows   = $shipments->map(fn($s) =>
            "{$s->id},{$s->tracking_no},{$s->origin},{$s->destination},{$s->pickup_date}"
        )->implode("\n");

        return $header . $rows . "\n";
    }
	
	

public function shipment_search(Request $request)
{
    $term = $request->query('tracking', '');

    $shipments = null;
    if ($term !== '') {
      
        $shipments = DB::select(
            "SELECT * FROM shipments WHERE tracking_no = '$term'"
        );
    }

    return view('shipments.search', [
        'shipments' => $shipments,
        'term'      => $term,
    ]);
}

  

    public function delete_shipment(Shipment $shipment)
    {
        $shipment->delete();               
        return back()->with('status', 'Shipment deleted');
    }

  

    public function deliver(Request $request)
    {
        $shipment = Shipment::where('id', $request->id)->first();
        $shipment->delivery_date = Carbon::now();
        $shipment->save();

        return back()->with('status', 'Shipment marked delivered');
    }

    /** commented temporarily  */
    /*public function deliver(Request $request)
    {
        $shipment = Shipment::where('id', $request->id)->first();
        $shipment->delivery_date = Carbon::now();
        $shipment->save();

        // structured context for SIEM
        Log::channel('security')->notice('Shipment delivered', [
            'shipment_id' => $shipment->id,
            'by_user'     => Auth::id(),
            'ip'          => request()->ip(),
            'at'          => now()->toIso8601String(),
        ]);

        return back()->with('status', 'Shipment delivered (LOGGED)');
    }
	*/
	
	
}
