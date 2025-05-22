<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    //

     // Allow guest to view only index & show
    // public function __construct()
    // {
    //     $this->middleware('auth')->except(['index', 'show']);
    // }

    // Semua pengguna bisa lihat postingan yang sudah dipublish dan tidak dijadwalkan di masa depan
     public function index()
    {
        $posts = Post::where('status', 'published')
                     ->where('published_at', '<=', now())
                     ->latest()
                     ->paginate(5);

        return view('posts.index', compact('posts'));
    }

    // Menampilkan detail post
    public function show(Post $post)
    {
        if ($post->status !== 'published' || $post->published_at > now()) {
            // Cek jika bukan pemilik dan status belum dipublish
            if (!Auth::check() || Auth::id() !== $post->user_id) {
                abort(403, 'Unauthorized');
            }
        }

        return view('posts.show', compact('post'));
    }

    // Tampilkan semua post milik user yang login
    public function home()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil semua post milik user tersebut
        $posts = Post::where('user_id', $user->id)->paginate(5);

        return view('home', compact('posts'));
    }

    // Form membuat post baru
    public function createPost()
    {
        return view('posts.create');
    }

    // // Simpan post baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:60',
            'content' => 'required',
            'published_at' => 'nullable|date',
        ]);

        $status = $request->has('is_draft') ? 'draft' : 'published';

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
            'published_at' => $request->status === 'published' ? $request->published_at : null,
        ]);

        return redirect()->route('home')->with('success', 'Post created.');
    }

    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

         // Validasi input
    $request->validate([
        'title' => 'required|max:60',
        'content' => 'required',
        'published_at' => 'nullable|date',
    ]);

    // Tentukan status berdasarkan checkbox
    $status = $request->has('is_draft') ? 'draft' : 'published';

    // Update post
    $post->update([
        'title' => $request->title,
        'content' => $request->content,
        'status' => $status,
        'published_at' => $status === 'published' ? $request->published_at : null,
    ]);
        return redirect()->route('home')->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted.');
    }

    
}
