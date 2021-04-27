<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UnitService;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    private $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $units = $this->unitService->paginate(env('PAGINATE'));
        return view('admin.unit.unit', compact('units'));
    }

    public function all()
    {
        return $this->unitService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string',
        ]);

        $unit = ($this->unitService->create($request->all()))['unit']['unit'];

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->unitService->find($_REQUEST['id']);
        }
        return $this->unitService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $unit = ($this->show($id))['unit'];

        $request->validate([
            'name' => 'sometimes|string',
            'slug' => 'sometimes|string',
        ]);

        $unit = ($this->unitService->update($request->all(), $id))['unit']['unit'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->unitService->delete($id);

        return redirect()->back();
    }

    public function search_units(Request $request)
    {
        $query = $request['query'];
        
        $units = $this->unitService->search_units($query);

        return view('admin.unit.unit', compact('units'));
    }
}