<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\SiteController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends SiteController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->template = config('settings.theme').'.pass-reset';
    }
    
    public function showResetForm(Request $request, $token = null)
    {
        
       	$this->vars = array_add($this->vars,'token', $token);
       	$this->vars = array_add($this->vars,'email', $request->email);
        
        return $this->renderOutput();
    }
}
