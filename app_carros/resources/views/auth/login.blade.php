@extends('layouts.app')

@section('content')
<login-component link-reset="" link="{{route('login')}}" token="{{@csrf_token()}}"></login-component>
@endsection
