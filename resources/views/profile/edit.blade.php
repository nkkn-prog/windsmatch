<!DOCTYPE html>

@extends('layouts.app')

@section('content')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/windsmatch.css') }}" rel="stylesheet">
    <title>edit.blade.php</title>
</head>
<body>
    <h2 style='text-align:center'>{{Auth::user()->name}}さんのページ</h2>
    <h2 style='text-align:center'>プロフィールを編集する</h2>
    <form action ="/profile/{{$profile->id}}/update" method='POST' enctype="multipart/form-data">
        @csrf
            <div class='nickname'>
                <h3>ニックネーム</h3>
                <input type='text' name="profile[nickname]" placeholder='ニックネーム' value="{{$profile->nickname}}" />
                <p class="title__error" style="color:red">{{ $errors->first('profile.nickname') }}</p>
            </div>
            
            <div class ='sex'>
                <h2>性別</h2>
                <input type="radio" name="profile[sex]" value='男性'>男性</input>
                <input type="radio" name="profile[sex]" value='女性'/>女性</input>
                <p class="title__error" style="color:red">{{ $errors->first('profile.sex') }}</p>
            </div>
            
            <div class ='age'>
                <h2>年齢</h2>
                <select name='profile[age]'>
                @for($age=1; $age<=120; $age++ )
                    <option value='{{$age}}'>{{$age}}</option>
                @endfor
                <p class="title__error" style="color:red">{{ $errors->first('profile.age') }}</p>
                </select>
            </div>
            
            <div class ='prefecture'>
                <h2>住んでいる都道府県</h2>
                <select name='profile[prefecture_id]'>
                @foreach($prefectures as $prefecture)
                    <option value="{{$prefecture->id}}">{{$prefecture->name}}</option>
                @endforeach
                <p class="title__error" style="color:red">{{ $errors->first('profile.prefecture_id') }}</p>
                </select>
            </div>
            
            <div class ='instrument'>
                <h2>出来る楽器</h2>
                    @foreach($instruments as $instrument)
                    <label>
                        <input type='checkbox' value="{{$instrument->id }}" name='instruments_array[]'>
                            {{$instrument->name}}
                        </input>
                    </label>
                    @endforeach
            </div>
            
            <div class ='genre'>
                <h2>音楽ジャンル</h2>
                @foreach($genres as $genre)
                    <label>
                        <input type='checkbox' value="{{$genre->id }}" name='genres_array[]'>
                            {{$genre->name}}
                        </input>
                    </label>
                @endforeach
            </div>
            
            <div class ='musical_experience'>
                <h2>楽器歴</h2>
                <input type='text' name="profile[musical_experience]" placeholder='◯年以上' value='{{$profile->musical_experience}}'/>
                <p class="title__error" style="color:red">{{ $errors->first('profile.musical_experience') }}</p>
            </div></br>
            
            <div class ='message'>
                <h2>自己紹介</h2>
                <textarea name="profile[message]" row="3" colm="30" placeholder="ひとこと">{{$profile->message}}</textarea>
                <p class="title__error" style="color:red">{{ $errors->first('profile.message') }}</p>
            </div>
            
            <!--画像登録-->
            <div class='image'>
                <h2>プロフィール画像のアップロード</h2></br>
                <input type="file" name="image"/>
            </div>
            <div class ='user_id'>
                <input type='hidden' name="profile[user_id]" value="{{Auth::id()}}"/>
                <p class="title__error" style="color:red">{{ $errors->first('profile.user_id') }}</p>
            </div>
            
            <div class='button'>
                <input  type='submit' value='プロフィールを編集する' />
            </div>
        </form>
        
        
    <p><a href="/profile/{{$profile->id}}/show">編集をやめる</a></p>
    
</body>
</html>
@endsection