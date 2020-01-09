<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function chagnePassword()
    {
    	return view('changePassword');
    }

    public function updatePassword(Request $request)
    {
    	$request->validate([
	        'oldPassword' => 'required',
	        'password' => 'required|min: 8|confirmed',
	    ]);
	    $userPass= Auth::User()->password; 
	    
	    if(Hash::check($request->oldPassword, $userPass)) 
	    {
	    	$updatePass= User::where('id', auth()->id())->update([
	    		'password'=> Hash::make($request->password)
	    	]);

	    	if ($updatePass)
	    	{
	    		return redirect('/home')->with('success','password changed successfully.. :)');
	    	}
	    	return redirect('/home')->with('error','Something wrong..!!');
	    }
	    return redirect('/home')->with('error','old password you have entered is incorrect  !!!');

    }

    public function editUserDetails()
    {
    	$userDetails = User::where('id', auth()->id())->first();
    	return view('editUserDetails')->with(['userDetails' => $userDetails]);
    }

    public function updateDetails(Request $request)
    {
    	$request->validate([
	        'name' => 'required'
	    ]);

	    $updateD= User::where('id', auth()->id())->update([
    		'name'=> $request->name
    	]);

    	if ($updateD)
    	{
    		return redirect('/home')->with('success','name updated successfully.. :)');
    	}
    	return redirect('/home')->with('error','Something wrong..!!');
    }
}
