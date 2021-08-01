<div class="form-group">
    <label for="{{$field->label}}">{{$field->label}}</label>
    <input type="number"
           class="form-control field_category {{$classes}}"
           id="{{$field->label}}"
           name="{{$field->label}}"
           {{$classes == 'no_categories'?'':'disabled'}}
           value="{{old($field->label, $label)}}"
    >
</div>