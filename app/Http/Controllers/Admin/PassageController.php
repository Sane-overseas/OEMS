<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Passage;
class PassageController extends Controller
{
    public function index()
    {
        $admin = auth('admin')->user();

        $passages = Passage::where('school_id',$admin->school_id)
            ->latest()
            ->paginate(20);

        return view('admin.passages.index',compact('passages'));
    }

    public function create()
    {
        return view('admin.passages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'class'   => 'required',
            'subject' => 'required',
            'title'   => 'nullable|string|max:255',
            'content' => 'required'
        ]);

        $admin = auth('admin')->user();

        Passage::create([
            'school_id' => $admin->school_id,
            'class'     => $request->class,
            'subject'   => $request->subject,
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        return redirect()
            ->route('admin.passages.index')
            ->with('success','Passage created successfully');
    }
}
