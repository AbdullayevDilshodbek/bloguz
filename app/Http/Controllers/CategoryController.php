<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);
        if ($validator->fails())
            return response()->json('Not given `name`',400);
        return Category::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        return Category::update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id)
    {
        if (Category::where('parent_id',$id) || Blog::where('category_id',$id))
            return 'You can`t delete the category !';
        Category::find($id)->delete();
        return 'Delete the category';
    }

    public function getAll(){
        $categorys = new Category();
        return $categorys->getAll();
    }

    public function findCategory(Request $request){
        $category = new Category();
        return $category->findCategory($request->name);
    }
}
