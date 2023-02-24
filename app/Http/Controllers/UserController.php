<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', ['users' => $users, 'userActive' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'verified' => ['required', 'string', 'in:yes,no']
        ]);
        
        if ($validator->fails()) {
            return back()
            ->withErrors($validator);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->verified == "yes"){
            $user->email_verified_at = now();
        }
        
        $password = Hash::make($request->password);
        $user->password = $password;
        if($request->isAdmin == "yes"){
            $user->isAdmin = 1;
        }
        try{
            $user->save();
            return redirect('admin/user')->with('userCreated', 'The user was successfully created');
        }catch(\Exception $e){
            return redirect('admin/user')->withErrors(['userCreateError' => 'An error ocurred creating your user']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users,name,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'verified' => ['nullable', 'string', 'in:yes,no']
        ]);
        
        if ($validator->fails()) {
            return back()
            ->withErrors($validator);
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->verified == "yes"){
            $user->email_verified_at = now();
        }
        
        $password = Hash::make($request->password);
        $user->password = $password;
        if($request->isAdmin == "yes"){
            $user->isAdmin = 1;
        }else{
            $user->isAdmin = 0;
        }
        
        try{
            $user->update();
            return redirect('admin/user')->with('userUpdateSuccess', 'The user was successfully created');
        }catch(\Exception $e){
            return redirect('admin/user')->withErrors(['userCreateError' => 'An error ocurred creating your user']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
