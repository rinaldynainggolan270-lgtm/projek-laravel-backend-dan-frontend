<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SportController extends Controller
{
    public function index()
    {
        $baseUrl = 'http://localhost:8080';
        $sports = [];
        
        $response = Http::get($baseUrl . '/api/sports');
        
        if ($response->successful()) {
            $body = $response->json();
            if (isset($body['data']) && is_array($body['data'])) {
                $sports = $body['data'];
            }
        }
        
        return view('home.index', [
            'sports' => $sports,
        ]);
    }

    public function create()
    {
        return view('home.create');
    }

    public function store(Request $request)
    {
        $baseUrl = 'http://localhost:8080';
        
        $request->validate([
            'id' => ['required', 'regex:/^\S+$/'],
            'name' => ['required'],
            'description' => ['nullable'],
            'image' => ['nullable', 'url'],
        ]);
        
        $payload = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
        ];
        
        try {
            $response = Http::timeout(10)->post($baseUrl . '/api/sports', $payload);
            
            if ($response->successful()) {
                $body = $response->json();
                $message = isset($body['message']) ? $body['message'] : 'Sport created successfully';
                return redirect()->route('home.index')->with('success', $message);
            }
            
            $errorData = $response->json();
            $errorMessage = isset($errorData['errors']) ? json_encode($errorData['errors']) : 
                           (isset($errorData['message']) ? $errorData['message'] : 'Gagal membuat sport');
            
            return back()->withInput()->with('error', 'Error: ' . $errorMessage . ' (Status: ' . $response->status() . ')');
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $baseUrl = 'http://localhost:8080';
        
        try {
            $response = Http::timeout(10)->delete($baseUrl . '/api/sports/' . $id);
            
            if ($response->successful()) {
                $body = $response->json();
                $message = isset($body['message']) ? $body['message'] : 'Sport deleted successfully';
                return redirect()->route('home.index')->with('success', $message);
            }
            
            $errorData = $response->json();
            $errorMessage = isset($errorData['message']) ? $errorData['message'] : 'Gagal menghapus sport';
            
            return redirect()->route('home.index')->with('error', 'Error: ' . $errorMessage . ' (Status: ' . $response->status() . ')');
            
        } catch (\Exception $e) {
            return redirect()->route('home.index')->with('error', 'Exception: ' . $e->getMessage());
        }
    }
}