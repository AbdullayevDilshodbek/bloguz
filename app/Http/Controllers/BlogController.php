<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return BlogResource::collection(Blog::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'blog' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 401);
        } else {
            $category = Category::find($request->category_id);
            if ($category != null) {
                return Blog::create([
                    'title' => $request->title,
                    'blog' => $request->blog,
                    'category_id' => $request->category_id,
                    'author_id' => Auth::user()->id
                ]);
            } else {
                return 'Bunday categorya mavjud emas';
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return AnonymousResourceCollection
     */
    public function show($id)
    {
        return BlogResource::collection(Blog::where('id', $id)->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if ($blog->author_id == Auth::user()->id) {
            $blog->update($request->all());
            return $blog;
        } else {
            return 'The blog author is other person that is why you can`t update';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if ($blog->author_id == Auth::user()->id) {
            $blog = Blog::find($id);
            $blog->delete();
            return 'Delete the blog';
        } else {
            return 'The blog author is other person that is why you can`t delete';
        }
    }

    public function getAll()
    {
        return BlogResource::collection(Blog::all());
    }

    public function findBlogByCategory(Request $request)
    {
        $ids = [];
        $category = $request->get('category');

        $data = DB::select("with recursive category as (
   select id
   from categories
   where name like '$category%'
   union all
   select child.id
   from categories as child
     join category as parent on parent.id = child.parent_id
)
select *
from category");
        foreach ($data as $item) {
            array_push($ids, $item->id);
        }
        return BlogResource::collection(Blog::whereIn('category_id', $ids)->get());
    }
}
