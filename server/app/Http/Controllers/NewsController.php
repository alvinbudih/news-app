<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();

        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "image" => "image|file|max:1024"
        ]);

        if ($request->file("image")) {
            $validated["image"] = $request->file("image")->store("news-images");
        }

        $news = News::create($validated);

        Log::create([
            "user_id" => $request->user()->id,
            "description" => "Create news with id " . $news->id
        ]);

        return response()->json($news, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(["message" => "News Not Found"], 404);
        }

        return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(["message" => "News Not Found"], 404);
        }

        $validated = $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "image" => "image|file|max:1024"
        ]);

        if ($request->file("image")) {
            if ($news->image) {
                Storage::delete($news->image);
            }
            $validated["image"] = $request->file("image")->store("news-images");
        }

        $news->update($validated);

        Log::create([
            "user_id" => $request->user()->id,
            "description" => "Update news with id " . $news->id
        ]);

        return response()->json($news);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(["message" => "News Not Found"], 404);
        }

        if ($news->image) {
            Storage::delete($news->image);

            $news->delete();
        }

        Log::create([
            "user_id" => auth()->user()->id,
            "description" => "Delete news with id " . $news->id
        ]);

        return response()->json($news);
    }
}
