<?php

namespace App\Http\Controllers\Custoer;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function notifications()
    {
        $count = auth()->user()->unreadNotifications->count();
        $notifications = auth()->user()->notifications->take(5);

        return response()->json(['status' => true, "count" => $count, 'notifications' => $notifications], 200);
    }
    public function all_notifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $notifications = auth()->user()->notifications;

        return response()->json(['status' => true, 'notifications' => $notifications], 200);
    }
    public function unread_notifications()
    {
        $notifications = auth()->user()->unreadNotifications;
        return response()->json(['status' => true, "message" => "Password updated successfully", 'notifications' => $notifications], 200);
    }
    public function read_notifications()
    {
        $notifications = auth()->user()->readNotifications;
        return response()->json(['status' => true, "message" => "Password updated successfully", 'notifications' => $notifications], 200);
    }

    public function mark_as_read_notifications()
    {
        $notifications = auth()->user()->readNotifications;
        return response()->json(['status' => true, "message" => "Password updated successfully", 'notifications' => $notifications], 200);
    }
}
