<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    private $postService;
    private $userService;

    public function __construct(PostService $postService, UserService $userService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $posts = $this->postService->paginate(env('PAGINATE'));
        return view('admin.post.post', compact('posts'));
    }

    public function all()
    {
        return $this->postService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|int',
            'title' => 'required|string',
            'content' => 'required',
            'image' => 'sometimes'
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_posts')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $post = ($this->postService->create($req))['post']['post'];

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->postService->find($_REQUEST['id']);
        }
        return $this->postService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $post = ($this->show($id))['post'];

        $request->validate([
            'user_id' => 'sometimes|int',
            'title' => 'sometimes|string',
            'content' => 'sometimes',
            'image' => 'sometimes'
        ]);

        
        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            if($post->image != NULL){
                Storage::disk('public_posts')->delete($post->image);
            }
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_posts')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $post = ($this->postService->update($req, $id))['post']['post'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->postService->delete($id);

        return redirect()->back();
    }

    public function search_posts(Request $request)
    {
        $query = $request['query'];
        
        $posts = $this->postService->search_posts($query);

        return view('admin.post.post', compact('posts'));
    }
}