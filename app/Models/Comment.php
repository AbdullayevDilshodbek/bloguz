<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [ 'comment', 'blog_id','parent_id','author_id'];
    public function findBlog(){
        $blog = Blog::find($this->blog_id);
        if ($blog != null)
            return $blog->title;
        return null;
    }
    public function findAuthor($id){
        $user = User::find($id);
            return $user->name;
    }

//    bu kiga atvet yozilayotgani aniqlaydi
    public function findTo(){
        if ($this->parent_id != null){
            $user = User::find(Comment::find($this->parent_id)->author_id);
            if ($user != null)
                return $user->name;
            return 'to blog';
        }
        return null;
    }
//    bu kim tomonidan yozilgani aniqlaydi
    public function findToComment(){
        $user = User::find($this->parent_id);
        if ($user != null)
            return $user->name;
        return null;
    }

//    bu faqat blog ga yozilgan commentni topadi(without discuss)
    public function getOnlyComment(){
        return Comment::where("parent_id",null)->get();
    }

//    Bu ostagi 3 ta function rekursiv ravishda ichma-ich comment va commentga kelgan javoblarni chiqaradi
    public function getCommentAndDiscusses(){
        $comments = Comment::where("parent_id",null)->get();
        return $this->getDiscussOfComment($comments);
    }

    public function getDiscussOfComment($data){
        $result = [];
        foreach ($data as $item){
            unset($item->created_at);
            unset($item->updated_at);
            unset($item->parent_id);
            $item->author = User::find($item->author_id)->name;
            unset($item->author_id);
            if ($this->checkChild($item->id)){
                $child = Comment::where('parent_id', $item->id)->get();
                $item->child = $this->getDiscussOfComment($child);
                $result[] = $item;
            }else{
                $result[] = $item;
            }
        }
        return $result;
    }

    public function checkChild($id){
        $count = Comment::where('parent_id',$id)->count();
        return $count > 0;
    }
}
