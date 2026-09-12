<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Contact Us Page
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle Contact Form Submission
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:25',
            'inquiry_type' => 'required|string|max:100',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        ContactInquiry::create($validated);

        return redirect()->route('contact')->with('success', 'Thank you for reaching out to Pristo. Our architecture and materials concierge will get in touch with you within 24 business hours.');
    }

    /**
     * About Us Page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Terms & Conditions Page
     */
    public function terms()
    {
        return view('pages.terms');
    }
}
