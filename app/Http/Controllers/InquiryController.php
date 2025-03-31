<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\PetType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class InquiryController extends Controller
{
    // ✅ Show the inquiry form for customers
     public function create()
    {
        $petTypes = PetType::orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        $user = Auth::user();  // Use Auth facade here

        // Check if the user is logged in and load the corresponding view
        if ($user) {
            return view('customer.logged-inquiry', compact('petTypes', 'services', 'user'));
        }

        // If not logged in, show the guest inquiry page
        return view('customer.inquiry', compact('petTypes', 'services'));
    }

    // ✅ Store guest inquiries with phone number validation
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'contact_number' => 'nullable|regex:/^\d{10,11}$/',
        'message' => 'required|string',
        'pet_type_id' => 'nullable|exists:pet_types,id',
        'service_id' => 'nullable|exists:services,id',
    ]);

    try {
        Inquiry::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact_number' => $validatedData['contact_number'] ?? null,
            'message' => $validatedData['message'],
            'pet_type_id' => $validatedData['pet_type_id'] ?? null,
            'service_id' => $validatedData['service_id'] ?? null,
            'status' => 'unread',
        ]);

        return back()->with('success', 'Your inquiry has been sent successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to send your inquiry. Please try again later.');
    }
}


    //  Show all inquiries for the admin (Sorted properly)
    public function index()
    {
        $inquiries = Inquiry::orderByRaw("CASE WHEN status = 'unread' THEN 1 ELSE 2 END")
                            ->orderBy('created_at', 'desc')
                            ->get();
    
        return view('admin.inquiries.index', compact('inquiries'));
    }


   //  Mark an inquiry as read
   public function markAsRead(Request $request, $id)
{
    try {
        $inquiry = Inquiry::findOrFail($id);
        
        // Direct database update to ensure it works
        DB::table('inquiries')
            ->where('id', $id)
            ->update(['status' => 'read']);
            
        // For logging/debugging
        Log::info("Inquiry {$id} marked as read");
        
        return response()->json(['success' => true, 'message' => 'Inquiry marked as read.']);
    } catch (\Exception $e) {
        Log::error("Error marking inquiry as read: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
    //  Delete inquiry with confirmation
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return response()->json(['success' => true, 'message' => 'Inquiry deleted successfully.']);
    }
}
