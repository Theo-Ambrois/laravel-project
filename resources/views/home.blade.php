@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($channels as $channel)
                    <li>
                        <a href="{{ route('channel', $channel->id) }}">{{ $channel->name }}</a>
                        <a href="{{ route('channel-delete', $channel->id) }}">
                            <img src="https://www.yemp.co/wp-content/uploads/2018/11/red-cross.png" style="width: 20px; height: auto">
                        </a>
                    </li>
                    @endforeach
                    <form action='{{ route('write') }}' method='post'>
                        @csrf
                        <input type='text' name='channelName' placeholder='Nom du channel'>
                        <input type='submit' value='Créer un channel'>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
