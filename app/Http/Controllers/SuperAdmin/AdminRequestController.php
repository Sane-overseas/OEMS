<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminRequestController extends Controller
{
    /**
     * Display a listing of the admin requests (Reset/Block).
     */
    public function index()
    {
        $requests = AdminRequest::with(['school', 'requester', 'targetUser'])
            ->latest()
            ->paginate(15);

        return view('superadmin.admin-requests.index', compact('requests'));
    }

    /**
     * Handle the action (Approve/Reject) for a request.
     */
    public function action(Request $request, AdminRequest $adminRequest)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'rejection_reason' => 'nullable|required_if:action,reject|string|max:500',
        ]);

        if ($adminRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        // Handle Rejection
        if ($request->action === 'reject') {
            $adminRequest->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);
            return back()->with('success', 'Request rejected successfully.');
        }

        // Handle Approval
        $targetUser = Admin::find($adminRequest->target_user_id);

        if (!$targetUser) {
            $adminRequest->update([
                'status' => 'rejected',
                'rejection_reason' => 'Target user no longer exists in the system.',
            ]);
            return back()->with('error', 'Target user not found. Request has been marked as rejected.');
        }

        $successMessage = 'Request approved successfully.';

        switch ($adminRequest->request_type) {
            case 'block_user':
                $targetUser->update(['status' => 'blocked']);
                $successMessage = "User <strong>{$targetUser->name}</strong> has been blocked.";
                break;

            case 'unblock_user':
                $targetUser->update(['status' => 'active']);
                $successMessage = "User <strong>{$targetUser->name}</strong> has been unblocked.";
                break;
        }

        $adminRequest->update(['status' => 'approved']);

        return back()->with('success', $successMessage);
    }
}
