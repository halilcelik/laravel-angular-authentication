<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\User; 
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\DB;




class ChangePasswordController extends Controller
{
    public function process(ChangePasswordRequest $request)
    {
        return $this->getPasswordResetTableRow($request)->count()> 0 ? $this->changePassword($request) 
        : $this->tokenNotFoundResponse();
    }
    
    private function getPasswordResetTableRow($request)
    {
        return DB::table('password_resets')->where(['email'=> $request->email,'token'
        =>$request->resetToken]);
    }
   
    private function tokenNotFoundResponse()
    { 
        return response()->json(['error' => 'Token or Email is incorrect'],
    Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function changePassword($request)
    { dd(true);
        $user = User::whereEmail($request->email)->first();
        return $user;
        $user->update(['password'=> $request->password]);
        $this->getPasswordResetTableRow($request)->delete();
        return response()->json(['data' => 'Password Successfuly Changed'],
    Response::HTTP_CREATED); 
    }
}
