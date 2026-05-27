<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ForgotPasswordRequest;
use App\Models\PasswordResetRequest as PasswordResetRequestModel;
use App\Models\User;
use App\Notifications\AdminPasswordResetRequestMail;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordController extends Controller
{
    public function show()
    {
        return view('admin.auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        $resetRequest = PasswordResetRequestModel::create([
            'email' => $email,
            'user_id' => $user?->id,
            'status' => 'pending',
        ]);

        $admins = User::query()
            ->whereIn('role', ['super_admin', 'admin'])
            ->where('is_active', true)
            ->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new AdminPasswordResetRequestMail($resetRequest));
        }

        // Always respond with success to avoid leaking whether an email exists.
        return redirect()->route('admin.login')->with(
            'success',
            'If the email exists in our system, your request has been sent to the administrator.'
        );
    }
}

