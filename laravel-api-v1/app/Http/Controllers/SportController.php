<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SportController extends Controller
{
    private function validationErrorResponse($message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 400);
    }

    public function index(): JsonResponse
    {
        $sports = Sport::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Sports retrieved successfully',
            'data' => $sports,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->only(['id', 'name', 'description', 'image']);
        
        if (empty($data['id'])) {
            return $this->validationErrorResponse('ID must be filled');
        }
        
        if (!empty($data['id']) && strlen($data['id']) > 255) {
            return $this->validationErrorResponse('ID may not be greater than 255 characters.'); 
        }
        
        if (empty($data['name'])) {
            return $this->validationErrorResponse('Name is Required');
        }
        
        if (!empty($data['name']) && strlen($data['name']) > 255) {
           return $this->validationErrorResponse('Name may not be greater than 255 characters.'); 
        }
        
        if (!empty($data['id']) && Sport::where('id', $data['id'])->exists()) {
           return $this->validationErrorResponse('ID already exists.'); 
        }
        
        $sport = Sport::create([
            'id' => $data['id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Sport created successfully',
            'data' => $sport,
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $sport = Sport::find($id);
        
        if (!$sport) {
            return response()->json([
                'success' => false,
                'message' => 'Sport not found',
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Sport retrieved successfully',
            'data' => $sport,
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $sport = Sport::find($id);
        
        if (!$sport) {
            return response()->json([
                'success' => false,
                'message' => 'Sport not found',
            ], 404);
        }
        
        $data = $request->only(['name', 'description', 'image']);
        
        if (!empty($data['name']) && strlen($data['name']) > 255) {
           return $this->validationErrorResponse('Name may not be greater than 255 characters.'); 
        }
        
        $sport->update(array_filter($data, function($value) {
            return $value !== null;
        }));
        
        return response()->json([
            'success' => true,
            'message' => 'Sport updated successfully',
            'data' => $sport,
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $sport = Sport::find($id);
        
        if (!$sport) {
            return response()->json([
                'success' => false,
                'message' => 'Sport not found',
            ], 404);
        }
        
        $sport->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Sport deleted successfully',
        ], 200);
    }
}