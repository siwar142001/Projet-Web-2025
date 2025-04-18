<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $user = auth()->user();
        $school = $user->schools()->first();

        $userRole = null;
        if ($school && $school->pivot) {
            $userRole = $school->pivot->role;
        }

        return view('pages.dashboard.dashboard-' . $userRole);
    }
}
