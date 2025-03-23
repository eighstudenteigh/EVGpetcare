<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\PetType;

class InquiryController extends Controller
{
    // ✅ Show the inquiry form for customers
    public function create()
    {
        $petTypes = PetType::orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        
        return view('customer.inquiry', compact('petTypes', 'services'));
    }

    // ✅ Store guest inquiries
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'contact_number' => 'nullable|string|max:11',
        'message' => 'required|string',
        'pet_type_id' => 'nullable|exists:pet_types,id',  // Optional pet type
        'service_id' => 'nullable|exists:services,id',    // Optional service
    ]);

    Inquiry::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'contact_number' => $validatedData['contact_number'] ?? null,
        'message' => $validatedData['message'],
        'pet_type_id' => $validatedData['pet_type_id'] ?? null,
        'service_id' => $validatedData['service_id'] ?? null,
        'status' => 'unread',
    ]);

    return back()->with('success', 'Your inquiry has been sent! We will get back to you soon.');
}

    // ✅ Show all inquiries for the admin
    public function index()
    {
        $inquiries = Inquiry::orderByRaw("FIELD(status, 'unread', 'read')")
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $petTypes = PetType::orderBy('name')->get(); // Ensure pet types are passed
        
        return view('admin.inquiries.index', compact('inquiries', 'petTypes'));
    }
    
    // ✅ Mark an inquiry as read
    public function markAsRead(Request $request, $id)
{
    $inquiry = Inquiry::findOrFail($id);

    if ($inquiry->status !== 'read') {
        $inquiry->update(['status' => 'read']);
    }

    return response()->json(['success' => true, 'message' => 'Inquiry marked as read.']);
}

    

public function destroy(Inquiry $inquiry)
{
    $inquiry->delete();
    return response()->json(['success' => true, 'message' => 'Inquiry deleted successfully.']);
}

}
