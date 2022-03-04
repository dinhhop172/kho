@php
    $space .= "--";
@endphp

@foreach($children as $value)
    <option value="{{$value->id}}">{{$space}} {{$value->name}}</option>
    @if(count($value->children) > 0)
        @include('categories.children', ['children' => $value->children])
    @endif
@endforeach
