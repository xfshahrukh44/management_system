<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductCommentService;
use App\Services\UserService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;

class ProductCommentController extends Controller
{
    private $productCommentService;
    private $userService;
    private $productService;

    public function __construct(ProductCommentService $productCommentService, UserService $userService, ProductService $productService)
    {
        $this->productCommentService = $productCommentService;
        $this->userService = $userService;
        $this->productService = $productService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $product_comments = $this->productCommentService->paginate(env('PAGINATE'));
        // return view('admin.product_comment.product_comment', compact('product_comments'));
    }

    public function all()
    {
        return $this->productCommentService->all();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'product_id' => 'required|int',
            'content' => 'required',
            'is_approved' => 'sometimes|int',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $product_comment = ($this->productCommentService->create($request->all()))['product_comment']['product_comment'];

        // return redirect()->back();
        return 0;
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->productCommentService->find($_REQUEST['id']);
        }
        return $this->productCommentService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $product_comment = ($this->show($id))['product_comment'];

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|int',
            'product_id' => 'sometimes|int',
            'content' => 'sometimes',
            'is_approved' => 'sometimes|int',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $product_comment = ($this->productCommentService->update($request->all(), $id))['product_comment']['product_comment'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $this->productCommentService->delete($id);

        // return redirect()->back();
        return 0;
    }

    public function search_product_comments(Request $request)
    {
        $query = $request['query'];
        
        $product_comments = $this->productCommentService->search_product_comments($query);

        return view('admin.product_comment.product_comment', compact('product_comments'));
    }

    public function approve_product_comment(Request $request)
    {
        if(!isset($request['id'])){
            return 0;
        }

        return $this->productCommentService->approve_product_comment($request['id']);
    }
}