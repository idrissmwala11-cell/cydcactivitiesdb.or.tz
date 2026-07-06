<?php

namespace App\Http\Controllers;

use App\Models\SmsLog;
use App\Models\User;
use App\Services\SmsSender;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSmsController extends Controller
{
    public function index(): View
    {
        $usersWithPhones = User::query()
            ->where('role', 'user')
            ->where('status', 'approved')
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->count();

        return view('admin.sms.index', [
            'usersWithPhones' => $usersWithPhones,
            'latestLogs' => SmsLog::with('user')->latest()->take(20)->get(),
            'gatewayEnabled' => (bool) config('sms_gateway.enabled'),
            'remindersEnabled' => (bool) config('sms_gateway.reminders.enabled'),
        ]);
    }

    public function sendTest(Request $request, SmsSender $sender): RedirectResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:480'],
        ]);

        $log = $sender->sendToPhone(
            $validated['phone'],
            $validated['message'],
            'test',
            $request->user()
        );

        if ($log->status === 'sent') {
            return back()->with('success', 'Test SMS imetumwa vizuri kwenda '.$log->phone.'.');
        }

        return back()->with('error', 'SMS haijatumwa: '.$log->error_message);
    }
}
