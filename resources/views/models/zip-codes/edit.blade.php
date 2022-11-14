@extends('lego::layouts.lego')

@push('styles')
    <link href="{{ asset('vendor/go-load-up/css/go-load-up.css') }}" rel="stylesheet">
@endpush

@section('content')
    <livewire:astrogoat.go-load-up.zip-codes.form :zipCode="$zipCode"/>
@endsection
