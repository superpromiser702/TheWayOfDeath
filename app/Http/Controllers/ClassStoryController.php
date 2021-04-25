<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\ClassStory;
use Illuminate\Support\Facades\Auth;

class ClassStoryController extends Controller
{
    //
    public function getClassStory(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 25])
            ->with([
                'likes',
                'views',
                'comments',
                'classstory',
                'users:id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createClassStory(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $content = json_encode($request->content);
        $postId = Post::create([
            'contentId' => 25,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        return ClassStory::create([
            'content' => $content,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'postId' => $postId,
            'userId' => $userId,
        ]);
    }

    public function updateClassStory()
    {
    }

    public function deleteClassStory()
    {
    }
}
