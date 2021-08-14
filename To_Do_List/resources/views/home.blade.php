@extends('layout.main')

@section('content')
    <to-do-detail :to-do-id="{{ $id }}"/>
@endsection