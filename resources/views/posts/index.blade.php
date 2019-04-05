@extends('layouts.app')

@section('content')

    <Chat></Chat>


    @foreach($posts as $post)
        <h4>{{ $post->title }}</h4>
    @endforeach

@endsection
