<?php

namespace App\Repositories;

use App\Exceptions\ProductComment\AllProductCommentException;
use App\Exceptions\ProductComment\CreateProductCommentException;
use App\Exceptions\ProductComment\UpdateProductCommentException;
use App\Exceptions\ProductComment\DeleteProductCommentException;
use App\Models\ProductComment;
use App\Models\User;
use App\Models\Product;

abstract class ProductCommentRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(ProductComment $product_comment)
    {
        $this->model = $product_comment;
    }
    
    public function create(array $data)
    {
        try 
        {
            $product_comment = $this->model->create($data);
            
            return [
                'product_comment' => $this->find($product_comment->id)
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
                    'message' => 'Could`nt find product_comment',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'product_comment' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteProductCommentException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product_comment',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'product_comment' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateProductCommentException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $product_comment = $this->model::with('user', 'product')->find($id);
            if(!$product_comment)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product_comment',
                ];
            }
            return [
                'success' => true,
                'product_comment' => $product_comment,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('user', 'product')->get();
        }
        catch (\Exception $exception) {
            throw new AllProductCommentException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllProductCommentException($exception->getMessage());
        }
    }

    public function search_product_comments($query)
    {
        // foreign fields
        // users
        $users = User::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $user_ids = [];
        foreach($users as $user){
            array_push($user_ids, $user->id);
        }
        // products
        $products = Product::select('id')->where('title', 'LIKE', '%'.$query.'%')->get();
        $product_ids = [];
        foreach($products as $product){
            array_push($product_ids, $product->id);
        }

        // search block
        $product_comments = ProductComment::where('content', 'LIKE', '%'.$query.'%')
                        ->orWhereIn('user_id', $user_ids)
                        ->orWhereIn('product_id', $product_ids)
                        ->paginate(env('PAGINATION'));

        return $product_comments;
    }

    public function approve_product_comment($id)
    {
        $product_comment = $this->model->find($id);
        $product_comment->is_approved = 1;
        $product_comment->save();
        return 0;
    }
    
}