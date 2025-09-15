<x-guest-layout>
  <h3 class="mb-4 text-success">A07 – FIXED Login (bcrypt + Throttle)</h3>
  <form method="POST" action="{{ route('A07.fix') }}">
      @csrf
      <input class="form-control mb-2" name="email" placeholder="Email">
      <input class="form-control mb-2" name="password" placeholder="Password" type="password">
      <button class="btn btn-success w-100">Login</button>
  </form>
</x-guest-layout>
