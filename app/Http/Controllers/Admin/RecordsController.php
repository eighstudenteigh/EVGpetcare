<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Service;

class RecordsController extends Controller
{
// Finalized Records Index
    public function index()
{
    // Base query - only fetch finalized appointments
    $query = Appointment::with([
        'user:id,name,email',
        'pets:id,name', 
        'services:id,name',
        
        'records'
    ])
        ->where('status', 'finalized')
        ->whereNotNull('updated_at');
    // Simple search (client/pet name only)
    if(request('search')) {
        $query->where(function($q) {
            $q->whereHas('user', fn($user) => $user->where('name', 'like', '%'.request('search').'%'))
              ->orWhereHas('pets', fn($pet) => $pet->where('name', 'like', '%'.request('search').'%'));
        });
    }

    // Date filter only (removed pet type/service filters)
    if(request('date')) {
        $query->whereDate('finalized_at', request('date'));
    }

    // Final results
    $appointments = $query->orderBy('finalized_at', 'desc')
                         ->paginate(10);

    return view('admin.records.index', compact('appointments'));
}
public function show(Appointment $appointment)
{
    // Ensure only finalized appointments can be viewed
    abort_unless($appointment->status === 'finalized', 404);

    // Load all necessary relationships
    $appointment->load([
        'user',
        'pets.services',
        'services',
        'records.vaccination',
        'records.grooming',
        'records.checkup',
        'records.surgery',
        'records.boarding',
        'records.pet',
        'records.service',
    ]);

    return view('admin.records.show', compact('appointment'));
}

}