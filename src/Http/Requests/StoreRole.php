<?php
/**
 * FormRequest - StoreRole
 * For building complex validation rules for creating roles
 *
 * @author: tuanha
 * @last-mod: 14-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
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
            'role' => 'bail|required|string|regex:/^[^<>]*$/|max:255|unique:roles',
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
            'description.regex' => 'Description cannot contain < or >',
            'role.regex' => 'Role name cannot contain < or >',
            'role.unique' => 'This role name has already existed',
        ];
    }
}
