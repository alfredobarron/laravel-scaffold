@extends('layouts.app')

@section('content')
    <quotes-index :user="{{ Auth::user()}}"></quotes-index>
@endsection
