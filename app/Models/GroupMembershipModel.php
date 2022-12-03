<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class GroupMembershipModel extends Model
{
    protected $table = 'group_membership';
    protected $allowedFields = [
        'group_id',
        'user_id',
    ];
    protected $updatedField = 'updated_at';

    public function findGroupById($id)
    {
        $Group = $this
            ->asArray()
            ->where(['group_id' => $id])
            ->first();

        if (!$Group) throw new Exception('Could not find Group Membership for specified ID');

        return $Group;
    }

    public function userLeaveGroup($groupId, $userId)
    {
        $Group = $this
            ->asArray()
            ->where(['group_id' => $groupId, 'user_id' => $userId])
            ->delete();

        if (!$Group) throw new Exception('Could not find Group Membership for specified ID');

        return $Group;
    }
}