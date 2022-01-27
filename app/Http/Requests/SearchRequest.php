<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            // 'profile.sex'=>'required|string',
            // 'profile.prefecture_id'=>'required',
            // 'instruments_array' =>'required',
            // 'genres_array'=>'required'
        ];
    }
}
