<?php
/**
 * StorePermission - FormRequest
 *
 * @author: tuanha
 * @last-mod: 14-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermission extends FormRequest
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
            'permission' => 'bail|required|string|regex:/^[^<>]*$/|max:255|unique:permissions',
            'alias' => 'bail|required|string|regex:/^[^<> ]*$/|max:255|unique:permissions',
            'description' => 'bail|required|string|regex:/^[^<>]*$/',
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
            'permission.regex' => 'The permission cannot contain <, >',
            'permission.unique' => 'The permission has already existed',
            'alias.regex' => 'The permission alias cannot contain <, > or spaces',
            'alias.unique' => 'The permission alias has already existed',
            'description.regex' => 'The description cannot contain <, >',
        ];
    }
}
