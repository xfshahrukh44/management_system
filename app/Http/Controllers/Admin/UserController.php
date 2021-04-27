<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $users = $this->userService->paginate(env('PAGINATE'));
        $user_type = 'staff';
        return view('admin.user.user', compact('users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:4',
            'email' => 'required|unique:users,email',
        ]);
        
        if(!isset($request['type'])){
            $request['type'] = 'User';
        }

        $this->userService->create($request->all());

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
        }
        return $this->userService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        
        if(!(auth()->user()->id == $id || auth()->user()->type == "admin"))
        {
            return redirect()->back();
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'password' => 'sometimes',
            'email' => 'sometimes|unique:users,email,'.$request->hidden,
        ]);

        if($request->password == NULL){
            $request = Arr::except($request,['password']);
        }

        $this->userService->update($request->all(), $id);

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->userService->delete($id);

        if($request->user_type == 'rider'){
            return $this->getRiders($request);
        }
        
        return redirect()->back();
    }

    public function search_users(Request $request)
    {
        $query = $request['query'];
        
        $users = $this->userService->search_users($query);

        return view('admin.user.user', compact('users'));
    }
}