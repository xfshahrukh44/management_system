<?php

namespace App\Repositories;

use App\Exceptions\ProductImage\AllProductImageException;
use App\Exceptions\ProductImage\CreateProductImageException;
use App\Exceptions\ProductImage\UpdateProductImageException;
use App\Exceptions\ProductImage\DeleteProductImageException;
use App\Models\ProductImage;

abstract class ProductImageRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(ProductImage $product_image)
    {
        $this->model = $product_image;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $product_image = $this->model->create($data);
            
            return [
                'product_image' => $this->find($product_image->id)
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
                    'message' => 'Could`nt find product_image',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'product_image' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteProductImageException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product_image',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'product_image' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateProductImageException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $product_image = $this->model::find($id);
            if(!$product_image)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product_image',
                ];
            }
            return [
                'success' => true,
                'product_image' => $product_image,
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
            throw new AllProductImageException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllProductImageException($exception->getMessage());
        }
    }
}