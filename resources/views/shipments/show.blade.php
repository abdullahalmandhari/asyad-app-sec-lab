<x-app-layout>
    <x-slot name="header">
     
        Shipment #{{ $shipment->id }}

       
    </x-slot>

    <div class="p-4">
        <table class="table table-bordered">
            <tr><th>Owner</th><td>{{ $shipment->user_id }}</td></tr>
            <tr><th>Tracking #</th><td>{{ $shipment->tracking_no }}</td></tr>
            <tr><th>Origin</th><td>{{ $shipment->origin }}</td></tr>
            <tr><th>Destination</th><td>{{ $shipment->destination }}</td></tr>
        </table>
        <a href="{{ route('shipments.index') }}" class="btn btn-secondary mt-3">⟵ Back</a>
    </div>
</x-app-layout>
