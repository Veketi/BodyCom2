<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{
    public function signUpSubmit(Request $request){
        
        //validação
        $request->validate(
            [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => [
                    'required',
                    'confirmed:password_confirmation',
                    function($attribute, $value, $fail){
                        if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $value)){
                            $fail('A senha precisa conter uma letra maiúcula, uma minúscula, um caractere especial e pelo menos 8 caracteres!');
                        }
                    }
                ]
            ],
            [
                'name.required' => 'O campo de usuário é obrigatório!',
                'name.min' => 'O nome deve ter pelo menos três caracteres!',
                'email.required' => 'O campo de email é obrigatório!',
                'email.email' => 'O email digitado tem quer ser válido!',
                'password.required' => 'O campo de senha é obrigatório!',                 'password.confirmed' => 'As senhas não são iguais!'
            ]
        );

        //input do usuário
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        //checar se usuário já existe
        $user = User::where('email', $email)
                        ->where('deleted_at', NULL)
                        ->first();
        if($user == true){
            return back()->with('loginError', 'Usuário já cadastrado!');
        }

        //adicionar novo usuário
        $user= new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //atualizar o ultimo login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //logar usuário
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);
       
        //redirecionar para home
        return redirect()->to('/');
    }

    public function loginSubmit(Request $request){
       
        //validação
        $request->validate(
            [
                'email' => 'required|email',
                'password' => [
                    'required',
                    function($attribute, $value, $fail){
                        if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $value)){
                            $fail('A senha precisa conter uma letra maiúcula, uma minúscula, um caractere especial e pelo menos 8 caracteres!');
                        }
                    }
                ]
            ],
            [
                'email.required' => 'O campo de email é obrigatório!',
                'email.email' => 'O email digitado tem quer ser válido!',
                'password.required' => 'O campo de senha é obrigatório!',
                'password.confirmed' => 'As senhas não são iguais!'
            ]
        );

        //input do usuário
        $email = $request->input('email');
        $password = $request->input('password');

        //checar se usuário já existe
        $user = User::where('email', $email)
                        ->where('deleted_at', NULL)
                        ->first();
        if(!$user){
            return back()->with('loginError', 'Usuário ou senha incorretos!');
        }

        //checar se a senha está correta
        if(!password_verify($password, $user->password)){
            return back()->with('loginError', 'Usuário ou senha incorretos!');
        }
       
        //atualizar o ultimo login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();
        
        //logar usuário
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);
       
        //redirecionar para home
        return redirect()->to('/');
    }

    public function logout(){
        //logout from the application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
