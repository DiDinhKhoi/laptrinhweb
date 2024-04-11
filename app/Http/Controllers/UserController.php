<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
    public function register()
    {
        return view('user.register');
    }
    public function login()
    {
        return view('user.login');
    }
    public function logOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
    public function Checklogin(Request $request)
    {
        $request->validate([
            'email' => ['nullable', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('list')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }
    public function postUser(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => ['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
        'phone' => ['nullable', 'regex:/^0[0-9]{9}$/'],
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'password' => ['required', 'string', 'min:8'],
    ]);

    if ($validator->fails()) {
        return redirect('register')
            ->withErrors($validator)
            ->withInput();
    }

    $data = $request->all();

    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $avatarName = time() . '_' . $avatar->getClientOriginalName();
        $avatar->move(public_path('avatars'), $avatarName);
        $data['avatar'] = $avatarName;
    }

    // Create a new user record in the database
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'password' => Hash::make($data['password']),
        'avatar' => $data['avatar'] ?? null, // Default to null if avatar is not present
    ]);

    // Redirect the user to the login page
    return redirect('login');
}

    public function listUser()
    {
        if (Auth::check()) {
            $users = User::paginate(3);
            return view('user.list', ['users' => $users]);
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
    public function showUser(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::find($user_id);
        return view('user.show', ['user' => $user]);
    }
    // Thêm
    public function create()
    {
        return view('user.create');
    }
    public function createUser(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'email' => ['nullable', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'phone' => ['nullable', 'regex:/^0[0-9]{9}$/'],
            'password' => ['required', 'string', 'min:8'],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = $request->all();

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        // Create a new user record in the database
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'avatar' => $data['avatar'] ?? null, // Default to null if avatar is not present
        ]);

        // Redirect the user to the login page
        return redirect('/list')->with('message', 'User added succesfully');
    }
    public function delete(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::destroy($user_id);

        return redirect("list")->withSuccess('You have signed-in');
    }
    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('user.update', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id . '|max:255',
            'phone' => ['nullable', 'regex:/^0[0-9]{9}$/'],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        // Update the user record in the database
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'avatar' => $data['avatar'] ?? $user->avatar, // Use the existing avatar if not provided
        ]);

        // Redirect the user to the list page
        return redirect('/list')->with('message', 'User updated succesfully');
    }
}
