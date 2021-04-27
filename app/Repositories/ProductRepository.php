<?php

namespace App\Repositories;

use App\Exceptions\Product\AllProductException;
use App\Exceptions\Product\CreateProductException;
use App\Exceptions\Product\UpdateProductException;
use App\Exceptions\Product\DeleteProductException;
use App\Models\Product;
use App\Models\User;

abstract class ProductRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Product $product)
    {
        $this->model = $product;
    }
    
    public function create(array $data)
    {
        try 
        {
            $product = $this->model->create($data);
            
            return [
                'product' => $this->find($product->id)
            ];
        }
        catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    public function delete($id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'product' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteProductException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'product' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateProductException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $product = $this->model::with('comments.user')->find($id);
            if(!$product)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product',
                ];
            }
            return [
                'success' => true,
                'product' => $product,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::all();
        }
        catch (\Exception $exception) {
            throw new AllProductException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllProductException($exception->getMessage());
        }
    }

    public function search_products($query)
    {
        // foreign fields
        // users
        $users = User::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $user_ids = [];
        foreach($users as $user){
            array_push($user_ids, $user->id);
        }

        // search block
        $products = Product::where('title', 'LIKE', '%'.$query.'%')
                        ->orWhereIn('user_id', $user_ids)
                        // ->orWhere('content', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $products;
    }
}