<?php

namespace App\Http\Controllers;

use App\Models\JournalAudit;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuditController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:consulter-audit'),
        ];
    }

    public function index()
    {
        $entries = JournalAudit::with('user', 'dossierMedical.patient')
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('audit.index', compact('entries'));
    }
}