<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Services\UserService;
use App\Services\PostService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    private $commentService;
    private $userService;
    private $postService;

    public function __construct(CommentService $commentService, UserService $userService, PostService $postService)
    {
        $this->commentService = $commentService;
        $this->userService = $userService;
        $this->postService = $postService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $comments = $this->commentService->paginate(env('PAGINATE'));
        // return view('admin.comment.comment', compact('comments'));
    }

    public function all()
    {
        return $this->commentService->all();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'post_id' => 'required|int',
            'content' => 'required',
            'is_approved' => 'sometimes|int',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $comment = ($this->commentService->create($request->all()))['comment']['comment'];

        // return redirect()->back();
        return 0 ;
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->commentService->find($_REQUEST['id']);
        }
        return $this->commentService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $comment = ($this->show($id))['comment'];

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|int',
            'post_id' => 'sometimes|int',
            'content' => 'sometimes',
            'is_approved' => 'sometimes|int',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $comment = ($this->commentService->update($req, $id))['comment']['comment'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->commentService->delete($id);

        return redirect()->back();
    }

    public function search_comments(Request $request)
    {
        $query = $request['query'];
        
        $comments = $this->commentService->search_comments($query);

        return view('admin.comment.comment', compact('comments'));
    }

    public function approve_comment(Request $request)
    {
        if(!isset($request['id'])){
            return 0;
        }

        return $this->commentService->approve_comment($request['id']);
    }
}