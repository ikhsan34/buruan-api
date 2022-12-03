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