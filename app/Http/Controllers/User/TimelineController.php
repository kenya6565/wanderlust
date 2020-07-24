<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers;
use App\Library\BaseClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use \App\Post;
use \App\Comment;
use \App\User;

class TimelineController extends Controller
{
    
   public function index(Request $request)
   {
        //自分の投稿とフォローしてるユーザの投稿を取得してそれを作成日時順で表示
        $user_posts = Auth::user()->posts;
        $counts = BaseClass::counts(Auth::user());
       // もしログインユーザが誰かをフォローしていたならforeachでフォローしてるユーザ１つ１つの投稿を取得
        $user_id = [Auth::id()];
        if(count(Auth::user()->followings) > 0)
        {
            $following_users = Auth::user()->followings;
            foreach($following_users as $following_user){
                //フォローしてるユーザーのID＋ログインユーザのID
                array_push($user_id,$following_user->id);
            }
        }
        //postsテーブルのユーザID(投稿ユーザ)にフォローしてるユーザのIDかログインユーザのIDがあったら取得
        $all_posts = Post::whereIn('user_id',$user_id)
                           ->orderBy('created_at','DESC')
                           ->paginate(9);
                           
        //$all_posts = $all_posts->sortByDesc('created_at');
        if(count($all_posts) > 0){
            foreach($all_posts as $post){
                $count_liking_users = $post->liking_users->count();
                //dd($count_liking_users);
                $data=[
                  'count_liking_users'=>$count_liking_users,
                ];
            }
            
        }
        //id 3と2
        //dd($all_posts);
        return view('user.timeline.index',compact(
            'all_posts',
            'counts',
            'data'
        ));
        
   }
   public function edit(Request $request)
    {
        //dd($request);
       
        $edit_post = Post::find($request->id);
        
        if (empty($edit_post))
        { //aaaaaは単なるパラメーター、News::findによってニューステーブルの特定の情報１行（bodyとか名前とか）を＄newsに入れてる
            abort(404);
        }
        return view('user.timeline.edit',compact(
            'edit_post'
        ));
    }
    
   
   public function post(Request $request)
   {
        //dd($request);
        $this->validate($request, Post::$rules);
        //dd($request);
        if($request->hasFile('image')){
            $request->file('image')->store('/public/images');
            Post::create([ 
                'user_id' => Auth::id(), 
                'title' => $request->title, 
                'post' => $request->post, 
                'image' => $request->file('image')->hashName(),
            ]);
         
        }else{
            Post::create([ 
                'user_id' => Auth::id(), 
                'title' => $request->title, 
                'post' => $request->post, 
            ]);
           
        }
        return redirect('/timeline'); 
    }
    
    public function show(Request $request)
    {
        //クリックした投稿のID
        $post = Post::find($request->id);
        //dd($post);
        //１つの投稿を表示する際それについてるコメントを表示
        $comments = Comment::where('post_id',$post)->latest()->get();
      
        return view('user.timeline.detail', compact(
            'post',
            'comments'
        ));
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        //dd($keyword);
        if (!empty($keyword)) {
            $searched_users = User::where('name', $keyword)->get();
            $searched_posts = Post::where('post', $keyword)->get();
                
        }
 
        return view('user.timeline.search', compact(
            'keyword', 
            'searched_users', 
            'searched_posts'
        ));
    }
}
