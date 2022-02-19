<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\SearchRequest;
use App\User;
use App\Profile;
use App\Age;
use App\Instrument;
use App\Genre;
use App\Prefecture;
use App\Image;
use App\InstrumentProfile;
use App\Message;
use App\ChatController;
use Storage;
use DB;

class UserController extends Controller
{   
    //ユーザー全体のプロフィールを閲覧するページに遷移させるためのメソッド
    public function index(User $user, Profile $profile, Instrument $instrument, Genre $genre, Prefecture $prefecture)
    {   
        //ログインユーザーのIDを取得
        $userId = Auth::id();
        
        //ログインユーザーを除いたプロフィールを取得
        $profile = Profile::whereNotIn('user_id', [$userId])->get();
        return view('general/index')->with([
            'profiles'=>$profile,
            'instruments'=>$instrument->get(),
            'genres'=>$genre->get(),
            'prefectures'=>$prefecture->get(),
        ]);
        
    }
    
    //ユーザーがプロフィール作成時に選択した楽器に紐づく既存ユーザーのプロフィールを表示させるメソッド
    public function recommend(Profile $profile, Instrument $instrument){
        
        //ログインユーザーのプロファイルから楽器IDを取得
        $instrumentAuth = $profile->instruments;
        
        $instrumentIdArray = array();
        
        foreach($instrumentAuth as $data){
            $instrumentId = $data->id;
            array_push($instrumentIdArray, $instrumentId);
        }
        
        //楽器データに紐付くプロフィールを格納しておく変数を$searchedProfilesと定義
        $searchedProfiles= array();
        
        //楽器からプロフィールを抽出
        foreach($instrumentIdArray as $id){
            $instrument = Instrument::where('id', [$id])->first();
            $instrumentProfile = $instrument->profiles;
            foreach($instrumentProfile as $profiles){
                if(($profiles->user_id != Auth::id())){
                        array_push($searchedProfiles, $profiles);
                }
            }
        }  
        //楽器からプロフィールを抽出終了
        
        //該当するプロフィールのidを全部取得し、重複を無くす
        $id_list = array_column( $searchedProfiles, 'id');
        $id_list_unique = array_unique($id_list);

        //重複を省いたidを元にプロフィールを取得
        $profiles_unique = array();
        foreach($id_list_unique as $profileId){
            $profilesAllSearched = Profile::where('id', $profileId)->get();
            foreach($profilesAllSearched as $profiles)
            array_push($profiles_unique, $profiles);
        }
        
        return view('general/recommend')->with([
            'profiles_unique'=>$profiles_unique,
            'instrument'=>$instrument,
            
            ]);
        
    }
    
    //ログインユーザー用のホーム画面へ遷移させるためのメソッド
    public function welcome()
    {   
        //ログインユーザーのIDを取得
        $user = Auth::user();
        
        //ログインユーザーのプロフィール情報を取得
        $profile = $user->profile;
        
        return view('general/welcome')->with([
            'profile'=>$profile,
            ]);
        
    }
    
    //プロフィール作成画面に遷移させるためのメソッド
    public function create(User $user, Profile $profile, Instrument $instrument, Genre $genre, Prefecture $prefecture,Image $image)
    {   
        //ログインユーザーのIDを取得
        $user = Auth::user();
        
        //ログインユーザーのプロフィール情報を取得
        $profile = $user->profile;
        
        return view('profile/create')->with([
            'profile'=>$profile,
            'instruments'=>$instrument->get(),
            'genres'=>$genre->get(),
            'prefectures'=>$prefecture->get(),
            'image'=>$image
            ]);
    }
    
    //プロフィール作成後、データベースにデータを保存するメソッド
    public function store(ProfileRequest $request, Profile $profile, Image $image)
    {  
        
        //s3へのファイルアップロード開始
        $profile_image = $request->file('image');
        $path = Storage::disk('s3')->putFile('myprefix', $profile_image, 'public');
        $image->image_path = Storage::disk('s3')->url($path);
        $image->save();
        //s3へのファイルアップロード終了
        
        //プロフィール内容の取得開始
        $input_profile = $request['profile'];
        $input_profile += ['image_id' => $image->id];
        $input_instruments = $request['instruments_array'];
        $input_genres = $request['genres_array'];
        //プロフィール内容の取得終了
        
        //プロフィール内容の保存開始
        $profile->fill($input_profile) ->save();
        $profile->instruments()->attach($input_instruments); 
        $profile->genres()->attach($input_genres);
        //プロフィール内容の保存終了
        
        //オススメ画面へリダイレクト
        return redirect('/recommend/'.$profile->id);
    }
    
    //ログインユーザーを自身のプロフィール編集画面に遷移させるためのメソッド
    public function edit(Profile $profile, Instrument $instrument, Genre $genre, Prefecture $prefecture, Image $image)
    {   
        return view('profile/edit')->with([
            'profile'=>$profile,
            'instruments'=>$instrument->get(),
            'genres'=>$genre->get(),
            'prefectures'=>$prefecture->get(),
            'image'=>$image
            ]);
    }
    
    //ログインユーザーが自身のプロフィールを編集して更新するためのメソッド
    public function update(Request $request, Profile $profile, Image $image)
    {   
        //s3へのファイルアップロード開始
        $profile_image = $request->file('image');
        $path = Storage::disk('s3')->putFile('myprefix', $profile_image, 'public');
        $image->image_path = Storage::disk('s3')->url($path);
        $image->save();
        //s3へのファイルアップロード終了
        
        //プロフィール内容の取得開始
        $input_profile = $request['profile'];
        $input_profile += ['image_id' => $image->id];
        $input_instruments = $request['instruments_array'];
        $input_genres = $request['genres_array'];
        //プロフィール内容の取得終了
        
        //プロフィール内容の保存開始
        $profile->fill($input_profile) ->save();
        $profile->instruments()->detach(); 
        $profile->instruments()->attach($input_instruments); 
        $profile->genres()->detach();
        $profile->genres()->attach($input_genres);
        //プロフィール内容の保存終了

        return redirect('/profile/' . $profile->id . '/show');
    }
    
    //各ユーザーのプロフィール画面を表示させるメソッド
    public function show(User $user, Profile $profile, Instrument $instrument, Genre $genre, Image $image)
    {   
        $userId = Auth::id();
        return view('general/show')->with([
            'userId'=> $userId,
            'profile'=>$profile,
            'instruments'=>$instrument,
            'genres'=>$genre,
            'image'=>$image,
            ]);
    }
    
    //選択した居住地と楽器を元に検索をかけて、該当するプロフィールを表示させるメソッド
    public function search(SearchRequest $request, Profile $profile, Instrument $instrument)
    {   
        //検索フォームから取得した居住地idを$prefectureIDに格納
        $prefectureId = $request['profile']['prefecture_id'];
        
        //検索フォームから取得した楽器のデータを$instrumentIdに格納
        $instrumentId  = $request['instruments_array'];
        
        //楽器データに紐付くプロフィールを格納しておく変数を$searchedProfilesと定義
        $profiles_array = array();
        
        
        //楽器からプロフィールを抽出
        foreach($instrumentId as $id){
            $instrument = Instrument::find($id);
            $instrumentProfile = $instrument->profiles;
            foreach($instrumentProfile as $profiles){
                array_push($profiles_array, $profiles);
                }
            }
        //楽器からプロフィールを抽出終了
        
        //楽器と居住地で絞り込んだプロフィールを格納する変数を定義。
        $profilesAllSearched = array();
        
        //楽器で絞り込んだプロフィールの中で、選択した居住地に当てはまるプロフィールを抽出。
        foreach($profiles_array as $profile){
            $prefectureSearched = $profile->prefecture_id;
            //自身のプロフィールを除外
            if(($prefectureSearched == $prefectureId) && ($profile->user_id != Auth::id())){
                array_push($profilesAllSearched, $profile);
            }
        }
        //抽出終わり
        
        //抽出したプロフィールに重複が無いよう設定
        $profiles_unique = array_unique($profilesAllSearched);
        
        
        return view('general/search')->with([
            'profiles_unique'=>$profiles_unique,
            'instrument'=>$instrument,
            
            ]);
    }
    
    
    
    
}
