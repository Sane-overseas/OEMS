<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecurityLog;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminSecurityLogController extends Controller
{
    public function index()
    {
        $logs = SecurityLog::where('guard', 'admin')
            ->latest()
            ->paginate(50);

        return view('admin.security.logs', compact('logs'));
    }
     
   public function download(){
    view('');
   }


   public function export()
{
    $fileName = 'admin_security_logs_' . now()->format('Ymd_His') . '.csv';

    return new StreamedResponse(function () {

        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'Time',
            'Guard',
            'User ID',
            'Event',
            'IP',
            'User Agent',
            'Description',
            'Payload'
        ]);

        SecurityLog::where('guard', 'admin')
            ->latest()
            ->chunk(500, function ($logs) use ($handle) {

                foreach ($logs as $log) {

                    fputcsv($handle, [
                        $log->created_at,
                        $log->guard,
                        $log->user_id,
                        $log->event,
                        $log->ip_address,
                        $log->user_agent,
                        $log->description,
                        $log->payload ? json_encode($log->payload) : null,
                    ]);
                }
            });

        fclose($handle);

    }, 200, [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$fileName\"",
    ]);
}

}
