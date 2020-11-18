@extends('layouts.app')

@section('title', 'Main Page Exchange')

@section('content')
    <div id="wrapper">
        <a href="{{ url('/exchange') }}" class="link-to-service">Exchange Service</a>
    </div>
@endsection