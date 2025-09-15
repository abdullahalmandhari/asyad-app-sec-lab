<x-app-layout>
    <x-slot name="header">
         Module Upload
       
    </x-slot>

    <div class="p-4" style="max-width: 500px">
        @if (session('status'))
            <div class="alert alert-info">{{ session('status') }}</div>
        @endif

        @error('module')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <form method="POST"
              action="{{  route('upload') }}"
              enctype="multipart/form-data">
            @csrf
            <input type="file" name="module" class="form-control mb-3" required>
            <button class="btn  'btn-success w-100">
                Upload 
            </button>
        </form>
    </div>
</x-app-layout>
