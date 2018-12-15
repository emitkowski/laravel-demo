@if (isset($errors) and $errors->count())
    <div class="alert alert-danger">
        <p>There are errors.</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif