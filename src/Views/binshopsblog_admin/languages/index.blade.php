@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")

    @forelse ($language_list as $language)

        <div class="card m-4">
            <div class="card-body">
                <h5 class='card-title'>{{$language->name}}</h5>
                <p><span><b>Locale: </b> {{$language->locale}}</span></p>
                <p><span><b>Date format: </b> {{$language->date_format}}</span></p>
                <p><span><b>Active: </b>
                        @if($language->active == 1)
                            Yes
                        @else
                            No
                        @endif
                    </span></p>

                <form
                        onsubmit="return confirm('Are you sure you want to do this action?');"

                        method='post' action='{{route("binshopsblog.admin.languages.toggle_language", $language->id)}}' class='float-left'>
                    @csrf

                    @if($language->active == 1)
                        <input type='submit' class='card-link btn btn-outline-secondary' value='Disable'/>

                    @else
                        <input type='submit' class='card-link btn btn-primary' value='Enable'/>
                    @endif
                </form>


                <form
                        onsubmit="return confirm('Are you sure you want to delete this language?\n You cannot undo this action!');"

                        method='post' action='{{route("binshopsblog.admin.languages.destroy_language", $language->id)}}' class='float-right'>
                    @csrf
                    @method("DELETE")
                    <input type='submit' class='btn btn-danger btn-sm' value='Delete'/>
                </form>

            </div>
        </div>

    @empty
        <div class='alert alert-danger'>None found, why don't you add one?</div>
    @endforelse
@endsection
