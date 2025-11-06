@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6">
                    <a href="{{ route('posts.index') }}" 
                       class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                </div>
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Post</h2>
                    <p class="text-gray-600">Update your post content</p>
                </div>
                <form method="POST" action="{{ route('posts.update', $post->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Post Title
                        </label>
                        <input type="text" 
                               id="title"
                               name="title" 
                               value="{{ old('title', $post->title) }}"
                               placeholder="Enter the title "
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        @error('title') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Post Content
                        </label>
                        <textarea id="content"
                                  name="content" 
                                  rows="8"
                                  placeholder="Write your post"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                        @error('content') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Post Dete</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Created:</span> 
                                {{ $post->created_at->format('F j, Y \a\t g:i A') }}
                            </div>
                            @if($post->updated_at != $post->created_at)
                                <div>
                                    <span class="font-medium">Last Updated:</span> 
                                    {{ $post->updated_at->format('F j, Y \a\t g:i A') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('posts.show', $post->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection