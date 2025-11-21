<?php
namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Create a notification
     *  
     * @param int $receiverId
     * @param int|null $actorId
     * @param string $type
     * @param string|null $sourceTable
     * @param int|null $sourceId
     * @param string $title
     * @param string|null $message
     */
    public static function createNotification(
        int $receiverId,
        ?int $actorId,
        string $type,
        ?string $sourceTable,
        ?int $sourceId,
        string $title,
        ?string $message = null
    ) {
        return Notification::create([
            'user_id' => $receiverId,
            'from_user_id' => $actorId,
            'type' => $type,
            'source_table' => $sourceTable,
            'source_id' => $sourceId,
            'title' => $title,
            'message' => $message,
        ]);
    }
}
