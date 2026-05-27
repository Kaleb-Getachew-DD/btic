<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResolvePasswordResetRequest;
use App\Models\PasswordResetRequest;
use Illuminate\Support\Facades\Hash;

class PasswordResetRequestController extends Controller
{
    public function index()
    {
        $requests = PasswordResetRequest::query()
            ->with(['user', 'resolver', 'canceller'])
            ->latest()
            ->paginate(15);

        return view('admin.password-resets.index', [
            'requests' => $requests,
        ]);
    }

    public function resolve(ResolvePasswordResetRequest $request, PasswordResetRequest $passwordResetRequest)
    {
        if ($passwordResetRequest->status === 'resolved') {
            return back()->with('error', 'This reset request is already resolved.');
        }
        if ($passwordResetRequest->is_cancelled) {
            return back()->with('error', 'This reset request was cancelled.');
        }

        $user = $passwordResetRequest->user;
        if (!$user) {
            return back()->withErrors(['password' => 'No user was found for this email. Create the user first or re-submit the request.']);
        }

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        $passwordResetRequest->update([
            'status' => 'resolved',
            'resolved_by' => $request->user()->id,
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Password updated and request marked as resolved.');
    }

    public function cancel(PasswordResetRequest $passwordResetRequest)
    {
        if ($passwordResetRequest->status === 'resolved') {
            return back()->with('error', 'This reset request is already resolved.');
        }

        if ($passwordResetRequest->is_cancelled) {
            return back()->with('error', 'This reset request is already cancelled.');
        }

        $passwordResetRequest->update([
            'is_cancelled' => true,
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Reset request cancelled.');
    }
}

