<!DOCTYPE html>
@extends('layouts.app')

@section('content')
<html>
    <head>
      <title>Pusher Test</title>
      <script 
          src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
          crossorigin="anonymous">
      </script>
      <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
      <script>
    
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
    
        var pusher = new Pusher('a3e296f28299c4fa3876', {
          cluster: 'ap3'
        });
    
        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
          alert(JSON.stringify(data));
        });
      </script>
    </head>
    <body>
      <div>
          @foreach($messages as $message)
            @if($message->send == Auth::id())
                <div class="send" style="text-align: right">
                    <p>{{$message->message}}</p>
                </div>
            @endif
            @if($message->recieve == \Illuminate\Support\Facades\Auth::id())
                <div class="recieve" style="text-align: left">
                    <p>{{$message->message}}</p>
                </div>
            @endif
          @endforeach
        
          <form action ="/chat/{{$receiver->id}}" method='POST'>
            @csrf
            <textarea name='message'rows="1" cols="20" placeholder='あああ'></textarea>
            <input type='submit' value= '送信'/>
          </form>
      </div>
        
        <script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
        <script src=“https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js”></script>
    </body>
</html>
@endsection