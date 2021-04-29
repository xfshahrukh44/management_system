<?php

namespace App\Repositories;

use App\Exceptions\OrderProduct\AllOrderProductException;
use App\Exceptions\OrderProduct\CreateOrderProductException;
use App\Exceptions\OrderProduct\UpdateOrderProductException;
use App\Exceptions\OrderProduct\DeleteOrderProductException;
use App\Models\OrderProduct;

abstract class OrderProductRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(OrderProduct $order_product)
    {
        $this->model = $order_product;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $order_product = $this->model->create($data);
            
            return [
                'order_product' => $this->find($order_product->id)
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
                    'message' => 'Could`nt find order_product',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'order_product' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteOrderProductException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find order_product',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'order_product' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateOrderProductException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $order_product = $this->model::find($id);
            if(!$order_product)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find order_product',
                ];
            }
            return [
                'success' => true,
                'order_product' => $order_product,
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
            throw new AllOrderProductException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllOrderProductException($exception->getMessage());
        }
    }
}