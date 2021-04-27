<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BrandService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
        $this->middleware('auth');
    }

    public function index()
    {
        $brands = $this->brandService->paginate(env('PAGINATE'));
        return view('admin.brand.brand', compact('brands'));
    }

    public function all()
    {
        return $this->brandService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'sometimes',
            'image' => 'sometimes',
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_brands')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // create brand
        $brand = ($this->brandService->create($req))['brand']['brand'];

        if($request->dynamic){
            return $brand;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->brandService->find($_REQUEST['id']);
        }
        return $this->brandService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $brand = ($this->show($id))['brand'];

        $request->validate([
            'name' => 'sometimes',
            'image' => 'sometimes',
            'link' => 'sometimes',
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            Storage::disk('public_brands')->delete($brand->image);
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_brands')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $brand = ($this->brandService->update($req, $id))['brand']['brand'];
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->brandService->delete($id);

        return redirect()->back();
    }

    public function search_brands(Request $request)
    {
        $query = $request['query'];
        
        $brands = $this->brandService->search_brands($query);

        return view('admin.brand.brand', compact('brands'));
    }
    
}