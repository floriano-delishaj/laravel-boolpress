<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\SlugGenerator;
use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        //per avere i risultati solo dei post dell'utente loggato
        //$posts = Post::where("user_id", Auth::user()->id)->get();;
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|min:5",
            "content" => "required|min:10",
            "path_img" => "nullable",
            "category_id" => 'nullable',
            "tags" => 'nullable',
        ]);

        $post = new Post();
        $post->fill($data);

        $post->slug = $this->generateUniqueSlug($post->title);
        $post->user_id = Auth::user()->id;

        $post->save();

        if(key_exists('path_img', $data)) {
            $post->path_img = Storage::put('postCovers', $data['path_img']);
            $post->save();
        }

        if(key_exists("tags", $data)) {
            $post->tags()->attach($data['tags']);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($slug)
    {
        $post = Post::where("slug", $slug)->first();
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $data = $request->validate([
            "title" => "required|min:5",
            "content" => "required|min:10",
            "path_img" => "nullable",
            "category_id" => 'nullable',
            "tags" => "nullable|exists:tags,id"
        ]);

        $post = Post::where("slug", $slug)->first();

        if($data['title'] !== $post->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        $post->update($data);

        if (key_exists('path_img', $data)) {

            if($post->path_img){
                Storage::delete($post->path_img);
            }

            $post->path_img = Storage::put('postCovers', $data['path_img']);
            $post->save();
        }

        if(key_exists("tags", $data)) {
            $post->tags()->sync($data['tags']);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', ['post' => $post->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        if ($post->path_img) {
            Storage::delete($post->path_img);
        }
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
