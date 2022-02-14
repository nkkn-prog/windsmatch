<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'profile.nickname'=>'required|string|max:20',
            'profile.sex'=>'required|string',
            'profile.age_id'=>'required',
            'profile.prefecture_id'=>'required',
            'profile.musical_experience'=>'required|string|max:50',
            'profile.message'=>'required|string|max:300',
            'profile.user_id'=>'required',
            'instruments_array' =>'required',
            'genres_array'=>'required',
            
            
        ];
    }
    public function messages()
    {
    return [
        'nickname.required' => 'ニックネームが入力されていません!',
        'sex.required'  => '性別が入力されていません!',
        'age.required' => '年齢が入力されていません！',
        'user_id.required' => '既にプロフィール作成済みです！',
        'prefecture_id.required' => '居住地が選択されていません!',
        'musical_experience.required' => '楽器歴が入力されていません!',
        'message.required' => 'ひとことが入力されていません!',
    ];
    }
}
