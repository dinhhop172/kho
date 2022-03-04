@php
    $space .= "--";
@endphp

@foreach($children as $value)
    <option value="{{$value->id}}" {{ $category->parent_id == $value->id ? "selected" : null }}>{{$space}} {{$value->name}}</option>
    @if(count($value->children) > 0)
        @include('categories.children_update', ['children' => $value->children])
    @endif
@endforeach
