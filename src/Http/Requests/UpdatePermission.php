<?php
/**
 * UpdatePermission - FormRequest
 *
 * @author: tuanha
 * @last-mod: 20-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermission extends FormRequest
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
        $rules = [
            'permission' => ['bail','required', 'string', 'regex:/^[^<>]*$/','max:255'],
            'alias' => ['bail','required', 'string', 'regex:/^[^<> ]*$/','max:255'],
            'description' => 'bail|required|string|regex:/^[^<>]*$/',
        ];
        $permission = $this->route('permission');
        if ($this->input('permission') != $permission->permission) {
            array_push($rules['permission'], 'unique:permissions');
        }
        return $rules;
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
            'description.regex' => 'The permission description cannot contain <, >',
        ];
    }
}
