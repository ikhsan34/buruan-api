<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class HistoryModel extends Model
{
    protected $table = 'history';
    protected $allowedFields = [
        'group_id',
        'user_id',
        'name',
        'desc',
        'deadline',
    ];
    protected $updatedField = 'updated_at';

    public function getHistory() {
        $reminder = $this
            ->asArray()
            ->findAll();

        if (!$reminder) throw new Exception('Could not find history for specified Group ID');

        return $reminder;
    }

    public function getHistoryByUserId($id) {
        $reminder = $this
            ->asArray()
            ->where(['user_id' => $id])
            ->findAll();

        if (!$reminder) throw new Exception('Could not find history for specified Group ID');

        return $reminder;
    }

}