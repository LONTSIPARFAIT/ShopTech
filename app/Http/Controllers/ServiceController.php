<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        $plomerieServices = $services->where('type', 'plomberie')->values();
        $electriciteServices = $services->where('type', 'electricite')->values();

        return Inertia::render('Services/Index', [
            'plumerieServices' => $plomerieServices,
            'electriciteServices' => $electriciteServices,
        ]);
    }

    public function show(Service $service)
    {
        return Inertia::render('Services/Show', [
            'service' => $service,
            'relatedServices' => Service::active()
                ->where('type', $service->type)
                ->where('id', '!=', $service->id)
                ->limit(3)
                ->get(),
        ]);
    }
}
