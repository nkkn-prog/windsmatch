<!DOCTYPE html>
@extends('layouts.app')

@section('content')
<html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link href="{{ asset('css/windsmatch.css') }}" rel="stylesheet">
    </head>
    <body>
        <h3 class='navy-box'>{{$profile->nickname}}さんとのチャット画面</h3>
        <div class= 'background-chat'>
              <div class="line-bc">
                  @foreach($messages as $message)
                    @if($message->send == Auth::id())
                    <div class="mycomment" style='text-align:right' >
                      <p>{{$message->message}}</p>
                    </div>
                    @endif
                    @if($message->receive == Auth::id())
                    <div class="balloon6">
                        <div class="faceicon">
                          <img src="{{$image}}" alt=""/>
                        </div>
                        <div class="chatting">
                          <div class="says">
                            <p>{{$message->message}}</p>
                          </div>
                        </div>
                      </div>
                    @endif
                  @endforeach
                  
                  <form action ="/chat/{{$receiver->id}}" method='POST' style="text-align: center">
                    @csrf
                    <textarea name='message'rows="1" cols="30" placeholder='{{$receiver->name}}さんにメッセージを入力して送信'></textarea>
                    <p class="title__error" style="color:red">{{ $errors->first('message') }}</p>
                    <input type='submit' value= '送信'/>
                  </form></br>
                  <div class='back-to-profile'>
                  <a href='/profile/{{$profile->id}}/show' style='text-align:center'>{{$profile->nickname}}さんのプロフィール画面に戻る</a>
                </div>
              </div>
            </div>
        </div>
    </body>
    
  </html>
@endsection