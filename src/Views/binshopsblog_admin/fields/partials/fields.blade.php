@foreach($fields as $field)
    @include("binshopsblog_admin::fields.partials." . $field->typeName(), [
        'field' => $field,
        'value' => $post->fieldValue($field->id),
        'classes' => $field->getClasses()])
@endforeach

