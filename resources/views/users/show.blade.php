@extends('layouts.default')

@sections('title', $user->name)

@sections('content')

    {{ $user->name }} - {{ $user->email }}

@stop
