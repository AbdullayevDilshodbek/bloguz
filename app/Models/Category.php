<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','parent_id'];

    public function getAll(){
        $categories = Category::where('parent_id', null)->get();
        return $this->getCategory($categories);
    }

    private function getCategory($array)
    {
        $result = [];
        foreach ($array as $item) {
            unset($item->created_at);
            unset($item->updated_at);
            unset($item->parent_id);
            if ($this->checkParent($item->id)) {
                $parents = Category::where('parent_id', $item->id)->get();
                $item->child = $this->getCategory($parents);
                $result[] = $item;
            } else {
//                $item->child = [];
                $result[] = $item;
            }
        }
        return $result;
    }

    private function checkParent($id)
    {
        $categoryCount = Category::where('parent_id', $id)->count();
        return $categoryCount > 0;
    }

    public function findCategory($tetx){
        $categories = Category::where('name','like',$tetx.'%')->get();
        return $this->getCategory($categories);
    }
}
