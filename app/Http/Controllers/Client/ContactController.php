<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Hotel;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return view('clients.contacts.index',compact('hotels'));
    }

    public function store(Request $request)
{
    // 1. Kiểm tra dữ liệu
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    // 2. Thử lưu và kiểm tra kết quả
    try {
        $contact = \App\Models\Contact::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'new',
        ]);

        if ($contact) {
            return redirect()->back()->with('success', 'Gửi tin nhắn thành công!');
        }
    } catch (\Exception $e) {
        // Nếu lỗi database (ví dụ thiếu cột), nó sẽ hiện ở đây
        dd($e->getMessage()); 
    }

    return redirect()->back()->with('error', 'Không thể lưu dữ liệu.');
}
}