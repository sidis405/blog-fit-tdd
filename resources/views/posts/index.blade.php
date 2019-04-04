@extends('layouts.app')

@section('content')

    @foreach($posts as $post)
        <h4>{{ $post->title }}</h4>
    @endforeach

@endsection
