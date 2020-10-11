<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        if (Blog::find($request->blog_id) != null && Blog::find($request->blog_id)->comment_status)
            return Comment::create([
                'comment' => $request->comment,
                'blog_id' => $request->blog_id,
                'author_id' => Auth::user()->id
            ]);
        return 'Can`t write comment to the artice' ;
    }

    public function createDiscuss(Request $request){
        $validator = Validator::make($request->all(),[
            'comment' => 'required|min:1',
            'parent_id' => 'required|min:1',
        ]);
        if ($validator->fails())
            return response()->json('Bad request',400);
        return Comment::create([
            'comment' => $request->commenet,
            'parent_id' => $request->parent_id,
            'author_id' => Auth::user()->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {

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
        $validator = Validator::make($request->all(),[
            'comment' => 'required',
            'blog_id' => 'required',
            'author_id' => 'required',
        ]);
        $comment = Comment::find($id);
        if ($comment != null && $comment->author_id == Auth::user()->id && Blog::find($request->blog_id) != null){
            if ($validator->fails())
                return response()->json($validator->getMessageBag(),400);
            return $comment->update([
                'comment' => $request->comment,
            ]);
        } else{
            return 'Forbidden (Error: 403)';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }

    public function getAll(){
        $data = new Comment();
        return $data->getCommentAndDiscusses();
    }

    public function onlyComment(){
        $comment = new Comment();
        return CommentResource::collection($comment->getOnlyComment());
    }
}
