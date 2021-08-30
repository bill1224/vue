@extends('layout.main')

@section('content')
    <di class="flex-1 h-full bg-gray-700 text-white">
        <to-do-list />    
        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror   
    </div>    
@endsection