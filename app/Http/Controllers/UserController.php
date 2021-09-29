<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function create(){
        return view('user.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        //dd($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => /*Hash::make($request->password), или Хелпер bcrypt*/ bcrypt($request->password),
        ]);

        session()->flash('success', 'Регистрация ок!');
        Auth::login($user); // сразу авторизируем пользователя чтобы не вносил данные заново

        return redirect()->home();
    }

    public function loginForm(){
        return view('user.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt([ // сам логин
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            session()->flash('success', 'Пользователь был авторизован');
            if(Auth::user()->is_admin){ // проверяем если isAdmin
                return redirect()->route('admin.index'); // в админку
            } else {
                return redirect()->home(); // домой
            }
        }

        return redirect()->back()->with('error', 'Неверный логин или пароль'); // назад при ошибке

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('register.create');
    }
}
