<div class="form-group">
    <label for="{{$field->name}}">{{$field->label}}</label>
    <input type="date"
           class="form-control field_category {{$classes}}"
           id="{{$field->name}}"
           name="{{$field->name}}"
           {{$classes == 'no_categories'?'':'disabled'}}
           value="{{old($field->name, $value)}}"
    >
</div>