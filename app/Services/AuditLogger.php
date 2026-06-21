<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    public static function log(
        string $action,
        string $subjectType,
        string $subjectLabel,
        ?int $subjectId = null,
    ): void {
        AuditLog::create([
            'user_id'       => Auth::id(),
            'action'        => $action,
            'subject_type'  => $subjectType,
            'subject_id'    => $subjectId,
            'subject_label' => $subjectLabel,
            'ip_address'    => Request::ip(),
            'created_at'    => now(),
        ]);
    }
}
