<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
Use App\Models\ContactMessage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ContactMessageController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
            $contactMessage = ContactMessage::query()->orderBy('id', 'desc');;
            return DataTables::of($contactMessage)
                ->addColumn("user_name",function ($data){
                    return $data?->user?->name ?? '-';

                })->addColumn("user_email",function ($data){
                    return $data?->user?->email ?? $data->email;

                })->addColumn("phone",function ($data){
                    return $data?->user?->phone ?? $data->phone;
                })

                ->editColumn("title",function ($data){
                    return $data->title;

                })->editColumn("created_at",function ($data){

                    return $data->created_at->format('d/m/Y h:i A');;

                })->editColumn("message",function ($data){

                    return Str::words($data->message,8,'...').' <a href="#" class="btn btn-link p-0 show-message"
                    data-bs-toggle="modal" data-bs-target="#modal-message" id="show-message"
                        data-message="'.e($data->message).'" data-name="'.e($data?->user?->name ).'">More</a>';

                })->addColumn('action', function ($row) {
                    $route_delete = route("contact-messages.destroy", $row);
                    $csrf_token = csrf_token();

                    $checkBtn = '';
                    if (!$row->checked) {
                        $checkBtn = <<<btn
        <button class="btn btn-info btn-icon check-btn" data-id="{$row->id}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                <path d="M11.102 17.957c-3.204 -.307 -5.904 -2.294 -8.102 -5.957c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a19.5 19.5 0 0 1 -.663 1.032" />
                <path d="M15 19l2 2l4 -4" />
            </svg>
        </button>
        btn;
                    }

                    return <<<btns
        <form class="delete-form" action="{$route_delete}" method="POST" style="display:inline-block;">
            <input type="hidden" name="_token" value="{$csrf_token}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger btn-icon delete-btn" aria-label="Delete">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 7l16 0"></path> <path d="M10 11l0 6"></path> <path d="M14 11l0 6"></path> <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path> <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path> </svg>            </button>
        </form>

        {$checkBtn}
    btns;
                })

                ->rawColumns(['user_name',"phone","user_email",'message','title',"created_at",'action'])
                ->setRowClass(function ($row) {
                    return $row->checked ? 'bg-checked' : '';
                })
                ->make(true);
        }

        return view('contact-messages.index');

    }
    public function check($id)
    {

        $message = ContactMessage::findOrFail($id);
        $message->checked = !$message->checked;
        $message->save();
        app("firestore")->incrementField('count_messages', -1);

        return response()->json(['checked' => $message->checked]);
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        app("firestore")->incrementField('count_messages', -1);

        return redirect()->back()->with('success', 'Message deleted successfully.');
    }
}
