<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use DB;
use Response;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    /**
     * Display the user's profile form.
     */
    public function edit(User $user): View
    {

        // Get the authenticated user
        $user = auth()->user() ?? collect(); 

        // Return the view with the user's data
        return view('pages.profile.form', compact('user'));
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, User $user)
    {

        $user = auth()->user() ?? collect(); 

        $request->validate([
            'firstname' => 'string',
            'lastname' => 'string',
            'old_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|confirmed',
        ]);

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        if ($request->filled('old_password') && $request->filled('new_password')) {
            $user->password = bcrypt($request->new_password);
        }

        $user->save();
    
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
        
    }

}
