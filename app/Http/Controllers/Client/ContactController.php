<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ContactStoreRequest;
use App\Models\Contact;
use App\Models\Hotel;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();

        return view('clients.contacts.index', compact('hotels'));
    }

    public function store(ContactStoreRequest $request)
    {
        $validated = $request->validated();

        try {
            Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'] ?: null,
                'message' => $validated['message'],
                'status' => 'new',
            ]);

            return back()->with('success', 'Gui tin nhan thanh cong!');
        } catch (\Throwable $exception) {
            Log::error('Contact form submission failed', [
                'error' => $exception->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Khong the luu du lieu. Vui long thu lai sau.');
        }
    }
}
