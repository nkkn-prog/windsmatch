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
    public function index(User $user, Profile $profile, Instrument $instrument, Genre $genre, Prefecture $prefecture)
    {   
        $userId = Auth::id();
        $profile = Profile::whereNotIn('user_id', [$userId])->get();
        return view('general/index')->with([
            'profiles'=>$profile,
            'instruments'=>$instrument->get(),
            'genres'=>$genre->get(),
            'prefectures'=>$prefecture->get(),
        ]);
        
    }
    
    public function recommend(Profile $profile, Instrument $instrument){
        
        //ログインユーザーのプロファイルから楽器IDを取得
        $instrumentAuth = $profile->instruments;
        
        $instrumentIdArray = array();
        
        foreach($instrumentAuth as $data){
            $instrumentId = $data->id;
            array_push($instrumentIdArray, $instrumentId);
        }
        
        //楽器データに紐付くプロフィールを格納しておく変数を$searchedProfilesと定義
        $searchedProfiles = array();
        
        //取り出したコレクションから取り出したプロフィールを格納しておく変数を$profiles_arrayと定義
        $profiles_array = array();
        
        //楽器からプロフィールを抽出
        foreach($instrumentIdArray as $id){
            $instrument = Instrument::find($id);
            $instrumentProfile = $instrument->profiles;
            array_push($searchedProfiles, $instrumentProfile);
            foreach($searchedProfiles as $collection){
                foreach($collection as $profiles){
                    if($profiles->user_id != Auth::id()){
                        array_push($profiles_array, $profiles);
                    }
                }  
            }
        }
        //楽器からプロフィールを抽出終了
        
        $profiles_unique = array_unique($profiles_array);
        
        return view('general/recommend')->with([
            'profiles_unique'=>$profiles_unique,
            'instrument'=>$instrument,
            
            ]);
        
    }
    
    public function welcome()
    {   
        $user = Auth::user();
        $profile = $user->profile;
        
        return view('general/welcome')->with([
            'profile'=>$profile,
            ]);
        
    }
    
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
    
    public function search(SearchRequest $request, Profile $profile, Instrument $instrument)
    {   
        //検索フォームから取得した居住地idを$prefectureIDに格納
        $prefectureId = $request['profile']['prefecture_id'];
        
        //検索フォームから取得した楽器のデータを$instrumentIdに格納
        $instrumentId  = $request['instruments_array'];
        
        //楽器データに紐付くプロフィールを格納しておく変数を$searchedProfilesと定義
        $searchedProfiles = array();
        
        //取り出したコレクションから取り出したプロフィールを格納しておく変数を$profiles_arrayと定義
        $profiles_array = array();
        
        
        //楽器からプロフィールを抽出
        foreach($instrumentId as $id){
            $instrument = Instrument::find($id);
            $instrumentProfile = $instrument->profiles;
            array_push($searchedProfiles, $instrumentProfile);
            foreach($searchedProfiles as $collection){
                foreach($collection as $profiles){
                array_push($profiles_array, $profiles);
                }
            }   
        }
        //楽器からプロフィールを抽出終了
        
        $profilesAllSearched = array();
        
        foreach($profiles_array as $profile){
            $prefectureSearched = $profile->prefecture_id;
            if(($prefectureSearched == $prefectureId) && ($profile->user_id != Auth::id())){
                array_push($profilesAllSearched, $profile);
            }
        }
        
        $profiles_unique = array_unique($profilesAllSearched);
        
        
        return view('general/search')->with([
            'profiles_unique'=>$profiles_unique,
            'instrument'=>$instrument,
            
            ]);
    }
    
    
    
    
}
