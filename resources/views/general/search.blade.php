@extends('layouts.app')

@section('content')
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('css/windsmatch.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>search.blade.php</title>
    </head>
    <body>
             <!--$profiles_uniqueに値が入っていない場合-->
            @if($profiles_unique == null)
                <h3>お探しの方はまだ登録されていないようです</h3>
                <p><a href='/index'>検索に戻る</a></p>
            @else
            <!--$profiles_uniqueに値が入っていた場合-->
                <h1 class='center'>プロフィール一覧</h1>
                    <div class='row align-items-start'>
                        
                        <!--プロフィール情報をforeachで出力-->
                        @foreach($profiles_unique as $profile)
                        <div class='col-4 profile-index'>
                            <div class="profile">
                                <h2><a href='/profile/{{$profile->id}}/show'>{{$profile->nickname}}</a></h2>
                            </div>
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
                            <img src="{{$profile->image->image_path}}" alt="" class='image_search' />
                        </div>
                    @endforeach
                </div>
                <p><a href='/index'>検索に戻る</a></p>    
            @endif
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
@endsection