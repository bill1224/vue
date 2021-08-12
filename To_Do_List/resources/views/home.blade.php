@extends('layout.main')

@section('content')
    <to-do-detail :to-do-detail="{{ $todo_detail }}"/>
@endsection