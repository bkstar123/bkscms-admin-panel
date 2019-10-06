<?php
/**
 * ChangePassword - Form Request
 *
 * @author: tuanha
 * @last-mod: 05-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
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
            'password' => 'required|min:6|confirmed'
        ];
    }
}
