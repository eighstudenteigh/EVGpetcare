<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\GroomingRecord;
use App\Models\MedicalRecord;
use App\Models\BoardingRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetRecordController extends Controller
{
    public function show(Appointment $appointment)
{
    $appointment->load(['pets', 'services', 'user']);
    
    return view('admin.pet-records.show', [
        'appointment' => $appointment,
        'pets' => $appointment->pets,
        'services' => $appointment->services
    ]);
}
public function createGroomingRecord(Appointment $appointment, Pet $pet)
{
    // Check if record already exists for edit
    $record = GroomingRecord::where('appointment_id', $appointment->id)
                          ->where('pet_id', $pet->id)
                          ->first();

    return view('admin.forms.grooming-form', [
        'appointment' => $appointment,
        'pet' => $pet,
        'record' => $record
    ]);
}

public function storeGroomingRecord(Request $request, Appointment $appointment, Pet $pet)
{
    $request->merge(['pet_id' => $pet->id]);

    // Try to find existing grooming record
    $record = GroomingRecord::where('appointment_id', $appointment->id)
                             ->where('pet_id', $pet->id)
                             ->first();

    return $this->updateGroomingRecord($request, $appointment, $record); 
}


public function updateGroomingRecord(Request $request, Appointment $appointment, GroomingRecord $record = null)
{
    $validated = $request->validate([
        'notes' => 'required|string',
        'products_used' => 'nullable|string',
        'before_photos' => 'nullable|array|max:3',
        'before_photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        'after_photos' => 'nullable|array|max:3',
        'after_photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    // Handle photos
    $beforePhotos = $record ? json_decode($record->before_photo_path, true) ?? [] : [];
    $afterPhotos = $record ? json_decode($record->after_photo_path, true) ?? [] : [];

    if ($request->hasFile('before_photos')) {
        foreach ($request->file('before_photos') as $photo) {
            $path = $photo->store('grooming/before', 'public');
            $beforePhotos[] = $path;
        }
    }

    if ($request->hasFile('after_photos')) {
        foreach ($request->file('after_photos') as $photo) {
            $path = $photo->store('grooming/after', 'public');
            $afterPhotos[] = $path;
        }
    }

    $data = [
        'appointment_id' => $appointment->id,
        'pet_id' => $request->input('pet_id'),
        'notes' => $validated['notes'],
        'products_used' => json_encode(explode(',', $validated['products_used'])),
        'before_photo_path' => json_encode($beforePhotos),
        'after_photo_path' => json_encode($afterPhotos)
    ];

    if ($record) {
        $record->update($data);
    } else {
        $record = GroomingRecord::create($data);
    }

    return redirect()->route('admin.pet-records.show', $appointment->id)
        ->with('success', 'Grooming record ' . ($record->wasRecentlyCreated ? 'created' : 'updated') . ' successfully');
}

public function deleteGroomingPhoto(Request $request, GroomingRecord $record)
{
    $request->validate([
        'photo_url' => 'required|string',
        'photo_type' => 'required|in:before,after'
    ]);

    try {
        $photoArray = json_decode($record->{$request->photo_type . '_photo_path'}, true);
        $updatedPhotos = array_filter($photoArray, fn($photo) => $photo !== $request->photo_url);
        
        $record->update([
            $request->photo_type . '_photo_path' => json_encode(array_values($updatedPhotos))
        ]);

        // Optionally delete the file from storage
        Storage::disk('public')->delete($request->photo_url);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false], 500);
    }
}
    public function storeMedicalRecord(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'weight' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'follow_up_date' => 'nullable|date',
            'prescriptions' => 'array',
            'prescriptions.*.name' => 'required|string',
            'prescriptions.*.dosage' => 'required|string',
        ]);

        $record = MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'pet_id' => $appointment->pets->first()->id,
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'],
            'vitals' => json_encode([
                'weight' => $validated['weight'],
                'temperature' => $validated['temperature']
            ]),
            'follow_up_date' => $validated['follow_up_date'],
            'prescriptions' => json_encode($validated['prescriptions'])
        ]);

        return redirect()->route('admin.appointments.approved')
            ->with('success', 'Medical record created successfully');
    }
    public function storeBoardingRecord(Request $request, Appointment $appointment)
{
    $validated = $request->validate([
        'check_in' => 'required|date',
        'check_out' => 'nullable|date|after_or_equal:check_in',
        'daily_notes' => 'nullable|string'
    ]);

    BoardingRecord::create([
        'appointment_id' => $appointment->id,
        'pet_id' => $request->input('pet_id'),
        'check_in' => $validated['check_in'],
        'check_out' => $validated['check_out'],
        'daily_notes' => $validated['daily_notes'],
    ]);

    return redirect()->route('admin.appointments.approved')
        ->with('success', 'Boarding record created successfully');
}


public function createMedicalRecord(Appointment $appointment, Pet $pet)
{
    return view('admin.forms.medical-form', compact('appointment', 'pet'));
}

public function createBoardingRecord(Appointment $appointment, Pet $pet)
{
    return view('admin.forms.boarding-form', compact('appointment', 'pet'));
}

}