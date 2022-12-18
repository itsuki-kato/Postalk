<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'post_title.required' => MessageConsts::ERROR_POST_TITLE_REQUIRED,
            'post_text.required' => MessageConsts::ERROR_POST_TEXT_REQUIRED,
            'post_img_url.image' => MessageConsts::ERROR_POST_IMG_FILE_TYPE,
            'post_img_url.length.max:100' => MessageConsts::ERROR_POST_IMG_LENGTH
        ];
    }
}
