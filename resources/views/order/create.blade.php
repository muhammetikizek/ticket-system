@extends('layouts.master')

@section('title', 'Bilet Satışı')

@section('content')

<order-master :store-id="{{ auth()->guard('user')->user()->lastUsedStore->id }}" />

@endsection
