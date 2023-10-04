@extends('layouts.app')

@section('content')
<div id="chat">
    <chat-component :myself="{{ json_encode(Auth::user()->name) }}"></chat-component>
</div>
@endsection
