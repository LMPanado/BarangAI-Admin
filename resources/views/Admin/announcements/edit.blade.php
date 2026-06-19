@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        @csrf
        @method('PUT')
        
        <h2 class="text-lg font-bold text-gray-900 mb-6">Edit Announcement</h2>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" value="{{ old('title', $announcement->title) }}" class="w-full mt-1 border-gray-300 rounded-lg p-2 border" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <input type="text" name="category" value="{{ old('category', $announcement->category) }}" class="w-full mt-1 border-gray-300 rounded-lg p-2 border" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Content</label>
            <textarea name="content" rows="5" class="w-full mt-1 border-gray-300 rounded-lg p-2 border" required>{{ old('content', $announcement->content) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Image URL</label>
            <input type="url" name="image_url" value="{{ old('image_url', $announcement->image_url) }}" class="w-full mt-1 border-gray-300 rounded-lg p-2 border">
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_pinned" {{ $announcement->is_pinned ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                <span class="ml-2 text-sm text-gray-700">Pin this announcement</span>
            </label>
        </div>
        
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Update Announcement</button>
        <a href="{{ route('admin.announcements.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Cancel</a>
    </form>
</div>
@endsection