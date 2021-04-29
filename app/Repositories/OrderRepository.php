<?php

namespace App\Repositories;

use App\Exceptions\Order\AllOrderException;
use App\Exceptions\Order\CreateOrderException;
use App\Exceptions\Order\UpdateOrderException;
use App\Exceptions\Order\DeleteOrderException;
use App\Models\Order;

abstract class OrderRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Order $order)
    {
        $this->model = $order;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $order = $this->model->create($data);
            
            return [
                'order' => $this->find($order->id)
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
                    'message' => 'Could`nt find order',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'order' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteOrderException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find order',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'order' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateOrderException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $order = $this->model::find($id);
            if(!$order)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find order',
                ];
            }
            return [
                'success' => true,
                'order' => $order,
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
            throw new AllOrderException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllOrderException($exception->getMessage());
        }
    }

    public function search_orders($query)
    {
        // foreign fields

        // search block
        $orders = $this->model::where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('link', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $orders;
    }
}