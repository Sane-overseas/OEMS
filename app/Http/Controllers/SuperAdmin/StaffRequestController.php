<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\StaffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StaffRequestController extends Controller
{
    /**
     * Display a listing of the pending staff requests.
     */
    public function index()
    {
        $pendingRequests = StaffRequest::with(['school', 'requester'])
            ->where('status', 'pending_verification')
            ->latest()
            ->paginate(15);

        return view('superadmin.staff-requests.index', compact('pendingRequests'));
    }

    /**
     * Display the specified staff request.
     */
    public function show(StaffRequest $staffRequest)
    {
        $staffRequest->load(['school', 'requester']);
        return view('superadmin.staff-requests.show', compact('staffRequest'));
    }

    /**
     * Approve the specified staff request.
     */
    public function approve(StaffRequest $staffRequest)
    {
        if ($staffRequest->status !== 'pending_verification') {
            return back()->with('error', 'This request has already been processed.');
        }

        DB::transaction(function () use ($staffRequest) {
            // 1. Create the new Admin/Staff user from the request data
            Admin::create([
                'school_id' => $staffRequest->school_id,
                'name' => $staffRequest->name,
                'email' => $staffRequest->email,
                'mobile' => $staffRequest->mobile,
                'password' => $staffRequest->password, // Password is pre-hashed
                'role' => $staffRequest->role,
                'photo' => $staffRequest->photo,
                'staff_type' => $staffRequest->staff_type,
                'professional_details' => $staffRequest->professional_details,
                'aadhaar_number' => $staffRequest->aadhaar_number,
                'aadhaar_dob' => $staffRequest->aadhaar_dob,
                'aadhaar_gender' => $staffRequest->aadhaar_gender,
                'status' => 'active',
                'login_method' => $staffRequest->login_method,
                'two_factor' => $staffRequest->two_factor,
            ]);

            // 2. Update the staff request status to 'approved'
            $staffRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::guard('superadmin')->id(),
                'approved_at' => now(),
            ]);
        });

        return redirect()->route('superadmin.staff-requests.index')->with('success', 'Staff request approved and user account created.');
    }

    /**
     * Reject the specified staff request.
     */
    public function reject(Request $request, StaffRequest $staffRequest)
    {
        $request->validate(['rejection_reason' => 'required|string|max:1000']);

        if ($staffRequest->status !== 'pending_verification') {
            return back()->with('error', 'This request has already been processed.');
        }

        $staffRequest->update(['status' => 'rejected', 'rejection_reason' => $request->input('rejection_reason')]);

        return redirect()->route('superadmin.staff-requests.index')->with('success', 'Staff request has been rejected.');
    }
}