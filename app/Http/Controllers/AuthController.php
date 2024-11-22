<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        $models = User::orderBy('id', 'ASC')->paginate(10);
        return view('admin.users', ['models' => $models]);
    }

    public function goLogin()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:3',
        ]);

        $data['password'] = bcrypt($data['password']);
        User::create($data);
        
        return redirect()->route('users.page')->with('success', 'User muvaffaqiyatli yaratildi');
    }

    public function update(Request $request, User $user)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    
        $user->name = $request->input('name');
        $user->email = $request->input('email');
    

        if ($request->has('password') && $request->password) {
            $user->password = bcrypt($request->input('password'));
        }
    
        $user->save();
    
        return redirect()->route('users.page')->with('success', 'User updated successfully');
    }
    
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if ($user->role == 'admin') {
                return redirect()->route('admin.index');
            } elseif($user->role == 'user') {
                return redirect()->route('main.page');
            }
            return back()->withErrors([
                'role' => 'Invalid role.',
            ]);
        }
    
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
    
    
    public function destroy(User $user)
    {
        $user->delete(); 
        return redirect()->route('main.page')->with('success', 'User muvaffaqiyatli o\'chirildi');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.page');
    }
}