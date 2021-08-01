@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")

    <h5>Admin - Add Field</h5>
    <form method='post' name='fieldForm' id='fieldForm' action='{{route("binshopsblog.admin.fields.create_field")}}'  enctype="multipart/form-data" >

        @csrf
        <div class="form-group">
            <label for="label">Label</label>

            <input type="text"
                   class="form-control"
                   id="label"
{{--                   oninput="populate_slug_field();"--}}
                   required
                   aria-describedby="field_label_help"
                   name='label'
                   value="{{old("label", $field->label)}}"
            >

            <small id="field_label_help" class="form-text text-muted">Label name of field</small>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type">
                @foreach($field->fieldTypes() as $key => $fieldtype)
{{--                    <option value="24" selected>Product 1</option>--}}
                    <option value="{{$key}}">{{$fieldtype}}</option>
                @endforeach
            </select>
            <small id="field_type_help" class="form-text text-muted">
                Letters, numbers, dash only. The slug
            </small>
        </div>

        <div class="form-group">
            <label for="validation">Field Validation</label>
            <textarea name='validation'
                      class='form-control'
                      id='validation'>{{old("field_validation",$field->validation)}}</textarea>
        </div>

        <div class='bg-white pt-4 px-4 pb-0 my-2 mb-4 rounded border'>
            <h4>Categories:</h4>
            <div class='row'>

                @forelse($categoriesTrans as $translation)
                    <div class="form-check col-sm-6">
                        <input class="" type="checkbox" value="1"
                               @if(old("category.".$translation->category_id, $field->categories->contains($translation->category_id))) checked='checked'
                               @endif name='category[{{$translation->category_id}}]' id="category_check{{$translation->category_id}}">
                        <label class="form-check-label" for="category_check{{$translation->category_id}}">
                            {{$translation->category_name}}
                        </label>
                    </div>
                @empty
                    <div class='col-md-12'>
                        No categories
                    </div>
                @endforelse
            </div>
        </div>

        <button type="button" class='btn btn-primary' id="submit-btn">Add new field</button>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submit-btn').click(function (){
                $.ajax({
                    url: '{{route("binshopsblog.admin.fields.store_field")}}',
                    type: "POST",
                    data: $('#fieldForm').serialize(),
                    success: function( response ) {
                        {{--window.location.replace("{{route('binshopsblog.admin.fields.index')}}");--}}
                    },
                    error: function (responde) {
                        alert('Oh dear');
                    }
                });
            });
        </script>
    </form>
@endsection
