<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $payments = Payment::with(['user', 'plan'])->select('payments.*')->orderBy('id', 'desc');;

            return DataTables::of($payments)
                ->addIndexColumn()
                ->editColumn('user', function ($row) {
                    return $row->user ? e($row->user->name) : '-';
                })->addColumn('phone', function ($row) {
                    return $row->user ? e($row->user->phone) : '-';
                })
                ->editColumn('plan', function ($row) {
                    return $row->plan ? e($row->plan->name["en"]) : '-';
                })
                ->editColumn('status', function ($row) {
                    $color = match ($row->status) {
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'warning',
                    };

                    return '<span class="badge bg-' . $color . ' me-1"></span><strong>'. strtoupper($row->status) .'</strong>';
                })
                ->editColumn('amount', function ($row) {
                    return number_format($row->amount, 2) . ' ' . $row->currency;
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="form-check-input row-check" name="selected[]" value="' . $row->id . '">';
                })
                ->addColumn('actions', function ($row) {
                    $showUrl = route('payments.show', $row->id);


                    return '
                        <a  href="#" class="btn  btn-info btn-icon p-0 view-payment"
                    data-bs-toggle="modal" data-bs-target="#paymentModal" data-id="'.$row->id.'" id="view-payment"  class="btn btn-primary btn-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>                                       <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true" style="display:none;"></span>
</a>

                    ';
                })
                ->rawColumns(['status', 'actions', 'checkbox',"phone"])
                ->make(true);
        }

        return view('payments.index');
    }

    public function show($id)
    {

        $payment = Payment::with(["plan","user"])->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $payment
        ]);
    }


    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json(['success' => true, 'message' => 'تم حذف عملية الدفع بنجاح']);
    }
}
