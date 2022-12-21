<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupMembershipModel;
use App\Models\ReminderModel;
use App\Models\GroupModel;
// use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Client extends BaseController
{
    /**
     * Get all Clients
     * @return Response
     */

    public function updateProfile($id)
    {
        try {
            $rules = [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]'
            ];
    
            $input = $this->getRequestInput($this->request);
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
            }
    
            $userModel = new UserModel();
            $userModel->findUserById($id);
            $userModel->update($id, $input);
    
            $user = $userModel->findUserById($id);
    
            return $this->getResponse(
                [
                    'message' => 'user updated successfully',
                    'user' => $user
                ]
            );
        } catch (Exception $exception) {

            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function insertReminder()
    {
        $rules = [
            'name' => 'required',
            'desc' => 'required',
            'deadline' => 'required'
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse(
                $this->validator->getErrors(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        $reminderName = $input['name'];
        $model = new ReminderModel();
        $model->save($input);
        $reminder = $model->where('name', $reminderName)->first();

        return $this->getResponse(
            [
                'message' => 'Reminder added successfully',
                'reminder' => $reminder
            ]
        );
    }

    public function showReminder()
    {
        try {
            $model = new ReminderModel();
            $reminder = $model->findAll();

            return $this->getResponse(
                [
                    'message' => 'Reminder retrieved successfully',
                    'reminder' => $reminder
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find reminder'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function showReminderByUserId($id)
    {
        try {
            $model = new ReminderModel();
            $reminder = $model->findReminderByUserId($id);

            return $this->getResponse(
                [
                    'message' => 'Reminder retrieved successfully',
                    'reminder' => $reminder
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find reminder'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function showReminderByGroupId($id)
    {
        try {
            $model = new ReminderModel();
            $reminder = $model->findReminderByGroupId($id);

            return $this->getResponse(
                [
                    'message' => 'Reminder retrieved successfully',
                    'reminder' => $reminder
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find reminder'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function updateReminder($id)
    {
        try {
            $model = new ReminderModel();
            $model->findReminderById($id);

            $input = $this->request->getRawInput();

            $model->update($id, $input);
            $reminder = $model->findReminderById($id);

            return $this->getResponse(
                [
                    'message' => 'Reminder updated successfully',
                    'reminder' => $reminder
                ]
            );
        } catch (Exception $exception) {

            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function createGroup()
    {
        $rules = [
            'user_id' => 'required',
            'name' => 'required',
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse(
                $this->validator->getErrors(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        $groupName = $input['name'];
        $model = new GroupModel();
        $model->save($input);
        $group = $model->where('name', $groupName)->first();
        $groupId = $model->getInsertID();


        $data = [
            'user_id' => $input['user_id'],
            'group_id' => $groupId
        ];

        $group_membership = new GroupMembershipModel();
        $group_membership->insert($data);

        return $this->getResponse(
            [
                'message' => 'Group added successfully',
                'group' => $group
            ]
        );
    }
    public function joinGroup()
    {
        $rules = [
            'group_id' => 'required',
            'user_id' => 'required',
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse(
                $this->validator->getErrors(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }


        $groupMembershipId = $input['group_id'];
        $model = new GroupMembershipModel();
        $model->insert($input);
        $groupMembership = $model->where('group_id', $groupMembershipId)->first();

        return $this->getResponse(
            [
                'message' => 'Group join successfully',
                'groupMembership' => $groupMembership
            ]
        );
    }

    public function leaveGroup($groupId, $userId)
    {
        try {
            $model = new GroupMembershipModel();
            $group = $model->userLeaveGroup($groupId, $userId);


            return $this->getResponse(
                [
                    'message' => 'leave group successfully',
                    'group' => $group
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Error leaving'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function showGroup($groupId)
    {
        try {
            $model = new GroupModel();
            $group = $model->findGroupById($groupId);


            return $this->getResponse(
                [
                    'message' => 'group retrieved successfully',
                    'group' => $group
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find group'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function deleteGroup($groupId)
    {
        try {
            $model = new GroupModel();
            $group = $model->deleteGroup($groupId);

            $model2 = new GroupMembershipModel();
            $group2 = $model2->userDeleteGroup($groupId);


            return $this->getResponse(
                [
                    'message' => 'group retrieved successfully',
                    'group' => [$group, $group2]
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find group'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function showGroupByUserId($id)
    {
        try {
            $model = new GroupMembershipModel();
            $group = $model->findGroupByUserId($id);


            return $this->getResponse(
                [
                    'message' => 'group retrieved successfully',
                    'group' => $group
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find group'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function showGroupByGroupId($id)
    {
        try {
            $model = new GroupMembershipModel();
            $group = $model->findGroupByGroupId($id);


            return $this->getResponse(
                [
                    'message' => 'group retrieved successfully',
                    'group' => $group
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find group'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }
}
