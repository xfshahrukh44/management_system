<?php

namespace App\Repositories;

use App\Exceptions\Rating\AllRatingException;
use App\Exceptions\Rating\CreateRatingException;
use App\Exceptions\Rating\UpdateRatingException;
use App\Exceptions\Rating\DeleteRatingException;
use App\Models\Rating;
use App\Models\User;
use App\Models\Post;

abstract class RatingRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Rating $rating)
    {
        $this->model = $rating;
    }
    
    public function create(array $data)
    {
        try 
        {
            $rating = $this->model->create($data);
            
            return [
                'rating' => $this->find($rating->id)
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
                    'message' => 'Could`nt find rating',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'rating' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteRatingException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find rating',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'rating' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateRatingException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $rating = $this->model::with('user', 'prooduct')->find($id);
            if(!$rating)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find rating',
                ];
            }
            return [
                'success' => true,
                'rating' => $rating,
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
            throw new AllRatingException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllRatingException($exception->getMessage());
        }
    }
}