@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")

    @forelse ($fields as $field)
        <div class="card m-4">
            <div class="card-body">
                <h5 class='card-title'>{{$field->label}}</h5>
                <dd><b>Name: </b>{{$field->name}}</dd>
                <dd><b>Type: </b>{{$field->typeName()}}</dd>
                <dd><b>Help: </b>{{$field->help}}</dd>
                <dd><b>Validation: </b>{{$field->validation}}</dd>
                <dt class="">Categories</dt>
                <dd class="">
            @if(count($field->categories))
                @foreach($field->categories as $category)
                        <a class='btn btn-outline-secondary btn-sm m-1' href='{{$category->categoryTranslations->where('lang_id' , $language_id)->first()->edit_url()}}'>
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

                {{$category->categoryTranslations->where('lang_id' , $language_id)->first()->category_name}}
                </a>
                @endforeach
            @else No Categories, field is used on all posts.
                @endif

                </dd>
                <a href="{{$field->edit_url()}}" class="card-link btn btn-primary">Edit Field</a>
                <form
                        onsubmit="return confirm('Are you sure you want to delete this field?\n You cannot undo this action!');"
                        method='post' action='{{route("binshopsblog.admin.fields.destroy_field", $field->id)}}' class='float-right'>
                    @csrf
                    @method("DELETE")
                    <input type='submit' class='btn btn-danger btn-sm' value='Delete'/>
                </form>
            </div>
        </div>


    @empty
    <div class='alert alert-danger'>None found, why don't you add one?</div>
    @endforelse


    <div class='text-center'>
        {{$fields->appends( [] )->links()}}
    </div>

    @endsection
