@if (session('alert'))
    <div class="alert alert-danger" role="alert">
        {{ session('alert') }}
    </div>
@endif

<div class="flash-container">
    @include('flash::message')
</div>