<?php
/**
 * FormRequest - UpdateRole
 * For building complex validation rules for updating roles
 *
 * @author: tuanha
 * @last-mod: 14-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Requests;

use Bkstar123\BksCMS\AdminPanel\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRole extends FormRequest
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
            'role' => ['bail','required', 'string', 'regex:/^[^<>]*$/','max:255'],
            'description' => 'bail|required|string|regex:/^[^<>]*$/',
        ];
        $role = $this->route('role');
        if ($this->input('role') != $role->role) {
            array_push($rules['role'], 'unique:roles');
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
            'description.regex' => 'Description cannot contain < or >',
            'role.regex' => 'Role name cannot contain < or >',
            'role.unique' => 'This role name has already existed',
        ];
    }
}
