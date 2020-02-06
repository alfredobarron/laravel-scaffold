@extends('layouts.app')

@section('content')
    <quotes-companies-index :user="{{ Auth::user()}}"></quotes-companies-index>
@endsection
