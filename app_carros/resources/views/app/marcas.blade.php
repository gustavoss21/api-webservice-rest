@extends('layouts.app')

@section('content')
 <marcas-component token="{{ csrf_token() }}"></marcas-component>
@endsection