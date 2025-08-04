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
                    $route_delete = route("requests.destroy", $row);
                    $csrf_token = csrf_token();

                    return '
        <span class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">Actions</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="' . $acceptUrl . '">Accept</a>
                <a class="dropdown-item" href="' . $rejectUrl . '">Reject</a>
            </div>
        </span>

           <form class="delete-form" action="' . $route_delete . '" method="POST" style="display:inline-block;">
                                <input type="hidden" name="_token" value="'.$csrf_token.'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-icon delete-btn" aria-label="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M4 7l16 0"></path>
                          <path d="M10 11l0 6"></path>
                          <path d="M14 11l0 6"></path>
                          <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                          <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                        </svg>
                                </button>
                            </form>
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

  public function destroy($id)
{
    $user=User::findorfail($id);

    $user->delete();

    return redirect()->back()->with('success', 'request deleted successfully.');
}

}
