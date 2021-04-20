<?php

namespace App\Repositories;

use App\Exceptions\Post\AllPostException;
use App\Exceptions\Post\CreatePostException;
use App\Exceptions\Post\UpdatePostException;
use App\Exceptions\Post\DeletePostException;
use App\Models\Post;
use App\Models\User;

abstract class PostRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Post $post)
    {
        $this->model = $post;
    }
    
    public function create(array $data)
    {
        try 
        {
            $post = $this->model->create($data);
            
            return [
                'post' => $this->find($post->id)
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
                    'message' => 'Could`nt find post',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'post' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeletePostException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find post',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'post' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdatePostException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $post = $this->model::with('user')->find($id);
            if(!$post)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find post',
                ];
            }
            return [
                'success' => true,
                'post' => $post,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('user')->get();
        }
        catch (\Exception $exception) {
            throw new AllPostException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllPostException($exception->getMessage());
        }
    }

    public function search_posts($query)
    {
        // foreign fields
        // users
        $users = User::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $user_ids = [];
        foreach($users as $user){
            array_push($user_ids, $user->id);
        }

        // search block
        $posts = Post::where('title', 'LIKE', '%'.$query.'%')
                        ->orWhereIn('user_ids', $user_idss)
                        ->orWhere('content', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $posts;
    }
    
}