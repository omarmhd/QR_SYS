<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $plans =  Plan::query();
            return DataTables::of($plans)
                ->editColumn('name', function ($row) {
                    return '<strong>' . e($row->name) . '</strong>';
                })->addColumn('actions', function ($row) {
                    $acceptUrl = route('requests.changeStatus', ['id' => $row->id, 'status' => 'accepted']);
                     $rejectUrl = route('requests.changeStatus', ['id' => $row->id, 'status' => 'rejected']);

                    return '
        <span class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="' . $acceptUrl . '">Accept</a>
                <a class="dropdown-item" href="' . $rejectUrl . '">Reject</a>
            </div>
        </span>
    ';
                })

                ->rawColumns(['name', 'actions'])
                ->make(true);
        }

        return view('requests.index');
    }
}
