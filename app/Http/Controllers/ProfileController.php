<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        try {
            /**
             * if the user object doesn't have a ssn
             * and the request has a ss_number
             * then we can assign one to the user
             */
            if($user->ss_number == "" && $request->ss_number) {
                $req_ssn = $request->ss_number;
                // check for any non-numeric numbers and the length is 9 characters long
                $character_regex = '/[a-zA-Z](9)/';

                // if the request ssn doesn't have a non-numberic character and is 9  characters long throw an error
                if (preg_match($character_regex, $req_ssn)) {
                    return back()->withErrors(['ss_number' => "There is an error with your Social Security Number."]);
                }

                $user->ss_number = $request->ss_number;
            }

            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            return Redirect::route('profile.edit');

        } catch (\Throwable $th) {
            return back()->withErrors(['error' => "An error occurred while trying to save your changes: ". $th->getMessage()]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if($user['is_admin']) {
            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

        }
        return Redirect::to('/');

    }
}
