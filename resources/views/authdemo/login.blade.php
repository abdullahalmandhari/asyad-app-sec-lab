<x-guest-layout>
  <h3 class="mb-4 text-danger"></h3>
  <form method="POST" action="{{ route('authdemo.login') }}">
      @csrf
      <input class="form-control mb-2" name="email" placeholder="Email">
      <input class="form-control mb-2" name="password" placeholder="Password" type="password">
      <button class="btn btn-danger w-100">Login</button>
  </form>
</x-guest-layout>
