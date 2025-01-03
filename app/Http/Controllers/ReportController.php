<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return response()->json($reports);
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string',
            'beneficiaries' => 'required|integer',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'distribution_date' => 'required|date',
            'proof_file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $filePath = $request->file('proof_file')->store('proofs', 'public');

        $report = Report::create([
            'program_name' => $request->program_name,
            'beneficiaries' => $request->beneficiaries,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'distribution_date' => $request->distribution_date,
            'proof_file' => $filePath,
            'additional_notes' => $request->additional_notes,
        ]);

        return response()->json(['message' => 'Report submitted successfully', 'data' => $report], 201);
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        if ($request->status == 'Rejected') {
            $request->validate(['rejection_reason' => 'required|string']);
            $report->update([
                'status' => 'Rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);
        } else if ($request->status == 'Approved') {
            $report->update(['status' => 'Approved']);
        }

        return response()->json(['message' => 'Report status updated successfully', 'data' => $report]);
    }
}