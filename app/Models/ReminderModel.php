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

    public function findreminderById($id)
    {
        $reminder = $this
            ->asArray()
            ->where(['id' => $id])
            ->first();

        if (!$reminder) throw new Exception('Could not find reminder for specified ID');

        return $reminder;
    }
}