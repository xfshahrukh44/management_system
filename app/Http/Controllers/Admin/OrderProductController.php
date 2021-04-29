<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderProductService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class OrderProductController extends Controller
{
    private $orderProductService;

    public function __construct(OrderProductService $orderProductService)
    {
        $this->orderProductService = $orderProductService;
        $this->middleware('auth');
    }

    public function index()
    {
        // $order_products = $this->orderProductService->paginate(env('PAGINATE'));
        // return view('admin.order_product.order_product', compact('order_products'));
    }

    public function all()
    {
        return $this->orderProductService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|int',
            'product_id' => 'required|int',
            'quantity' => 'required',
        ]);

        // create order_product
        $order_product = ($this->orderProductService->create($request->all()))['order_product']['order_product'];

        if($request->dynamic){
            return $order_product;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->orderProductService->find($_REQUEST['id']);
        }
        return $this->orderProductService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $order_product = ($this->show($id))['order_product'];

        $request->validate([
            'order_id' => 'sometimes|int',
            'product_id' => 'sometimes|int',
            'quantity' => 'sometimes',
        ]);

        $order_product = ($this->orderProductService->update($request->all(), $id))['order_product']['order_product'];
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->orderProductService->delete($id);

        return redirect()->back();
    }
}