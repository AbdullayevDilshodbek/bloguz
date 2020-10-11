<?php

namespace App\Http\Controllers;

use App\Http\Resources\GradeResource;
use App\Models\Blog;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return GradeResource::collection(Grade::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $check_post = Blog::find($request->blog_id);
        if ($check_post == null) {
            return "Bunday maqola mavjud emas";
        } elseif (in_array($request->grade, range(1, 5))) {
            return Grade::create([
                'blog_id' => $request->blog_id,
                'grade' => $request->grade
            ]);
        } else {
            return 'Siz faqat 1 dan 5 oraliqda baxo bera olasiz';
        }
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
        //
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
}
