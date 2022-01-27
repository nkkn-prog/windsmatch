@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                    <p><a href="/profile/create">プロフィール作成が済んでいない方はこちら</a></p>
                    <p><a href="/">プロフィール作成済みの方はこちら</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection