<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class GuestServiceController extends Controller
{
    // Display guest services view
    public function index()
    {
        return view('guest.services.index');
    }

    // Fetch all services for AJAX request
    public function getAllServices()
    {
        $services = Service::with('animalTypes')->get();

        $response = [];
        foreach ($services as $service) {
            foreach ($service->animalTypes as $animalType) {
                $response[] = [
                    'name' => $service->name,
                    'animal_type' => $animalType->name,
                    'price' => $animalType->pivot->price,
                    'description' => $service->description ?? 'No description available',
                ];
            }
        }

        return response()->json($response);
    }
}
