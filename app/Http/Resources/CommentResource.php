<?php

namespace App\Http\Resources;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'commnet' => $this->comment,
            'maqola' => $this->findBlog(),
            'kimdan' => $this->findAuthor($this->author_id),
            'kimga' => $this->findTo()
        ];
    }
}
