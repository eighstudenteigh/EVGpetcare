<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\GroomingRecord;
use App\Models\MedicalRecord;
use App\Models\BoardingRecord;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetRecordController extends Controller
{
    public function show($id)
{
    $appointment = Appointment::with([
        'user',
        'pets' => function($query) use ($id) {
            $query->with([
                'groomingRecords' => function($q) use ($id) {
                    $q->where('appointment_id', $id);
                },
                'medicalRecords' => function($q) use ($id) {
                    $q->where('appointment_id', $id);
                },
                'boardingRecords' => function($q) use ($id) {
                    $q->where('appointment_id', $id);
                }
            ]);
        },
        'services', // Ensure services are loaded
    ])->findOrFail($id);

    return view('admin.records.show', compact('appointment'));
}
public function createGroomingRecord(Appointment $appointment, Pet $pet)
{
    return view('admin.forms.grooming-form', [
        'appointment' => $appointment,
        'pet' => $pet,
        'record' => null // Explicitly no record for create
    ]);
}

public function storeGrooming(Request $request, Appointment $appointment, Pet $pet)
{
    $validated = $request->validate([
        'notes' => 'required',
        'products_used' => 'nullable|string', // Ensure this matches your DB
        'before_photos.*' => 'nullable|image|max:2048',
        'after_photos.*' => 'nullable|image|max:2048'
    ]);

    // Convert products_used to JSON if your DB expects it
    $productsUsed = !empty($validated['products_used']) 
        ? json_encode(explode(',', $validated['products_used']))
        : null;

    // Handle file uploads
    $beforePhotos = [];
    if ($request->hasFile('before_photos')) {
        foreach ($request->file('before_photos') as $photo) {
            $path = $photo->store('public/grooming/before');
            $beforePhotos[] = basename($path);
        }
    }

    $afterPhotos = [];
    if ($request->hasFile('after_photos')) {
        foreach ($request->file('after_photos') as $photo) {
            $path = $photo->store('public/grooming/after');
            $afterPhotos[] = basename($path);
        }
    }

    $record = new GroomingRecord([
        'pet_id' => $pet->id,
        'appointment_id' => $appointment->id,
        'notes' => $validated['notes'],
        'products_used' => $productsUsed, // Use the processed value
        'before_photo_path' => !empty($beforePhotos) ? json_encode($beforePhotos) : null,
        'after_photo_path' => !empty($afterPhotos) ? json_encode($afterPhotos) : null
    ]);

    $record->save();

    return redirect()->route('admin.pet-records.show', $appointment->id)
        ->with('success', 'Grooming record created successfully.');
}


    

public function editGroomingRecord(Appointment $appointment, GroomingRecord $grooming_record)
{
    return view('admin.forms.grooming-form', [
        'appointment' => $appointment,
        'pet' => $grooming_record->pet,
        'record' => $grooming_record
    ]);
}
public function updateGrooming(Request $request, Appointment $appointment, GroomingRecord $grooming_record)
{
    $validated = $request->validate([
        'notes' => 'required',
        'products_used' => 'nullable|string',
        'before_photos.*' => 'nullable|image|max:2048',
        'after_photos.*' => 'nullable|image|max:2048'
    ]);

    // Handle file uploads - before photos
    $currentBeforePhotos = json_decode($grooming_record->before_photo_path) ?? [];
    if ($request->hasFile('before_photos')) {
        foreach ($request->file('before_photos') as $photo) {
            $path = $photo->store('public/grooming/before');
            $currentBeforePhotos[] = basename($path);
        }
    }

    // Handle file uploads - after photos
    $currentAfterPhotos = json_decode($grooming_record->after_photo_path) ?? [];
    if ($request->hasFile('after_photos')) {
        foreach ($request->file('after_photos') as $photo) {
            $path = $photo->store('public/grooming/after');
            $currentAfterPhotos[] = basename($path);
        }
    }

    $grooming_record->update([
        'notes' => $validated['notes'],
        'products_used' => $validated['products_used'],
        'before_photo_path' => !empty($currentBeforePhotos) ? json_encode($currentBeforePhotos) : null,
        'after_photo_path' => !empty($currentAfterPhotos) ? json_encode($currentAfterPhotos) : null
    ]);

    return redirect()->route('admin.pet-records.show', $appointment->id)
        ->with('success', 'Grooming record updated successfully.');
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
}