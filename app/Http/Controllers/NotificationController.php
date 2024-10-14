<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function notification()
    {
        $notifications = Schedule::whereDate('date', Carbon::today())->get();
        return view('backend.report.notification.list', compact('notifications'));
    }
}
