<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\QRCode;

use App\Services\UsageCheckerService;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\GDLibRenderer;
use BaconQrCode\Writer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{

    public function index(Request $request)
    {
        $users = User::query()->with(["plan","subscription"]);

        if (!is_null($request->search)) {
            $search = $request->search;

            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users->where("approval_status","accepted");

        $users = $users->paginate(10);

        return json_encode($users);

    }

    public function generateQr(Request $request,$id,UsageCheckerService $usageCheckerService)
    {
        $count = $request->input('count', 1);
        $qrCodes = [];

        $renderer = new GDLibRenderer(200);
        $writer = new Writer($renderer);
        $user = User::with('subscription')->find($id);

        $canUseVisitOrInvite=$usageCheckerService->canUseVisitOrInvite($user);


        if (!$canUseVisitOrInvite['allowed']){
            return response()->json([
                "status" => false,
                "message" => $canUseVisitOrInvite['message']
            ]);

        }
        dd($user->current_subscription);
        if ($user->subscription) {
            $user->subscription->increment('used_guests');
        }
        for ($i = 0; $i < $count; $i++) {
            $token = bin2hex(random_bytes(16));
            $image = $writer->writeString($token);

//            $image = $writer->writeString("Member $id - guest $i ".time());
            QRCode::create([
                "user_id"=>$id,
                "qr_token"=>$token,
                "guests"=>0,
                "type"=>"visitor",
                "created_by"=>null,
                "expires_at" => Carbon::now()->addHours(24),

            ]);

            $qrCodes[] = [
                'name' => "Guest " . ($i + 1),
                'qr'   => 'data:image/png;base64,' . base64_encode($image)
            ];
        }

        return json_encode(['qr_codes' => $qrCodes]);
    }

    public function history($id){
        $data = QRCode::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_count'),
            DB::raw('COUNT(CASE WHEN status = "entered" THEN 1 END) as entered_count')
        )
            ->where('user_id', $id)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($data);
    }


}
