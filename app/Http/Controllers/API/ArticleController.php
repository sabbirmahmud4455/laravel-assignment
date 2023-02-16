<?php

namespace App\Http\Controllers\API;

use JWTAuth;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class ArticleController extends Controller
{
    public function index()
    {
        try {

            $articles = Article::with([
                'user' => function($query) {
                    $query->select('id', 'name');
                }
            ])->get();

            return response()->json(['articles'=> $articles], 201);

        } catch (\Throwable $th) {
            return response()->json(['error'=> "Server error"], 500);
        }
    }

    public function show($slug)
    {
        try {
            $article = Article::with([
                'user' => function($query) {
                    $query->select('id', 'name');
                }
            ])
            ->where('slug', $slug)->first();

            if ($article) {

                return response()->json(['article' => $article], 201);

            } else {
                return response()->json(['error' => "Article Not Found"], 404);
            }


        } catch (\Throwable $th) {
            return response()->json(['error' => "Server error"], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
                        [
                            'title'         => 'required|max:190',
                            'description'   => 'required|max:2000',
                        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        try {
            $article = Article::create([
                'user_id'       => JWTAuth::parseToken()->authenticate()->id,
                'title'         => $request->title,
                'slug'          => Str::slug($request->title),
                'description'   => $request->description,
            ]);

            return response()->json(['success' => "Article Created Successfully"], 201);

        } catch (\Throwable $th) {
            return response()->json(['error'=> "Server error"], 500);
        }
    }

    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(),
            [
                'title' => 'required|max:190',
                'description' => 'required|max:2000',
            ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        try {
            $article = Article::where('slug', $slug)->first();

            if ($article) {
                $article->update([
                    'user_id'       => JWTAuth::parseToken()->authenticate()->id,
                    'title'         => $request->title,
                    'slug'          => Str::slug($request->title),
                    'description'   => $request->description,
                ]);

                return response()->json(['success' => "Article Update Successfully"], 201);

            } else {
                return response()->json(['error' => "Article Not Found"], 404);
            }


        } catch (\Throwable $th) {
            return response()->json(['error' => "Server error"], 500);
        }
    }

    public function delete($slug)
    {
        try {
            $article = Article::where('slug', $slug)->first();

            if ($article) {
                $article->delete();
                return response()->json(['success' => "Article Deleted Successfully"], 201);
            } else {
                return response()->json(['error' => "Article Not Found"], 404);
            }

        } catch (\Throwable $th) {
            return response()->json(['error' => "Server error"], 500);
        }
    }
}
