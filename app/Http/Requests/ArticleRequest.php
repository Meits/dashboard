<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ArticleRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADD_MESS');
    }
    
     protected function getValidatorInstance()
     {
    	$validator = parent::getValidatorInstance();
    	
    	
    	
    	$validator->sometimes('image','required', function($input) {
        	
        	
        	if(!empty($input->image) || ((empty($input->image) && $this->route()->getName() !== 'article-update'))) {
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
        
        return [
            //
            'title' => 'required|max:255',
            'text' => 'required'
            
        ];
    }
}
