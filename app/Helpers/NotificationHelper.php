<?php

// app/Helpers/NotificationHelper.php
if (!function_exists('notify')) {
    function notify($userId, $title, $message, $type = 'info', $data = [])
    {
        try {
            // Kiểm tra userId hợp lệ
            if (!$userId || !\App\Models\User::find($userId)) {
                \Log::warning("notify() failed: Invalid user_id {$userId}");
                return false;
            }

            \App\Models\Notification::create([
                'user_id' => $userId,
                'title'   => $title,
                'message' => $message,
                'type'    => $type,
                'data'    => $data ? json_encode($data) : null,
            ]);

            return true;
        } catch (\Exception $e) {
            // KHÔNG ĐỂ LỖI NOTIFY LÀM HỦY TOÀN BỘ BOOKING!!!
            \Log::error("Notification failed: " . $e->getMessage());
            return false;
        }
    }
}