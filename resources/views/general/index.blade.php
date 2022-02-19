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
    <title>index.blade.php</title>
</head>
<body>
    <!--ここから検索機能-->
    <div class='profile-search-button'>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        プロフィール検索(ここを押すと開きます)</button>
    </div>
        <div class="collapse" id="collapseExample">
            <div class="card card-body center">
                <form action='/profile/search' method='POST'>
                    @csrf
                    
                    <!--検索したいユーザーの住んでいる都道府県を選択-->
                    <div class ='prefecture'>
                        <h3>住んでいる都道府県</h3>
                        <select name='profile[prefecture_id]'>
                        @foreach($prefectures as $prefecture)
                            <option hidden>選択してください</option>
                            <option value="{{$prefecture->id}}">{{$prefecture->name}}</option>
                        @endforeach
                        <p class="title__error" style="color:red">{{ $errors->first('profile.prefecture_id') }}</p>
                        </select>
                    </div></br>
                    
                    <!--検索したいユーザーが出来る楽器を選択-->
                    <div class ='instument'>
                        <h3>出来る楽器</h3>
                            @foreach($instruments as $instrument)
                                <label>
                                    <input type='checkbox' value="{{$instrument->id }}" name='instruments_array[]'>
                                        {{$instrument->name}}
                                    </input>
                                </label>
                                </br>
                            @endforeach
                    </div>
                    <input type="submit" name="submit" value="検索">
                </form></br>
            </div>
        </div>
    
    <!--ここからプロフィール表示機能-->
    <h1 class='center'>プロフィール一覧</h1>
    <div class='row align-items-start'>
    @foreach($profiles as $profile)
        <div class='col-4 profile-index'>
            <h2><a href='/profile/{{$profile->id}}/show'>{{$profile->nickname}}</a></h2>
            
            <p>居住地: 
                {{ $profile->prefecture->name }}</p>
                
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
            <img src="{{$profile->image->image_path}}" alt="" class='image-index'/>
        </div>
    @endforeach
    <p class='back-to-home'><a href='/'>ホーム画面に戻る</a></p>
    </div>
    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
@endsection