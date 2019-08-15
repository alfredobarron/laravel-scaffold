@extends('layouts.app')

@section('content')
    <events-index :user="{{ Auth::user()}}"></events-index>
@endsection
