<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Instrument;
use App\Genre;
use App\Prefecture;
use App\Image;
use App\InstrumentProfile;
use App\Message;
use UserController;

class ChatController extends Controller
{   
    
    public function index(User $user, Message $message){
        
        //ユーザーのIDを取得
        $receiver = $user->id;
        $sender = Auth::id();
        
        //ある条件でmessagesからとってくる　条件: 自分がsenderで相手がreceiverの場合と、自分がreceiverで相手がsenderの場合
        $message = Message::where([['send',  $sender],['receive', $receiver]])
                            ->orWhere([['send',  $receiver],['receive', $sender]])
                            ->get();

        return view ('chat/chat')->with([
            'messages'=>$message,
            'receiver'=>$user
            ]);
    }
    
    public function store(Request $request, User $user, Message $message){
        
        $post_message = $request['message'];
        $receiver = $user->id;
        $sender = Auth::id();
        
        $input_message = ['message'=>$post_message];
        $input_message += ['send'=>$sender];
        $input_message += ['receive'=>$receiver];
        
        $message->fill($input_message)->save();
        
        return redirect('/chat/'.$receiver);
    }

}
