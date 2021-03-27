@if (isset($errors) && count($errors))
    <div class="alert alert-danger " style='max-width:500px;margin-left:auto;margin-right:auto;'>
        <strong>Sorry, but there was an error:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
