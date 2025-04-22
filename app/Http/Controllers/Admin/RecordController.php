<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record; // Add this import
use App\Models\Appointment; // Add these other required models
use App\Models\Pet;
use App\Models\Service;

class RecordController extends Controller
{
    public function edit(Appointment $appointment, Pet $pet, Service $service)
    {
        $record = Record::firstOrNew([
            'appointment_id' => $appointment->id,
            'pet_id' => $pet->id,
            'service_id' => $service->id
        ]);

        return view('admin.records.edit', compact('appointment', 'pet', 'service', 'record'));
    }

    // Vaccination
    public function createVaccination(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.vaccination', compact('appointment', 'pet', 'service'));
    }

    public function storeVaccination(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        $validated = $request->validate([
            'vaccine_type' => 'required|string|max:255',
            'batch_number' => 'required|string|max:255',
            'administered_by' => 'required|string|max:255',
            'next_due_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $record = new Record($validated);
        $record->appointment()->associate($appointment);
        $record->pet()->associate($pet);
        $record->service()->associate($service);
        $record->save();

        return redirect()->route('admin.appointments.show-completed', $appointment)
            ->with('success', 'Vaccination record created successfully');
    }

    // Check-Up
    public function createCheckup(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.checkup', compact('appointment', 'pet', 'service'));
    }

    public function storeCheckup(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric',
            'temperature' => 'required|numeric',
            'heart_rate' => 'required|numeric',
            'respiratory_rate' => 'required|numeric',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $record = new Record($validated);
        $record->appointment()->associate($appointment);
        $record->pet()->associate($pet);
        $record->service()->associate($service);
        $record->save();

        return redirect()->route('admin.appointments.show-completed', $appointment)
            ->with('success', 'Check-up record created successfully');
    }

    // Surgery
    public function createSurgery(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.surgery', compact('appointment', 'pet', 'service'));
    }

    public function storeSurgery(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        $validated = $request->validate([
            'procedure_name' => 'required|string|max:255',
            'anesthesia_type' => 'required|string|max:255',
            'surgeon_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'complications' => 'nullable|string',
            'post_op_instructions' => 'required|string',
            'medications' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $record = new Record($validated);
        $record->appointment()->associate($appointment);
        $record->pet()->associate($pet);
        $record->service()->associate($service);
        $record->save();

        return redirect()->route('admin.appointments.show-completed', $appointment)
            ->with('success', 'Surgery record created successfully');
    }

    // Grooming
    public function createGrooming(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.grooming', compact('appointment', 'pet', 'service'));
    }

    public function storeGrooming(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        $validated = $request->validate([
            'groomer_name' => 'required|string|max:255',
            'grooming_type' => 'required|string|max:255',
            'products_used' => 'required|string',
            'coat_condition' => 'required|string|max:255',
            'skin_condition' => 'required|string|max:255',
            'behavior_notes' => 'nullable|string',
            'special_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $record = new Record($validated);
        $record->appointment()->associate($appointment);
        $record->pet()->associate($pet);
        $record->service()->associate($service);
        $record->save();

        return redirect()->route('admin.appointments.show-completed', $appointment)
            ->with('success', 'Grooming record created successfully');
    }

    // Boarding
    public function createBoarding(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.boarding', compact('appointment', 'pet', 'service'));
    }

    public function storeBoarding(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        $validated = $request->validate([
            'kennel_number' => 'required|string|max:255',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i|after:check_in_time',
            'feeding_schedule' => 'required|string',
            'medications_administered' => 'nullable|string',
            'activity_notes' => 'nullable|string',
            'behavior_notes' => 'nullable|string',
            'special_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $record = new Record($validated);
        $record->appointment()->associate($appointment);
        $record->pet()->associate($pet);
        $record->service()->associate($service);
        $record->save();

        return redirect()->route('admin.appointments.show-completed', $appointment)
            ->with('success', 'Boarding record created successfully');
    }
}
