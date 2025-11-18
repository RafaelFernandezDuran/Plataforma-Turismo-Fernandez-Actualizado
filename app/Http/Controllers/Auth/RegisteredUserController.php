<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTouristRequest;
use App\Services\UserStoredProcedureService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct(private readonly UserStoredProcedureService $userProcedures)
    {
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreTouristRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $user = $this->userProcedures->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'] ?? null,
                'birth_date' => null,
                'nationality' => $validated['nationality'],
                'document_type' => null,
                'document_number' => null,
                'user_type' => $validated['user_type'],
                'preferences' => json_encode([]),
                'opt_out_recommendations' => false,
                'avatar' => null,
                'language' => 'es',
                'newsletter_subscription' => true,
            ]);
        } catch (QueryException $exception) {
            throw ValidationException::withMessages([
                'email' => $exception->getMessage(),
            ]);
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
