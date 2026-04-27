<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function about(): \Inertia\Response
    {
        return Inertia::render('Pages/About');
    }

    public function contact(): \Inertia\Response
    {
        return Inertia::render('Pages/Contact');
    }

    public function services(): \Inertia\Response
    {
        return Inertia::render('Pages/Services');
    }

    public function sendContact(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        // Here you would send an email or save to database
        // For now we just redirect back with success
        return back()->with('success', 'Votre message a été envoyé avec succès!');
    }
}
