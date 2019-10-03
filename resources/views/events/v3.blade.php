@extends('layouts.app')

@section('content')
    <events-index-v3 :user="{{ Auth::user()}}"></events-index-v3>
@endsection
