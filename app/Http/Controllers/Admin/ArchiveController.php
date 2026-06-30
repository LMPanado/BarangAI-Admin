<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\Announcement;
use App\Models\Feedback;
use App\Models\Schedule;
use App\Services\AuditLogger;

class ArchiveController extends Controller
{
    public function index()
    {
        $residents     = Resident::onlyTrashed()->latest('deleted_at')->get();
        $announcements = Announcement::onlyTrashed()->latest('deleted_at')->get();
        $feedback      = Feedback::onlyTrashed()->latest('deleted_at')->get();
        $events        = Schedule::onlyTrashed()->latest('deleted_at')->get();

        return view('admin.archive.index', compact('residents', 'announcements', 'feedback', 'events'));
    }

    public function restore($type, $id)
    {
        switch ($type) {
            case 'resident':
                $model = Resident::onlyTrashed()->findOrFail($id);
                $model->restore();
                AuditLogger::log('updated', 'Resident', $model->first_name . ' ' . $model->last_name, $model->id);
                $label = 'Resident restored successfully.';
                break;

            case 'announcement':
                $model = Announcement::onlyTrashed()->findOrFail($id);
                $model->restore();
                AuditLogger::log('updated', 'Announcement', $model->title, $model->id);
                $label = 'Announcement restored successfully.';
                break;

            case 'feedback':
                $model = Feedback::onlyTrashed()->findOrFail($id);
                $model->restore();
                $label = 'Feedback restored successfully.';
                break;

            case 'event':
                $model = Schedule::onlyTrashed()->findOrFail($id);
                $model->restore();
                AuditLogger::log('updated', 'Schedule', $model->title, $model->id);
                $label = 'Event restored successfully.';
                break;

            default:
                abort(404);
        }

        return redirect()->route('admin.archive.index')->with('success', $label);
    }

    public function forceDelete($type, $id)
    {
        switch ($type) {
            case 'resident':
                $model = Resident::onlyTrashed()->findOrFail($id);
                AuditLogger::log('deleted', 'Resident', $model->first_name . ' ' . $model->last_name, $model->id);
                $model->forceDelete();
                break;
            case 'announcement':
                $model = Announcement::onlyTrashed()->findOrFail($id);
                AuditLogger::log('deleted', 'Announcement', $model->title, $model->id);
                $model->forceDelete();
                break;
            case 'feedback':
                Feedback::onlyTrashed()->findOrFail($id)->forceDelete();
                break;
            case 'event':
                $model = Schedule::onlyTrashed()->findOrFail($id);
                AuditLogger::log('deleted', 'Schedule', $model->title, $model->id);
                $model->forceDelete();
                break;
            default:
                abort(404);
        }

        return redirect()->route('admin.archive.index')->with('success', 'Record permanently deleted.');
    }
}
