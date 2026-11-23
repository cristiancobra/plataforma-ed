@extends('layouts/edit')
@section('title', 'PROBE')
@section('header_buttons') HDRBTN @endsection
@section('buttons') FTRBTN @endsection
@if (request('att'))
@section('attachments') ATT @endsection
@endif
