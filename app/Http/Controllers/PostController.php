<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $locale = App::getLocale();
        $posts = Post::withLocalization($locale)->firstOrFail();
        return view('post.index', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        // Заполняем модель данными
        $post->save();

        foreach($request->input('localization', []) as $k => $i) {
            /** @var PostLocalization $locale */
            $locale = $post->localizations()
                ->create($i + ['lang' => $k]);
        }

        return redirect()
            ->route('posts.edit', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param   Post $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // Обновляем данные
        $post->update();

        // Обновляем (или создаем если не существует) локализованные данные
        foreach($request->input('localization', []) as $k => $i) {
            /** @var PostLocalization $locale */
            $locale = $post->localizations()
                ->updateOrCreate(['lang' => $k], $i);
        }

        return redirect()
            ->back();
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('posts.index');
    }
}