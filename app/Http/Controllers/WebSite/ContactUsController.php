<?php

namespace App\Http\Controllers\WebSite;

use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function contactUs(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'message' => 'required|string|max:255|min:5', // Replace 'your_field_name' with the actual field name you are validating
        ]);
        $userId = auth()->user()->id;
        // If validation passes, proceed with your logic
        $user = User::find($userId);
        Mail::to('lbkarim25@gmail.com')->send(new ContactUsMail($user, $request));
        return 'success';
    }
}
