<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class GroupModel extends Model
{
    protected $table = 'user_group';
    protected $allowedFields = [
        'name',
    ];
    protected $updatedField = 'updated_at';

    public function findGroupById($id)
    {
        $group = $this
            ->asArray()
            ->where(['id' => $id])
            ->first();

        if (!$group) throw new Exception('Could not find Group for specified ID');

        return $group;
    }

    public function deleteGroup($groupId)
    {
        $group = $this
            ->asArray()
            ->where(['id' => $groupId])
            ->delete();

        if (!$group) throw new Exception('Could not find Group for specified ID');

        return $group;
    }

}