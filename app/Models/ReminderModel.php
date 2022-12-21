<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ReminderModel extends Model
{
    protected $table = 'reminder';
    protected $allowedFields = [
        'group_id',
        'user_id',
        'name',
        'desc',
        'deadline',
        'reminded',
    ];
    protected $updatedField = 'updated_at';

    public function findAllReminder() {
        $group = $this
            ->asArray()
            ->where(['reminded' => 0])
            ->findAll();

        if (!$group) throw new Exception('Could not find Group for specified ID');

        return $group;
    }

    public function deleteReminderById($id)
    {
        $reminder = $this
            ->asArray()
            ->where(['id' => $id])
            ->delete();

        if (!$reminder) throw new Exception('Could not find Group for specified ID');

        return $reminder;
    }

    public function findReminderById($id)
    {
        $reminder = $this
            ->asArray()
            ->where(['id' => $id])
            ->first();

        if (!$reminder) throw new Exception('Could not find reminder for specified ID');

        return $reminder;
    }

    public function findReminderByUserId($id)
    {
        $reminder = $this
            ->asArray()
            ->where(['user_id' => $id])
            ->findAll();

        if (!$reminder) throw new Exception('Could not find reminder for specified User ID');

        return $reminder;
    }

    public function findReminderByGroupId($id) {
        $reminder = $this
            ->asArray()
            ->where(['group_id' => $id])
            ->findAll();

        if (!$reminder) throw new Exception('Could not find reminder for specified Group ID');

        return $reminder;
    }

}