<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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
            'title' => 'required'
        ]);
        Category::create($request->all());
        //$request->session()->flash('success', 'Категория добавлена'); // флешка илил в редиректе
        return redirect()->route('categories.index')->with('success', 'Категория добавлена');
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
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
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
            'title' => 'required'
        ]);
        $category = Category::find($id);
        //$category->slug = null; // для изменения слизня НЕ РЕКОМЕНДУЕТСЯ
        $category->update($request->all()); // сохраняем
        return redirect()->route('categories.index')->with('success', 'Категория изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category = Category::find($id);
        if($category->posts->count()) { // если у категории есть посты, то ошибка
            return redirect()->route('categories.index')->with('error', 'У категории есть запись');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Категория удалена');

        //$category = Category::find($id);
        //$category->delete();
                    //или
        //Category::destroy($id);
        //return redirect()->route('categories.index')->with('success', 'Категория удалена');
    }
}
