<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class  UserController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::orderBy('id', 'desc');

            return DataTables::of($users)
                ->editColumn('name', function ($row) {
                    return '<strong>' . e($row->name) . '</strong>';
                })
                ->editColumn('plan_name', function ($row) {
                    return '<strong>' . e($row->plan->name['en']) . '</strong>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                })->editColumn("approval_status",function ($row){
                    if ($row->approval_status=="pending"){
                        return '<span class="badge bg-warning me-1"></span> <strong>' . strtoupper($row->approval_status) . '</strong>';
                    }else if ($row->approval_status=="rejected"){
                        return '<span class="badge bg-danger me-1"></span> <strong>' . strtoupper($row->approval_status) . '</strong>';
                    }else{
                        return '<span class="badge bg-success me-1"></span> <strong>' . strtoupper($row->approval_status) . '</strong>';

                    }

                })

                ->addColumn('actions', function ($row) {
                    $route_edit = route("users.edit", $row);
                    $route_delete = route("users.destroy", $row);
                    $csrf_token = csrf_token();

                    return <<<btns
                            <a href="{$route_edit}" class="btn btn-primary btn-icon" aria-label="Button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                        <path d="M16 5l3 3"></path>
                      </svg>
                    </a>
                            <form class="delete-form" action="{$route_delete}" method="POST" style="display:inline-block;">
                                <input type="hidden" name="_token" value="{$csrf_token}">
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
                    btns;
                })->rawColumns(['name', 'actions','created_at','approval_status','plan_name'])
                ->make(true);
        }


        return view("users.index");
    }


    public function create(Request $request)
    {
        $user = new User();
        return view('users.action', ["user" => $user]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users',
            'dob' => 'required|date',
            'plan_id' => 'nullable|exists:plans,id',
            'plan_name' => 'nullable|string|max:255',
            'approval_status' => 'required|in:pending,accepted,rejected',
            'subscription_status' => 'boolean',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->dob = $validated['dob'];
        $user->plan_id = $validated['plan_id'] ?? null;
        $user->plan_name = $validated['plan_name'] ?? null;
        $user->approval_status = $validated['approval_status'];
        $user->subscription_status = $validated['subscription_status'] ?? 0;
        $user->save();

        return redirect()->back()->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $plans = Plan::all();

        return view("users.action", ["user" => $user, "plans" => $plans]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|unique:users,phone,' . $id,
            'dob' => 'required|date',
            'plan_id' => 'nullable|exists:plans,id',
            'plan_name' => 'nullable|string|max:255',
            'approval_status' => 'required|in:pending,accepted,rejected',
            'subscription_status' => 'boolean',
        ]);

        $currentSubscriptionStatus = (int) $user->subscription_status;
        $requestedSubscriptionStatus = (int) ($request->input('subscription_status', 0));

        $planId = $request->input('plan_id') ?? $user->plan_id;
        $plan = $planId ? Plan::find($planId) : null;
        $validated["plan_name"]=$plan->name["en"];
        DB::beginTransaction();

        try {

            if ($user->approval_status !== 'rejected' && $validated['approval_status'] === 'rejected') {
                $user->update(['subscription_status' => 0]);

                $user->subscription->delete();
                ServiceRequest::where('user_id', $user->id)->delete();
            }






            if (($user->plan_id!==$request->plan_id && $requestedSubscriptionStatus === 1)or($currentSubscriptionStatus === 0 && $requestedSubscriptionStatus === 1)) {
                if (! $plan) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Cannot activate subscription: plan not found.');
                }

                $payment = Payment::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'amount' => $plan->price ?? 0,
                    'currency' => $plan->currency ?? 'EUR',
                    'payment_method' => 'dashboard_manual',
                    'status' => 'paid',
                    'transaction_id' => 'ADMIN-' . uniqid(),
                    'order_id'=>uniqid()
                ]);

                $expiresAt = match ($plan->billing_type) {
                    'day' => now()->addDay(),
                    'month' => now()->addMonth(),
                    'year' => now()->addYear(),
                    default => now()->addMonth(),
                };

                $subscription = $user->subscription()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'plan_id' => $plan->id,
                        'status' => 'active',
                        'start_date' => now(),
                        'end_date' => $expiresAt,
                    ]
                );

                $user->update([
                    'current_subscription' => $subscription->id,
                    'is_sub_cancelled' => 0,
                    'plan_id' => $plan->id,
                    'subscription_status' => 1,
                ]);

                Log::info('🆕 Subscription manually activated by admin', [
                    'admin_id' => Auth::id() ?? null,
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'payment_id' => $payment->id,
                    'expires_at' => $expiresAt,
                ]);

                $tokens = $user->deviceTokens->pluck('fcm_token')->filter()->toArray();
                if ($tokens) {
                    $title = [
                        'en' => 'Subscription Activated',
                        'ro' => 'Abonament activat'
                    ];
                    $body = [
                        'en' => "Your subscription has been activated. It will expire on " . $expiresAt->format('F j, Y'),
                        'ro' => "Abonamentul dvs. a fost activat. Va expira pe data de " . $expiresAt->format('F j, Y')
                    ];
//                    $title = 'Subscription Activated';
//                    $body = "Your subscription has been activated. It will expire on " . $expiresAt->format('F j, Y');
                    app("notification")->sendNotification(
                        $tokens,
                        $title,
                        $body,
                        ['type' => 'subscription_update'],
                        null,
                        'tokens',
                        $user->id
                    );

                }
            } else {
                if ($currentSubscriptionStatus === 1 && $requestedSubscriptionStatus === 0) {
                    $user->subscription()->delete();
                    $user->update(['subscription_status' => 0]);
                    Log::info('🔕 Subscription cancelled by admin', ['user_id' => $user->id, 'admin_id' => Auth::id() ?? null]);
                } else {
                    if ($request->has('plan_id') && $plan) {
                        $user->update(['plan_id' => $plan->id]);
                    }
                }
            }
            $user->update(Arr::except($validated, ['subscription_status']));

            DB::commit();

            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating user/admin activate subscription: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'error' => $e,
            ]);

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
    $user->delete();
    $user->deviceTokens()->delete();

    return redirect()->route('users.index')->with('success', 'User deleted successfully.');    }
}
