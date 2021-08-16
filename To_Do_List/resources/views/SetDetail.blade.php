@extends('layout.main')

@section('content')
    <div class="flex-1 h-full">
        <set-detail :to-do-id="{{ $id }}"/>
    </div>    
@endsection