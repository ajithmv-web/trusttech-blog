<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResponseTrait;
    protected $pageNumber = 1;
    protected $perPage = 10;
    public function index(Request $request): JsonResponse
    { 
        
        if($request->has('page')){
            $this->pageNumber = $request->get('page');
        }
        if($request->has('per_page')){
            $this->perPage = $request->get('per_page');
        }
        try {
            $query = Post::with('user:id,name,email');
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('content', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                          $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                      });
                });
            }
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            
            if (in_array($sortBy, ['created_at', 'updated_at', 'title'])) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->latest();
            }
            $posts = $query->paginate($this->perPage, ['*'], 'page', $this->pageNumber);
           return $this->returnSucess($posts);
        } catch (\Exception $e) {
          return $this->return400($e->getMessage());
        }
    }
    public function userIndex(Request $request): JsonResponse
    { 
        
        if($request->has('page')){
            $this->pageNumber = $request->get('page');
        }
        if($request->has('per_page')){
            $this->perPage = $request->get('per_page');
        }
        try {
            $query = Post::with('user:id,name,email')->where('user_id', Auth::id());
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('content', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                          $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                      });
                });
            }
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            
            if (in_array($sortBy, ['created_at', 'updated_at', 'title'])) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->latest();
            }
            $posts = $query->paginate($this->perPage, ['*'], 'page', $this->pageNumber);
           return $this->returnSucess($posts);
        } catch (\Exception $e) {
          return $this->return400($e->getMessage());
        }
    }



  
}