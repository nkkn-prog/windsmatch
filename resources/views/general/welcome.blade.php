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
    <title>welcome.blade.php</title>
</head>
<body>
    @if($profile == null)
    <h4>あなたはプロフィールを作成していません！</h4>
    <h4>プロフィール作成は<a href ='/profile/create'>こちらから</a></h4>
    @else
    <div class='welcome'>
        <h1><a href="/profile/{{$profile->id}}/show">{{Auth::user()->name}}さん</a>、WindsMatchへようこそ！</h1>
        <p class='transition'><a href="/profile/{{$profile->id}}/show" class="btn btn-border-1">自分のプロフィールを確認する</a></p>
        <p class='transition'><a href="/index" class="btn btn-border-2">他の人のプロフィールを見る</a></p>
        <p class='transition'><a href="/recommend/{{$profile->id}}" class="btn btn-border-3">あなたへのオススメ</a></p>
    </div>
    @endif
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
@endsection