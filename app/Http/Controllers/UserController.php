<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Retrieve a User collection
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Create new user
     *
     * @param Request $request
     * @return User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|string|min:2|max:255',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|min:2|max:255',
            'username' => 'required|integer|min:2|max:150',
            'password' => 'required|string|min:6|max:255'
        ]);

        $user = new User();
        $user->firstname = $request->firstname;
        $user->username= $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->admin    = true;
        $user->password = Hash::make($request->password);
        $user->email_hashed = md5( strtolower( trim($request->email )));

        $user->save();

        return $user;
    }

    /**
     * Retrieve single User
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return User::find($id);
    }

    /**
     * Update User
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'firstname' => 'required|string|min:2|max:255',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|min:2|max:255',
            'username' => 'required|integer|min:2|max:150',
            'password' => 'required|string|min:6|max:255'
        ]);

        $user = User::find($id);
        $user->firstname = $request->input('firstname');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->email_hashed = md5( strtolower( trim($request->input('email') )));

        $user->save();

        return $user;
    }


    /**
     * Destroy User
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        User::destroy($id);
    }
}
