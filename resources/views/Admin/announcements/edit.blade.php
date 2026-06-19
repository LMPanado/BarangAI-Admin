@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        @csrf
        @method('PUT')
        
        <h2 class="text-lg font-bold text-gray-900 mb-6">Edit Announcement</h2>
        
        <button type="submit" class="bg-brgyGreen text-white px-4 py-2 rounded-lg">Update Announcement</button>
    </form>
</div>
@endsection