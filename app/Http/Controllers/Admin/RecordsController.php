<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Service;

class RecordsController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with([
            'user',
            'pets' => function($query) {
                $query->with([
                    'groomingRecords',
                    'medicalRecords',
                    'boardingRecords'
                ]);
            },
            'services',
        ])
        ->whereIn('status', ['finalized'])
        ->latest();

        // Apply filters
        if ($request->filled('type')) {
            $query->whereHas('services', function($q) use ($request) {
                $q->where('service_type', $request->type);
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        if ($request->filled('pet_type')) {
            $query->whereHas('pets', function($q) use ($request) {
                $q->where('type', $request->pet_type);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('pets', function($petQuery) use ($search) {
                    $petQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('services', function($serviceQuery) use ($search) {
                    $serviceQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        $appointments = $query->paginate(10);
        
        return view('admin.records.index', compact('appointments'));
    }
    public function show($id)
{
    $appointment = Appointment::with([
        'user',
        'pets' => function($query) {
            $query->with([
                'groomingRecords',
                'medicalRecords',
                'boardingRecords'
            ]);
        },
        'services',
    ])->findOrFail($id);

    return view('admin.records.show', compact('appointment'));
}

    public function export(Request $request)
    {
        $fileName = 'service-records-' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"             => "no-cache",
            "Cache-Control"      => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $query = Appointment::with(['user', 'pets', 'services'])
            ->whereIn('status', ['completed', 'finalized'])
            ->latest();

        // Apply the same filters as index method
        if ($request->filled('type')) {
            $query->whereHas('services', function($q) use ($request) {
                $q->where('service_type', $request->type);
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('pets', function($petQuery) use ($search) {
                    $petQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('services', function($serviceQuery) use ($search) {
                    $serviceQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        $appointments = $query->get();

        $callback = function() use($appointments) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'Appointment ID', 'Date', 'Client', 'Pet(s)', 
                'Services', 'Status', 'Completed At'
            ]);

            foreach ($appointments as $appointment) {
                $pets = $appointment->pets->pluck('name')->join(', ');
                $services = $appointment->services->pluck('name')->join(', ');
                
                fputcsv($file, [
                    $appointment->id,
                    optional($appointment->appointment_date)->format('Y-m-d') ?? '',
                    optional($appointment->user)->name ?? 'N/A',
                    $pets,
                    $services,
                    ucfirst($appointment->status),
                    optional($appointment->updated_at)->format('Y-m-d H:i:s') ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}