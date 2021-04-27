<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\ProductImageService;
use App\Services\CategoryService;
use App\Services\BrandService;
use App\Services\UnitService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    private $productService;
    private $productImageService;
    private $categoryService;
    private $brandService;
    private $unitService;

    public function __construct(ProductService $productService, ProductImageService $productImageService, CategoryService $categoryService, BrandService $brandService, UnitService $unitService)
    {
        $this->productService = $productService;
        $this->productImageService = $productImageService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->unitService = $unitService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $products = $this->productService->paginate(env('PAGINATE'));
        $categories = $this->categoryService->all();
        $brands = $this->brandService->all();
        $units = $this->unitService->all();
        return view('admin.product.product', compact('products', 'categories', 'brands', 'units'));
    }

    public function all()
    {
        return $this->productService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|int',
            'brand_id' => 'required|int',
            'unit_id' => 'required|int',
            'price' => 'required',
            'image' => 'required',
            'description' => 'sometimes|string',
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_products')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $product = ($this->productService->create($req))['product']['product'];

        // product_images (multiple)
        if($request->product_images){
            $product_images = [];
            foreach($request->product_images as $product_image){
                $image = $product_image;
                $imageName = Str::random(10).'.png';
                Storage::disk('public_products')->put($imageName, \File::get($image));
                array_push($product_images, $imageName);
            }
            foreach($product_images as $product_image){
                $this->productImageService->create([
                    'product_id' => $product->id,
                    'location' => $product_image,
                ]);
            }
        }

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->productService->find($_REQUEST['id']);
        }
        return $this->productService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $product = ($this->show($id))['product'];

        $request->validate([
            'name' => 'sometimes|string',
            'category_id' => 'sometimes|int',
            'brand_id' => 'sometimes|int',
            'unit_id' => 'sometimes|int',
            'price' => 'sometimes',
            'image' => 'sometimes',
            'description' => 'sometimes|string',
        ]);

        
        // image work
        $req = Arr::except($request->all(),['image']);

        // image
        if($request->image){
            Storage::disk('public_products')->delete($product->image);
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_products')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $product = ($this->productService->update($req, $id))['product']['product'];

        // product_images (multiple)
        if($request->product_images){
            $product_images = [];
            foreach($request->product_images as $product_image){
                $image = $product_image;
                $imageName = Str::random(10).'.png';
                Storage::disk('public_products')->put($imageName, \File::get($image));
                array_push($product_images, $imageName);
            }
            foreach($product_images as $product_image){
                $this->productImageService->create([
                    'product_id' => $product->id,
                    'location' => $product_image,
                ]);
            }
        }

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->productService->delete($id);

        return redirect()->back();
    }

    public function search_products(Request $request)
    {
        $query = $request['query'];
        
        $products = $this->productService->search_products($query);
        $categories = $this->categoryService->all();
        $brands = $this->brandService->all();
        $units = $this->unitService->all();

        return view('admin.product.product', compact('products', 'categories', 'brands', 'units'));
    }
}