<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $categories = $this->categoryService->paginate(env('PAGINATE'));
        return view('admin.category.category', compact('categories'));
    }

    public function all()
    {
        return $this->categoryService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = ($this->categoryService->create($request->all()))['category']['category'];
        
        if($request->dynamic){
            return $category;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->categoryService->find($_REQUEST['id']);
        }
        return $this->categoryService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $category = ($this->show($id))['category'];

        $request->validate([
            'name' => 'sometimes|string',
        ]);

        $category = ($this->categoryService->update($request->all(), $id))['category']['category'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->categoryService->delete($id);

        return redirect()->back();
    }

    public function search_categories(Request $request)
    {
        $query = $request['query'];
        
        $categories = $this->categoryService->search_categories($query);

        return view('admin.category.category', compact('categories'));
    }
}