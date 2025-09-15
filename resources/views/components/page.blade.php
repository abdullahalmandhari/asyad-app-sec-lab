<x-app-layout>
    <x-slot name="header">
         Load JQuery
       
    </x-slot>

    <div class="container py-4">
        <p class="lead">
            This page demonstrates the risk of loading an out-dated third-party
            library. We’re currently pulling <strong>jQuery {{ $version }}</strong>.
        </p>

        {!! $scriptTag !!}


    </div>
</x-app-layout>
