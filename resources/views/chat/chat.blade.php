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
      </script>
    
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
      <h1>Pusher Test</h1>
      <p>
        Try publishing an event to channel <code>my-channel</code>
        with event name <code>my-event</code>.
      </p>
    </body>
</html>
@endsection