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
    
        // Apply filters - changed to search by service name instead of type
        if ($request->filled('service')) {
            $query->whereHas('services', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->service.'%');
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
        $services = Service::distinct('name')->orderBy('name')->pluck('name'); // Get distinct service names
        
        return view('admin.records.index', compact('appointments', 'services')); // Pass services to the view
    }
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
        'services',
    ])->findOrFail($id);

    return view('admin.records.show', compact('appointment'));
}

   
}