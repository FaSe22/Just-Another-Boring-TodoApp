<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|alpha_num|max:25',
            'description' => 'nullable|alpha_dash',
            'assignee_id' => 'nullable|numeric',
            'priority' => 'in:LOW,MEDIUM,HIGH',
            'due' => 'nullable|date',
            'state'=> 'in:TODO,IN_PROGRESS,ON_HOLD,DONE'
        ];
    }
}
