<?php
/**
 * FormRequest - SendResetPasswordLink
 * For building complex validation rules and/or authorization rules for sending reset password link
 *
 * @author: tuanha
 * @last-mod: 15-Sept-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendResetPasswordLink extends FormRequest
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
            'email' => 'required|email',
            'g-recaptcha-response'=>'required|recaptcha',
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
            'g-recaptcha-response.recaptcha' => 'Please ensure that you are a human!',
            'g-recaptcha-response.required' => 'Re-captcha field is required'
        ];
    }
}
