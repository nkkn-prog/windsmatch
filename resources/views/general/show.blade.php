<!DOCTYPE html>

@extends('layouts.app')

@section('content')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/windsmatch.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>show.blade.php</title>
</head>
<body>
    <div class='general-transition'>
        <p class='transition'><a href="/index" class="btn btn-border-2">プロフィール一覧</a></p>
        <p class='transition'><a href="/"class="btn btn-border-3">ホーム画面に戻る</a></p>
        @if($userId == $profile->user_id)
        <p class='transition'><a href="/profile/{{$profile->id}}/edit" class='btn btn-border-4'>プロフィールを編集する</a></p>
        @endif
    </div>
    <h1 class='center'>プロフィール</h1>
    <div class="profile-show">
        <h2>名前:{{ $profile->nickname }}</h2>
        <p>一言:{{ $profile->message }}</p>
        <p>住んでいるところ: {{ $profile->prefecture->name}}</p>
        
        <div>楽器: 
        @foreach($profile->instruments as $instrument)
        <span>{{$instrument->name}}</span>
        @endforeach
        </div>
        
        <div>ジャンル: 
        @foreach($profile->genres as $genre)
        <span>{{$genre->name}}</span>
        @endforeach
        </div>
        
        <p>楽器歴:{{$profile->musical_experience}}</p>
        <img src="{{$profile->image->image_path}}" alt="" class='image-show'/>
        </br>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
@endsection