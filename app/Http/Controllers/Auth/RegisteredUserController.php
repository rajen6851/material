<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:homeowner,professional'],
            'professional_type' => ['required_if:role,professional', 'nullable', 'string', 'in:contractor,architect,designer,builder'],
            'company_name' => ['required_if:role,professional', 'nullable', 'string', 'max:255'],
            'gst_number' => ['required_if:role,professional', 'nullable', 'string', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'],
            'company_profile' => ['nullable', 'string'],
        ], [
            'gst_number.regex' => 'Please enter a valid GST number (e.g. 27AAACJ1234D1Z5).',
            'professional_type.required_if' => 'Please select your profession.',
            'company_name.required_if' => 'Company name is required for professional registration.',
            'gst_number.required_if' => 'GST number is required for professional registration.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'professional_type' => $request->role === 'professional' ? $request->professional_type : null,
            'company_name' => $request->role === 'professional' ? $request->company_name : null,
            'gst_number' => $request->role === 'professional' ? $request->gst_number : null,
            'company_profile' => $request->role === 'professional' ? $request->company_profile : null,
            'is_gst_verified' => $request->role === 'professional' ? false : false, // Needs admin approval/verification
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
