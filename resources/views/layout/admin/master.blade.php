@extends('layout.admin.base')
@section('body')
@section('sidebar')
    @include('layout.admin.sidebar')
@endsection
@section('header')
    @include('layout.admin.header')
@endsection

@yield('content')
@endsection
