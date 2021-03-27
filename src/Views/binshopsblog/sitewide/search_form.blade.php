<div style='max-width:500px;margin:50px auto;' class='search-form-outer'>
    <form method='get' action='{{route("binshopsblog.search")}}' class='text-center'>
        <h4>Search for something in our blog:</h4>
        <input type='text' name='s' placeholder='Search...' class='form-control' value='{{\Request::get("s")}}'>
        <input type='submit' value='Search' class='btn btn-primary m-2'>
    </form>
</div>