<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactManagerController extends Controller
{
    // Hiển thị danh sách tin nhắn liên hệ
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        
        // Thống kê nhanh
        $summary = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'summary'));
    }

    // Xem chi tiết một tin nhắn
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        // Khi admin bấm vào xem thì tự động đổi trạng thái sang "Đã đọc" (read)
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    // Xóa tin nhắn
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Đã xóa tin nhắn liên hệ thành công.');
    }
}