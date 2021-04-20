<?php

namespace App\Repositories;

use App\Exceptions\Comment\AllCommentException;
use App\Exceptions\Comment\CreateCommentException;
use App\Exceptions\Comment\UpdateCommentException;
use App\Exceptions\Comment\DeleteCommentException;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;

abstract class CommentRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
    
    public function create(array $data)
    {
        try 
        {
            $comment = $this->model->create($data);
            
            return [
                'comment' => $this->find($comment->id)
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
                    'message' => 'Could`nt find comment',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'comment' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteCommentException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find comment',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'comment' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateCommentException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $comment = $this->model::with('user', 'post')->find($id);
            if(!$comment)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find comment',
                ];
            }
            return [
                'success' => true,
                'comment' => $comment,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('user', 'post')->get();
        }
        catch (\Exception $exception) {
            throw new AllCommentException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllCommentException($exception->getMessage());
        }
    }

    public function search_comments($query)
    {
        // foreign fields
        // users
        $users = User::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $user_ids = [];
        foreach($users as $user){
            array_push($user_ids, $user->id);
        }
        // posts
        $posts = Post::select('id')->where('title', 'LIKE', '%'.$query.'%')->get();
        $post_ids = [];
        foreach($posts as $post){
            array_push($post_ids, $post->id);
        }

        // search block
        $comments = Comment::where('content', 'LIKE', '%'.$query.'%')
                        ->orWhereIn('user_id', $user_ids)
                        ->orWhereIn('post_id', $post_ids)
                        ->paginate(env('PAGINATION'));

        return $comments;
    }
    
}