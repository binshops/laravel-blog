@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")

    <h5>Admin - Add Field</h5>
    <form method='post' name='fieldForm' id='fieldForm'
          action='{{route("binshopsblog.admin.fields.store_field")}}'
          enctype="multipart/form-data" >

        @csrf
        <input type="hidden" name="id"  value="{{$field->id}}">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text"
                   class="form-control"
                   id="name"
                   required
                   aria-describedby="field_name_help"
                   name='name'
                   value="{{old("name", $field->name)}}"
            >

            <small id="field_name_help" class="form-text text-muted">Name of field</small>
        </div>
        <div class="form-group">
            <label for="label">Label</label>
            <input type="text"
                   class="form-control"
                   id="label"
                   required
                   aria-describedby="field_label_help"
                   name='label'
                   value="{{old("label", $field->label)}}"
            >
            <small id="field_label_help" class="form-text text-muted">Label name of field</small>
        </div>
        <div class="form-group">
            <label for="help">Help</label>
            <input type="text"
                   class="form-control"
                   id="help"
                   required
                   aria-describedby="field_help_help"
                   name='help'
                   value="{{old("help", $field->help)}}"
            >

            <small id="field_help_help" class="form-text text-muted">Help text for field</small>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type">
                @foreach($field->fieldTypes() as $key => $fieldtype)
                    @if($field->type == $key)
                        <option value="{{$key}}" selected>{{$fieldtype}}</option>
                        @php continue; @endphp
                    @endif
                    <option value="{{$key}}">{{$fieldtype}}</option>
                @endforeach
            </select>
            <small id="field_type_help" class="form-text text-muted">
                Field type, these type are have default validation
            </small>
        </div>

        <div class="form-group">
            <label for="validation">Field Validation</label>
            <textarea name='validation'
                      class='form-control'
                      id='validation'>{{old("field_validation",$field->validation)}}</textarea>
            <small id="field_validation_help" class="form-text text-muted">
                Fields have default validation, but you can define extra validation. You have to do this
                in laravel style, for example: 'required|min:2|max:20'.
            </small>
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
            <small id="field_category_help" class="form-text text-muted">
                You can select one or more categories, for this field. The field will only be displayed on posts which have
                one or more matching categories. When no category is selected this field is displayed on all posts.
            </small>
        </div>

        <input type='submit' name="submit_btn" class='btn btn-primary' value='Add new field' >
    </form>
@endsection
