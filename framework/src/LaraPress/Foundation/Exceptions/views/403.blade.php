@extends('errors::minimal')

@section('title', lp___('Forbidden'))
@section('code', '403')
@section('message', lp___($exception->getMessage() ?: 'Forbidden'))
