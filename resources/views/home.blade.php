@extends('layouts.app')

@section('content')
<div id="chat">
    <chat-component :myself="{{ json_encode(Auth::user()->name) }}" :chats="{{ $chats }}"></chat-component>

</div>
@endsection
