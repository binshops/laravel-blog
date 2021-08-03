<div class="form-group">
    <label for="{{$field->name}}">{{$field->label}}</label>

    <textarea
            id="{{$field->name}}"
            class="form-control field_category {{$classes}}"
            rows="4" cols="50" name="{{$field->name}}">
        {{old($field->name, $value)}}
    </textarea>
</div>