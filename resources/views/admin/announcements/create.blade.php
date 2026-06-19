@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.announcements.index') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest flex items-center gap-1">
            ← Back to List
        </a>
        <h1 class="text-2xl font-black text-gray-800 uppercase tracking-wider mt-2">New Announcement</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Announcement Title</label>
                <input type="text" name="title" required value="{{ old('title') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brgyGreen @error('title') border-red-500 @enderror" 
                       placeholder="e.g., Mandatory Community Health Caravan">
                @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Category</label>
                <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brgyGreen">
                    <option value="General">General News</option>
                    <option value="Health">Health Advisory</option>
                    <option value="Security">Security Notice</option>
                    <option value="Advisory">Emergency Bulletin</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Image URL (Optional)</label>
                <input type="url" name="image_url" value="{{ old('image_url') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brgyGreen" 
                       placeholder="Paste public Supabase media bucket asset path link here">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Detailed Content</label>
                <textarea name="content" required rows="6"
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-brgyGreen @error('content') border-red-500 @enderror" 
                          placeholder="Type out all information regarding the official community notice..."></textarea>
                @error('content') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2 py-2">
                <input type="checkbox" name="is_pinned" id="is_pinned" value="1" class="rounded border-gray-300 text-brgyGreen focus:ring-brgyGreen">
                <label honeymoon for="is_pinned" class="text-xs font-bold uppercase tracking-widest text-gray-600 cursor-pointer select-none">
                    Pin announcement to the top of the feed
                </label>
            </div>

            <button type="submit" class="w-full py-3 bg-brgyGreen text-white text-xs font-bold rounded-xl uppercase tracking-widest hover:bg-darkGreen transition-all duration-300 shadow-md">
                Publish Announcement
            </button>
        </form>
    </div>
</div>
@endsection