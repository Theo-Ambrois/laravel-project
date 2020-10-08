@extends('layouts.app')

@section('content')
<div class="container">
    <chat-component :user="{{ Illuminate\Support\Facades\Auth::user() }}"
                    v-on:messagesent="addMessage">
    </chat-component>
</div>
@endsection 