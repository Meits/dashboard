<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       
       
       return \Auth::user()->canDo('EDIT_USER') ||\Auth::user()->canDo('ADD_USER') || ($this->route()->parameter('user')->id == \Auth::user()->id);
    }
	
	protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
    
	    $validator->sometimes('password', 'required|min:6|confirmed', function($input)
	    {
			
			if(!empty($input->password) || ((empty($input->password) && $this->route()->getName() !== 'users_update'))) {
				return TRUE;
			}
			
			return FALSE;
	    });

	    return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = (isset($this->route()->parameter('user')->id)) ? $this->route()->parameter('user')->id : '';
		
		return [
             'fullname' => 'required|max:255',
			 'login' => 'required|max:255',
             'email' => 'required|email|max:255|unique:users,email,'.$id,
             'birthday' => 'required|date_format:Y-m-d|max:255',
             'address' => 'required|max:255',
             'city' => 'required|max:255',
             'state' => 'required|max:255',
             'country' => 'required|max:255',
             'zip' => 'required|max:255'
        ];
    }
}
