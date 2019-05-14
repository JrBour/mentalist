<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * Create User
     *
     * @param Request $request
     * @return User|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'firstname' => 'required|string|min:2|max:255',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|min:2|max:255',
            'username' => 'required|string|min:2|max:150',
            'password' => 'required|string|min:6|max:255'
        ]);

        if ($validation->fails())
            return $validation->errors();

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
     * @return User|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, int $id)
    {
        $validation = Validator::make($request->all(), [
            'firstname' => 'required|string|min:2|max:255',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|min:2|max:255',
            'username' => 'required|string|min:2|max:150',
            'password' => 'required|string|min:6|max:255'
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        $user = User::find($id);
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
     * Destroy User
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        User::destroy($id);
    }
}
