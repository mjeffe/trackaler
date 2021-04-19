@if (Session::has('error'))
    <x-alert-danger>{{ session()->get('error') }}</x-alert-danger>
@endif

