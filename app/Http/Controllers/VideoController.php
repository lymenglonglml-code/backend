<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Video::query()->latest()->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return response()->json([
            'message' => 'Use the store endpoint to create videos.',
        ], Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'file_name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $video = Video::create($data);

        return response()->json($video, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video): JsonResponse
    {
        return response()->json($video);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video): JsonResponse
    {
        return response()->json([
            'message' => 'Use the update endpoint to edit videos.',
        ], Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video): JsonResponse
    {
        $data = $request->validate([
            'file_name' => ['sometimes', 'string', 'max:255'],
            'url' => ['sometimes', 'url', 'max:2048'],
        ]);

        $video->update($data);

        return response()->json($video);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video): Response
    {
        $video->delete();

        return response()->noContent();
    }
}
