<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Mail\NewPostCreateMail;
use App\Post;
use App\Tag;
use App\Traits\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use SlugGenerator;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(6);

        $posts->load('user','category', 'tags');

        $posts->each( function ($post) {
            //se il post ha un path_img allora sostituisco il valore con l'url completo per quell'immagine
            if($post->path_img) {
                $post->path_img = asset("storage/" . $post->path_img);
            }
        });

        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return response()->json([
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|min:5|max:120",
            "content" => "required|min:10",
            "path_img" => "nullable|mimes:png,jpg,jpeg",
            "category_id" => 'nullable',
            "tags" => "nullable|exists:tags,id"
        ]);

        $newPost = new Post();
        $newPost->fill($data);
        $newPost->user_id = Auth::user()->id;
        $newPost->slug = $this->generateUniqueSlug($data['title']);

        if(key_exists("path_img", $data)) {
            $newPost->path_img = Storage::put('postCoversVueJs', $data['path_img']);
        }

        $newPost->save();

        if(key_exists('tags', $data)) {
            $newPost->tags()->attach($data['tags']);
        }

        $newPost->load('user');
        Mail::to('admin@gmail.com')
            ->send(new NewPostCreateMail($newPost));

        return response()->json($newPost);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['user','category','tags'])
            ->first();

        // $post->load('user','category','tags');
        // fa la stessa cosa del with
        if($post->path_img) {
            $post->path_img = asset("storage/" . $post->path_img);
        }

        if (!$post) {
            abort(404);
        }

        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
