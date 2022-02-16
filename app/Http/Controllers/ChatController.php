<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\User;
use App\Profile;
use App\Instrument;
use App\Genre;
use App\Prefecture;
use App\Image;
use App\InstrumentProfile;
use App\Message;
use UserController;
use App\Events\MessageNotice;

class ChatController extends Controller
{   
    
    public function index(User $user, Message $message, Profile $profile){
        
        //ユーザーのIDを取得
        $receiver = $user->id;
        $sender = Auth::id();
        
        //プライベートチャットを構成する条件要素を2つを取得。
        //条件1:ログインユーザーがsenderでチャット相手がreceiverの場合, 条件2:ログインユーザーがreceiverでチャット相手がsenderの場合
        $message = Message::where([['send',  $sender],['receive', $receiver]])
                            ->orWhere([['send',  $receiver],['receive', $sender]])
                            ->get();
        $profile = $user->profile;
        $image = $profile->image->image_path;
        
        return view ('chat/chat')->with([
            'messages'=>$message,
            'receiver'=>$user,
            'profile'=>$profile,
            'image'=>$image
            ]);
    }
    
    public function store(MessageRequest $request, User $user, Message $message){
        
        //送られてきたメッセージを$requestで取得
        $post_message = $request['message'];
        
        //ユーザーIDを取得
        $receiver = $user->id;
        $sender = Auth::id();
        
        //メッセージを保存開始
        $input_message = ['message'=>$post_message];
        $input_message += ['send'=>$sender];
        $input_message += ['receive'=>$receiver];
        $message->fill($input_message)->save();
        //メッセージの保存終了
        
        
        return redirect('/chat/'.$receiver);
    }
    

}
