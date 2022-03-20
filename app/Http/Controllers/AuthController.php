<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
   public function create(Request  $resquest){
       $array = ['error'=> ''];
       
       $rules = [
           'email' =>  'required | email | unique:users,email',
           'password' => 'required'
       ];
       
       //validando o email e senha do user
       $validator = Validator::make($resquest->all, $rules);

       if($validator->fails()){
           $array['error'] = $validator->messages();

           return $array;
       }
       //pegando os dados digistado pelo usuario
       $email = $resquest->input('email');
       $password = $resquest->input('password');
       
       //cadastrado o usuario no banco de dados
       $newUser = new User();
       $newUser->email = $email;
       $newUser->password = password_hash($password, PASSWORD_DEFAULT);
       $newUser->token = "";
       $newUser->save(); 
    
       return $array;
   }
   public function login(Request $resquest){
       $array = ['error'=>''];

       $creds = $resquest->only('email', 'password');

       if(Auth::attempt($creds)){
         
        $user = User::where('email', $email['email'])->first();

        $item = time().rand(0,9999);
        $token = $user->createToken($item)->plainTextToken;

        $array['token'] = $token;
        
       }else{
           $array['error'] = "E-mail e/ou senha incorretos";
       }

       return $array;
   }
   public function logout(){
       $array = ['error'=>''];

       $user =  $resquest->user();

       $user->tokens()->delete();

       return $array;
   }
}
