<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Reply;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create',new Reply);
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException('You are replying too frequently . Please take a break.');
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamFree'
        ];
    }

    public function persist($thread)
    {
        return $thread->addReply([
            'body'=> request('body'),
            'user_id'=> auth()->user()->id,
           ])->load('owner');
    }
}
