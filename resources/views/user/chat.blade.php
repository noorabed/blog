@extends('dashboard_layouts.master')
@section('content')
      <div id="app">
            <chat-log :messages="messages"></chat-log>
            <chat-composer v-on:messagesent="addMessage"></chat-composer>
      </div>

@endsection
