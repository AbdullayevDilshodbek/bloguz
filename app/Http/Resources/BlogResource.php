<?php

namespace App\Http\Resources;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
//            'blog' => $this->blog,
//            'grade' => Grade::where('blog_id', $this->id)->pluck('grade')->avg(),
//            'category' => $this->findCategory()->name,
//            'author' => $this->user->name
        ];
    }
}
