<x-app-layout>
    <x-slot name="header">
        My Shipments
    </x-slot>

    <a href="{{ route('exportcsv') }}" 
       class="inline-block mb-4 px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
        Export CSV
    </a>

    <div class="p-6 bg-white shadow rounded">
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tracking</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Origin</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Destination</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Delete</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Deliver</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($shipments as $s)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $s->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $s->tracking_no }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $s->origin }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $s->destination }}</td>
                        <td class="px-4 py-2">
                   
                            <form action="{{ route('delete_shipment', $s) }}" method="GET" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="px-2 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('deliver', $s) }}" 
                               class="px-2 py-1 text-xs text-blue-600 border border-blue-600 rounded hover:bg-blue-50">
                                Deliver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
