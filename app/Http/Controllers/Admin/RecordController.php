<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\GroomingRecord;
use App\Models\VaccinationRecord;
use App\Models\CheckupRecord;
use App\Models\SurgeryRecord;
use App\Models\BoardingRecord;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($request, $appointment, $pet, $service) {
            // Create base record
            $record = Record::create([
                'appointment_id' => $appointment->id,
                'pet_id' => $pet->id,
                'service_id' => $service->id,
                'type' => 'vaccination',
                'notes' => $request->notes
            ]);

            // Create vaccination-specific record
            VaccinationRecord::create([
                'record_id' => $record->id,
                'vaccine_type' => $request->vaccine_type,
                'batch_number' => $request->batch_number,
                'administered_by' => $request->administered_by,
                'next_due_date' => $request->next_due_date
            ]);

            return redirect()->route('admin.appointments.show-completed', $appointment)
                ->with('success', 'Vaccination record created successfully');
        });
    }

    // Check-Up
    public function createCheckup(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.checkup', compact('appointment', 'pet', 'service'));
    }

    public function storeCheckup(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        return DB::transaction(function () use ($request, $appointment, $pet, $service) {
            $record = Record::create([
                'appointment_id' => $appointment->id,
                'pet_id' => $pet->id,
                'service_id' => $service->id,
                'type' => 'checkup',
                'notes' => $request->notes
            ]);

            CheckupRecord::create([
                'record_id' => $record->id,
                'weight' => $request->weight,
                'temperature' => $request->temperature,
                'heart_rate' => $request->heart_rate,
                'respiratory_rate' => $request->respiratory_rate,
                'diagnosis' => $request->diagnosis,
                'treatment_plan' => $request->treatment_plan
            ]);

            return redirect()->route('admin.appointments.show-completed', $appointment)
                ->with('success', 'Check-up record created successfully');
        });
    }

    // Surgery
    public function createSurgery(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.surgery', compact('appointment', 'pet', 'service'));
    }

    public function storeSurgery(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        return DB::transaction(function () use ($request, $appointment, $pet, $service) {
            $record = Record::create([
                'appointment_id' => $appointment->id,
                'pet_id' => $pet->id,
                'service_id' => $service->id,
                'type' => 'surgery',
                'notes' => $request->notes
            ]);

            SurgeryRecord::create([
                'record_id' => $record->id,
                'procedure_name' => $request->procedure_name,
                'anesthesia_type' => $request->anesthesia_type,
                'surgeon_name' => $request->surgeon_name,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'complications' => $request->complications,
                'post_op_instructions' => $request->post_op_instructions,
                'medications' => $request->medications
            ]);

            return redirect()->route('admin.appointments.show-completed', $appointment)
                ->with('success', 'Surgery record created successfully');
        });
    }

    // Grooming
    public function createGrooming(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.grooming', compact('appointment', 'pet', 'service'));
    }

    public function storeGrooming(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        return DB::transaction(function () use ($request, $appointment, $pet, $service) {
            $record = Record::create([
                'appointment_id' => $appointment->id,
                'pet_id' => $pet->id,
                'service_id' => $service->id,
                'type' => 'grooming',
                'notes' => $request->notes
            ]);

            GroomingRecord::create([
                'record_id' => $record->id,
                'groomer_name' => $request->groomer_name,
                'grooming_type' => $request->grooming_type,
                'products_used' => $request->products_used,
                'coat_condition' => $request->coat_condition,
                'skin_condition' => $request->skin_condition,
                'behavior_notes' => $request->behavior_notes,
                'special_instructions' => $request->special_instructions
            ]);

            return redirect()->route('admin.appointments.show-completed', $appointment)
                ->with('success', 'Grooming record created successfully');
        });
    }

    // Boarding
    public function createBoarding(Appointment $appointment, Pet $pet, Service $service)
    {
        return view('admin.records.create.boarding', compact('appointment', 'pet', 'service'));
    }

    public function storeBoarding(Request $request, Appointment $appointment, Pet $pet, Service $service)
    {
        return DB::transaction(function () use ($request, $appointment, $pet, $service) {
            $record = Record::create([
                'appointment_id' => $appointment->id,
                'pet_id' => $pet->id,
                'service_id' => $service->id,
                'type' => 'boarding',
                'notes' => $request->notes
            ]);

            BoardingRecord::create([
                'record_id' => $record->id,
                'kennel_number' => $request->kennel_number,
                'check_in_time' => $request->check_in_time,
                'check_out_time' => $request->check_out_time,
                'feeding_schedule' => $request->feeding_schedule,
                'medications_administered' => $request->medications_administered,
                'activity_notes' => $request->activity_notes,
                'behavior_notes' => $request->behavior_notes,
                'special_instructions' => $request->special_instructions
            ]);

            return redirect()->route('admin.appointments.show-completed', $appointment)
                ->with('success', 'Boarding record created successfully');
        });
    }
}