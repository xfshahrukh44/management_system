<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private $orderService;
    private $userService;

    public function __construct(OrderService $orderService, UserService $userService)
    {
        $this->orderService = $orderService;
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = $this->orderService->paginate(env('PAGINATE'));
        $users = $this->userService->all();
        return view('admin.order.order', compact('orders', 'users'));
    }

    public function all()
    {
        return $this->orderService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'int|required',
            'total' => 'required',
            'description' => 'sometimes',
            'status' => 'sometimes',
        ]);

        // create order
        $order = ($this->orderService->create($request->all()))['order']['order'];

        if($request->dynamic){
            return $order;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->orderService->find($_REQUEST['id']);
        }
        return $this->orderService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $order = ($this->show($id))['order'];

        $request->validate([
            'user_id' => 'int|sometimes',
            'total' => 'sometimes',
            'description' => 'sometimes',
            'status' => 'sometimes',
        ]);

        $order = ($this->orderService->update($request->all(), $id))['order']['order'];
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->orderService->delete($id);

        return redirect()->back();
    }

    public function search_orders(Request $request)
    {
        $query = $request['query'];
        
        $orders = $this->orderService->search_orders($query);
        $users = $this->userService->all();

        return view('admin.order.order', compact('orders', 'users'));
    }
    
}