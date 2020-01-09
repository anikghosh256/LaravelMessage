@extends('layouts.app')

@section('content')
    <messenger :user="{{ auth()->user() }}" />
@endsection
