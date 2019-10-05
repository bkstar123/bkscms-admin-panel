<?php
/**
 * StoreAdmin - Form Request
 *
 * @author: tuanha
 * @last-mod: 05-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmin extends FormRequest
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
            'name' => 'bail|required|string|regex:/^[^<>]*$/|max:255',
            'email' => 'bail|required|string|email|max:255|unique:admins',
            'username' => 'bail|required|string|alpha_num|regex:/^[A-Za-z]\w*$/|min:4|max:255|unique:admins',
            'password' => 'bail|required|string|min:6|confirmed',
        ];
    }

    /**
     * customize the validation error message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.regex' => 'Username must start with an ascii letter',
            'name.regex' => 'Name cannot contain < or >'
        ];
    }
}
