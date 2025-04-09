<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Indefinite suspension
    public function suspend(User $user)
    {
        $user->suspend();
        return response()->json(['message' => 'User suspended indefinitely.']);
    }

    // Temporary suspension (7 days)
    public function tempSuspend(User $user)
    {
        $user->suspend(Carbon::now()->addDays(7));
        return response()->json([
            'message' => 'User suspended for 7 days.',
            'until' => $user->suspended_until
        ]);
    }

    // Unsuspend
    public function unsuspend(User $user)
    {
        $user->unsuspend();
        return response()->json(['message' => 'User unsuspended successfully.']);
    }

    // Check status
    public function status(User $user)
    {
        return response()->json([
            'suspended' => $user->isSuspended(),
            'remaining' => $user->suspensionRemaining(),
            'until' => $user->suspended_until
        ]);
    }
}
