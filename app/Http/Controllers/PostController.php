<?php
namespace App\Http\Controllers;
use App\Models\Post;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use ApiResponseTrait;
    
    public function __construct()
    {
        $this->middleware('auth');      
    }

    public function index(Request $request)
    {
        $query = Post::with('user');
        
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
    
        $posts = $query->latest()->paginate(10);
        
        return view('pages.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('pages.posts.show', compact('post'));
    }

    public function create()
    {
        return view('pages.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
        ]);

        Auth::user()->posts()->create($request->only('title', 'content'));
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('pages.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
        ]);
        $post->update($request->only('title', 'content'));
        return redirect()->route('posts.index')->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted.');
    }
}
