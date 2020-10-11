<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title','blog','category_id','author_id'];

    public function user(){
        return $this->hasOne('App\Models\User', 'id','author_id');
    }

    public function findCategory(){
        return Category::find($this->category_id);
    }





}
