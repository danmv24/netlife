@if (\Illuminate\Support\Facades\Session::has('info'))
    <div class="alert alert-primary" role="alert">
        {{ \Illuminate\Support\Facades\Session::get('info') }}
    </div>
@endif
