<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use DB;
use Response;
use App\Services\SensorOfflineService;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all() ?? collect();
      
        return view('pages.configurations.users.index',compact('users') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userTypes = UserType::all() ?? collect();
        return view('pages.configurations.users.form',compact('userTypes')  );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( self::formRule(),self::errorMessage(), self::changeAttributes());

        $user = new User($request->all());
        
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( User $user)
    {
        $userTypes = UserType::all() ?? collect();
        
        return view('pages.configurations.users.form',compact('user','userTypes')  );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
       
        $request->validate( self::formRule($user->id),self::errorMessage(), self::changeAttributes());

        if (!$request->filled('password')) {
            $request->request->remove('password');
        } else {
            
            $request->merge([
                'password' => $request->input('password')
            ]);
        }
        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    { 
        DB::enableQueryLog();
        $id                    = $request->id;
        $user                  = User::findOrFail($id);       
        $user->save();
        $user->delete();
        
        (new SensorOfflineService())->delete(DB::getQueryLog(), $user->id);
        
        return Response::json($user);
    }

    public function formRule($id =false){
        return [
            'firstname' => ['required','string'],
            'lastname' => ['required','string'],
            'user_type_id' => ['required','exists:user_types,id'],
            'email' => ['required','email',Rule::unique('users')->ignore( $id ? $id : "")],
            'password' => ['required','string','min:8','confirmed'],
        ];
    }

    public function errorMessage(){
        return [
            'firstname.required' => 'First Name is required',
            'lastname.required' => 'Last Name is required',
            'user_type_id.required' => 'User Type is required',
            'user_type_id.exists' => 'User Type does not exist',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password does not match',

        ];
    } 

    public function changeAttributes(){
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'user_type_id' => 'User Type',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
