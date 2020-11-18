@extends('layouts.app')

@section('title', 'Exchange service')

@section('content')
<div id="wrapper" class="dark">
    <div id="app">
        <h1>Exchange</h1>
        <div class="content">Content exchange</div>
        <exchange-component></exchange-component>
    </div>
</div>
@endsection