<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RatingService;
use App\Services\UserService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class RatingController extends Controller
{
    private $ratingService;
    private $userService;
    private $productService;

    public function __construct(RatingService $ratingService, UserService $userService, ProductService $productService)
    {
        $this->ratingService = $ratingService;
        $this->userService = $userService;
        $this->productService = $productService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $ratings = $this->ratingService->paginate(env('PAGINATE'));
    }

    public function all()
    {
        return $this->ratingService->all();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'product_id' => 'required|int',
            'stars' => 'required|int',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $rating = ($this->ratingService->create($request->all()))['rating']['rating'];

        // return redirect()->back();
        return 0;
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->ratingService->find($_REQUEST['id']);
        }
        return $this->ratingService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $rating = ($this->show($id))['rating'];

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|int',
            'product_id' => 'sometimes|int',
            'stars' => 'sometimes|int',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $rating = ($this->ratingService->update($request->all(), $id))['rating']['rating'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $this->ratingService->delete($id);

        // return redirect()->back();
        return 0;
    }
}