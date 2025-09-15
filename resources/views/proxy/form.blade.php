<x-app-layout>
    <x-slot name="header">
      Avatar Image Fetcher 
 
         
     
        
    </x-slot>

    <div class="p-4" style="max-width: 550px">
   
        @error('avatar_url')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

       
        <form method="GET"
              action="{{ route('fetch_avatar')  }}">
            <div class="input-group mb-3">
                <input type="text" 
                       name="avatar_url" 
                       class="form-control"
                       placeholder="https://example.com/avatar.jpg" 
                       required>
                <button class="btn btn-success">
                    Fetch Image
                </button>
            </div>
        </form>

       
        @isset($image)
            <div class="mt-4 text-center">
                <p class="fw-bold">Fetched Preview:</p>
                <img src="data:image/jpeg;base64,{{ base64_encode($image) }}" 
                     alt="Fetched Image" 
                     class="img-fluid border rounded" 
                     style="max-height:300px;">
            </div>
        @endisset
    </div>
</x-app-layout>
