<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use App\Models\Resident;
use App\Models\Announcement;
use App\Models\Feedback;
use App\Models\Schedule;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));
        $filter = $request->get('filter', 'all');

        $residents        = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        $announcements    = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        $feedback         = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        $events           = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        $documentRequests = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);

        if ($filter === 'all' || $filter === 'residents') {
            $q = Resident::onlyTrashed()->latest('deleted_at');
            if ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('first_name', 'ilike', "%{$search}%")
                          ->orWhere('last_name',  'ilike', "%{$search}%")
                          ->orWhere('email',       'ilike', "%{$search}%");
                });
            }
            $residents = $q->paginate(10, ['*'], 'residents_page')->withQueryString();
        }

        if ($filter === 'all' || $filter === 'announcements') {
            $q = Announcement::onlyTrashed()->latest('deleted_at');
            if ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('title',    'ilike', "%{$search}%")
                          ->orWhere('content', 'ilike', "%{$search}%");
                });
            }
            $announcements = $q->paginate(10, ['*'], 'announcements_page')->withQueryString();
        }

        if ($filter === 'all' || $filter === 'events') {
            $q = Schedule::onlyTrashed()->latest('deleted_at');
            if ($search) {
                $q->where('title', 'ilike', "%{$search}%");
            }
            $events = $q->paginate(10, ['*'], 'events_page')->withQueryString();
        }

        if ($filter === 'all' || $filter === 'feedback') {
            $q = Feedback::onlyTrashed()->latest('deleted_at');
            if ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('message',    'ilike', "%{$search}%")
                          ->orWhere('user_email','ilike', "%{$search}%");
                });
            }
            $feedback = $q->paginate(10, ['*'], 'feedback_page')->withQueryString();
        }

        if ($filter === 'all' || $filter === 'requests') {
            $q = DocumentRequest::onlyTrashed()->latest('deleted_at');
            if ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('full_name',     'ilike', "%{$search}%")
                          ->orWhere('document_type','ilike', "%{$search}%")
                          ->orWhere('purpose',      'ilike', "%{$search}%");
                });
            }
            $documentRequests = $q->paginate(10, ['*'], 'requests_page')->withQueryString();
        }

        $expiringSoon = Resident::onlyTrashed()->where('deleted_at', '<', now()->subDays(25))->count()
            + Announcement::onlyTrashed()->where('deleted_at', '<', now()->subDays(25))->count()
            + Schedule::onlyTrashed()->where('deleted_at', '<', now()->subDays(25))->count()
            + Feedback::onlyTrashed()->where('deleted_at', '<', now()->subDays(25))->count()
            + DocumentRequest::onlyTrashed()->where('deleted_at', '<', now()->subDays(25))->count();

        return view('admin.archive.index', compact('residents', 'announcements', 'feedback', 'events', 'documentRequests', 'search', 'filter', 'expiringSoon'));
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
            case 'request':
                $model = DocumentRequest::onlyTrashed()->findOrFail($id);
                $model->restore();
                AuditLogger::log('updated', 'DocumentRequest', $model->document_type . ' for ' . $model->full_name, $model->id);
                $label = 'Document request restored successfully.';
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
                if ($model->image_url) \Illuminate\Support\Facades\Storage::disk('public')->delete($model->image_url);
                AuditLogger::log('deleted', 'Announcement', $model->title, $model->id);
                $model->forceDelete();
                break;
            case 'feedback':
                Feedback::onlyTrashed()->findOrFail($id)->forceDelete();
                break;
            case 'event':
                $model = Schedule::onlyTrashed()->findOrFail($id);
                if ($model->image) \Illuminate\Support\Facades\Storage::disk('public')->delete($model->image);
                AuditLogger::log('deleted', 'Schedule', $model->title, $model->id);
                $model->forceDelete();
                break;
            case 'request':
                $model = DocumentRequest::onlyTrashed()->findOrFail($id);
                AuditLogger::log('deleted', 'DocumentRequest', $model->document_type . ' for ' . $model->full_name, $model->id);
                $model->forceDelete();
                break;
            default:
                abort(404);
        }

        return redirect()->route('admin.archive.index')->with('success', 'Record permanently deleted.');
    }
}
