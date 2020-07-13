<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use function App\Support\can;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('posts.index', ['posts' => Post::with('author')->get()]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        abort_unless(can('manage.posts'), Response::HTTP_UNAUTHORIZED);

        return view('posts.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        abort_unless(can('manage.posts'), Response::HTTP_UNAUTHORIZED);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $post = Post::create(array_merge($validated, ['user_id' => auth()->id()]));

        return redirect(route('posts.show', $post->id));
    }

    /**
     * @param Post $post
     * @return \Illuminate\View\View
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * @param Post $post
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {
        abort_unless(can('manage.posts'), Response::HTTP_UNAUTHORIZED);

        return view('posts.edit', compact('post'));
    }

    /**
     * @param Post $post
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Post $post, Request $request)
    {
        abort_unless(can('manage.posts'), Response::HTTP_UNAUTHORIZED);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $post->update($validated);

        return redirect(route('posts.show', $post->id));
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        abort_unless(can('manage.posts'), Response::HTTP_UNAUTHORIZED);

        $post->delete();

        return redirect(route('posts.index'));
    }
}
