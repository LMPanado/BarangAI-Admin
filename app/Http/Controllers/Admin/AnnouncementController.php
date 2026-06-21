<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('Admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('Admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'category' => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement = Announcement::create([
            'title'     => $request->title,
            'content'   => $request->content,
            'category'  => $request->category,
            'image_url' => $imagePath,
            'is_pinned' => $request->has('is_pinned'),
        ]);

        AuditLogger::log('created', 'Announcement', $announcement->title, $announcement->id);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement posted successfully!');
    }

    // --- Added Edit Methods Below ---

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('Admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'category' => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $announcement = Announcement::findOrFail($id);

        $imagePath = $announcement->image_url;

        if ($request->remove_image == '1' && !$request->hasFile('image')) {
            if ($announcement->image_url) {
                Storage::disk('public')->delete($announcement->image_url);
            }
            $imagePath = null;
        }

        if ($request->hasFile('image')) {
            if ($announcement->image_url) {
                Storage::disk('public')->delete($announcement->image_url);
            }
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update([
            'title'     => $request->title,
            'content'   => $request->content,
            'category'  => $request->category,
            'image_url' => $imagePath,
            'is_pinned' => $request->has('is_pinned'),
        ]);

        AuditLogger::log('updated', 'Announcement', $announcement->title, $announcement->id);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully!');
    }

    // --- End of Edit Methods ---

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        AuditLogger::log('deleted', 'Announcement', $announcement->title, $announcement->id);
        if ($announcement->image_url) {
            Storage::disk('public')->delete($announcement->image_url);
        }
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted successfully!');
    }
}