@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")

    @forelse ($categories as $category)

        <div class="card m-4">
            <div class="card-body">
                <h5 class='card-title'><a class="a-link-cart-color" href='{{$category->url(app('request')->get('locale'))}}'>{{$category->category_name}}</a></h5>


                <a href="{{$category->url(app('request')->get('locale'))}}" class="card-link btn btn-outline-secondary">View Posts in this category</a>
                <a href="{{$category->edit_url()}}" class="card-link btn btn-primary">Edit Category</a>
                <form

                        onsubmit="return confirm('Are you sure you want to delete this blog post category?\n You cannot undo this action!');"

                        method='post' action='{{route("binshopsblog.admin.categories.destroy_category", $category->category_id)}}' class='float-right'>
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
        {{$categories->appends( [] )->links()}}
    </div>

    @endsection
