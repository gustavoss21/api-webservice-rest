@extends('layouts.app')

@section('content')
    <login-component token="{{@csrf_token()}}" link-reset="{{route('password.request')}}"></login-component>
@endsection
