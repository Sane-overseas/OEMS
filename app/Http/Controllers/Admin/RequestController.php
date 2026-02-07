<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminRequest;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Show the form for requesting a reset or block for staff.
     */
    public function createStaffRequest()
    {
        // Fetch staff members to populate the dropdown
        $staffMembers = Admin::where('school_id', Auth::user()->school_id)
            ->where('role', '!=', 'school_admin')
            ->where(function ($query) {
                $query->whereIn('role', ['staff', 'sub_admin'])
                      ->orWhere('staff_type', 'teacher');
            })->get();

        return view('admin.staff.request_reset_block', compact('staffMembers'));
    }

    /**
     * Store the request in the database for Superadmin review.
     */
    public function storeStaffRequest(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:admins,id',
            'request_type' => 'required|in:block_user,unblock_user',
            'reason' => 'required|string|max:500',
        ]);

        // Logic to save the request
        AdminRequest::create([
            'school_id' => Auth::user()->school_id,
            'requester_id' => Auth::id(),
            'target_user_id' => $request->user_id,
            'request_type' => $request->request_type,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Request submitted successfully to Superadmin.');
    }
}
