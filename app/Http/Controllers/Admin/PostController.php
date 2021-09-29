<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category', 'tags')->paginate(20); // оптимизируем запросы with('category', 'tags')
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {                              //значение //ключ
        $categories = Category::pluck('title', 'id')->all(); //получить только title
        $tags = Tag::pluck('title', 'id')->all(); //получить только title
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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image', // картинка
        ]);

        $data = $request->all();

        if($request->hasFile('thumbnail')) { // если есть картинка
            $folder = date('Y-m-d');
            $data['thumbnail'] = $request->file('thumbnail')->store("images/{$folder}", 'public'); //папки storage/app/images/сегодн. дата/файлик
        }

        $post = Post::create($data); // получаем посты
        $post->tags()->sync($request->tags); // синхонизирует теги из запроса create.blade.php name="tags[]"

        return redirect()->route('posts.index')->with('success', 'Статья добавлена');
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
       $post = Post::find($id);
                                    //значение //ключ
      $categories = Category::pluck('title', 'id')->all(); //получить только title
      $tags = Tag::pluck('title', 'id')->all(); //получить только title
      return view('admin.posts.edit', compact('categories','tags', 'post'));
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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image', // картинка
        ]);

        $post = Post::find($id);
        $data = $request->all();

        //если пришло новое изображение, удаляем старое
        if($request->hasFile('thumbnail')) { // если есть картинка

            Storage::disk('public')->delete($post->thumbnail); // удаление из storage (диск public filesystems.php)
            $folder = date('Y-m-d');
            $data['thumbnail'] = $request->file('thumbnail')->store("images/{$folder}", 'public' ); //папки storage/app/images/сегодн. дата/файлик
        }

        $post->update($data);
        $post->tags()->sync($request->tags); // синхонизирует теги из зап

        return redirect()->route('posts.index')->with('success', 'Статья изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->sync([]);  // удал синхронизтрованные теги
        Storage::disk('public')->delete($post->thumbnail); // удал изображение
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Статья удалена');
    }
}
