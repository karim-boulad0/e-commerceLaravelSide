<?php

namespace App\Http\Controllers\WebSite;

use Exception;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function checkUserDetails()
    {
        $user = Auth::user();
        if ($user->userDetails) {
            return response()->json(['hasDetails' => true, 'details' => $user->details]);
        } else {
            return response()->json(['hasDetails' => false, 'details' => null]);
        }
    }

    public function isAuthExist()
    {
        return auth()->user();
    }

    public function show()
    {
        return auth()->user()->userDetails;
    }

    public function storeDetails(Request $request)
    {
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'birthDate' => 'nullable',
            'gender' => 'nullable|in:male,female',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try { // Associate the user details with the authenticated user
            $user = auth()->user();

            // Check if the user already has user details
            if ($user->userDetails) {
                // Update existing user details
                $user->userDetails->update($request->all());
            } else {
                // Create new user details
                $user->userDetails()->create($request->all());
            }
            // Optionally, you can redirect the user to their profile page}
            return response()->json('success');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
