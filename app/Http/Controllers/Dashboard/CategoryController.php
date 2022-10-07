<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * ChefController constructor.
     */
    //public function __construct()
    //{
    //    $this->authorizeResource(Category::class, 'category');
    //}

    public function index(Request $request)
    {
        if($request->active_at)
        {
            $categories =Category::whereTranslationLike('title',"%$request->title%")->whereNotNull('active_at')->latest()->paginate();
        }elseif ($request->active_at == null)
        {
            $categories =Category::whereTranslationLike('title',"%$request->title%")->latest()->paginate();
        }else
        {
            $categories =Category::whereTranslationLike('title',"%$request->title%")->whereNull('active_at')->latest()->paginate();
        }
        //$categories = Category::whereTranslationLike('title',"%$request->title%")->latest()->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! $request->input("active_at")) $request["active_at"] = null ;
        $category = Category::create($request->except('_token','media'));
        $category->addAllMediaFromTokens();

        flash()->success(trans('category.messages.created'));

        return redirect()->route('dashboard.categories.show', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if(! $request->input("active_at")) $request["active_at"] = null ;
        $category->update($request->except('_method','_token','media'));
        $category->addAllMediaFromTokens();
        flash()->success(trans('category.messages.updated'));

        return redirect()->route('dashboard.categories.show', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        flash()->success(trans('category.messages.deleted'));

        return redirect()->route('dashboard.categories.index');
    }
    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $this->authorize('viewAnyTrash', Category::class);

        $categories = Category::onlyTrashed()->whereTranslationLike('title',"%$request->title%")->paginate();

        return view('dashboard.categories.trashed', compact('categories'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Category $category)
    {
        $this->authorize('viewTrash', $category);

        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Category $category)
    {
        $this->authorize('restore', $category);

        $category->restore();

        flash()->success(trans('category.messages.restored'));

        return redirect()->route('dashboard.categories.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Category $category)
    {
        $this->authorize('forceDelete', $category);

        $category->forceDelete();

        flash()->success(trans('category.messages.deleted'));

        return redirect()->route('dashboard.categories.trashed');
    }
}
