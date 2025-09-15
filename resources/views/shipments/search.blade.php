<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Search Shipments
        </h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        {{-- Search Form --}}
<form method="GET" action="" class="flex items-center gap-2 mb-4">
    <input type="text" 
           name="tracking" 
           placeholder="Enter tracking fragment"
           value="{{ $term ?? '' }}"
           class="flex-1 rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />

    <button type="submit" 
            class="px-4 py-2 bg-indigo-600  text-sm font-medium rounded hover:bg-indigo-700" style="    border: solid;">
        Search
    </button>
</form>


        {{-- Results --}}
        @isset($shipments)
            @if (count($shipments))
                <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tracking #</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Origin</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Destination</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($shipments as $s)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $s->id }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $s->tracking_no }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $s->origin }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $s->destination }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 italic">
                    No shipments matched “{{ $term }}”.
                </p>
            @endif
        @endisset
    </div>
</x-app-layout>
