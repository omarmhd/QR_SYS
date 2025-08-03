<?php

namespace App\Http\Controllers;

use App\Mail\ApprovalMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use App\Services\FcmNotificationService;

class MembershipRequests extends Controller
{
protected $firebaseService;

    public function __construct(FcmNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::query();

            return DataTables::of($users)

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



public function changeStatus($id, $status)
{
    $allowedStatuses = ['accepted', 'rejected'];

    if (!in_array($status, $allowedStatuses)) {
        return redirect()->back()->with('error', 'Invalid status value.');
    }

    $user = User::findOrFail($id);
    $user->approval_status = $status;

    $notificationTitle = 'Your account status';
    $notificationBody = $status === 'accepted'
        ? 'Congratulations, your application has been accepted.'
        : 'We’re sorry, your application has been rejected.';

    // Send push notification
    $tokens = $user->deviceTokens->pluck('fcm_token')->toArray();
    $this->firebaseService->sendNotification(
        $tokens,
        $notificationTitle,
        $notificationBody,
        ['type' => 'token'],
        null,
        'tokens',
        $id
    );

    // Send one mail class with status passed in
    Mail::to($user->email)->send(new ApprovalMail($user, $status));

    $user->save();

    return redirect()->back()->with('success', 'Status updated to ' . $status);
}

}
