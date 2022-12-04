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

    public function findGroupByUserId($id)
    {
        $Group = $this
            ->asArray()
            ->where(['group_id' => $id])
            ->findAll();

        if (!$Group) throw new Exception('Could not find Group Membership for specified ID');

        return $Group;
    }

    public function findGroupByGroupId($id)
    {
        $Group = $this
            ->asArray()
            ->where(['user_id' => $id])
            ->findAll();

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

    public function userDeleteGroup($groupId)
    {
        $Group = $this
            ->asArray()
            ->where(['group_id' => $groupId])
            ->delete();

        if (!$Group) throw new Exception('Could not find Group Membership for specified ID');

        return $Group;
    }
}