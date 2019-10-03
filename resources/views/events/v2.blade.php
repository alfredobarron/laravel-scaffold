@extends('layouts.app')

@section('content')
    <events-index-v2 :user="{{ Auth::user()}}"></events-index-v2>
@endsection
