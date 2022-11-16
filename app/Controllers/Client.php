<?php

namespace App\Controllers;

use App\Models\ClientModel;
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
    public function index()
    {
        $model = new ClientModel();
        return $this->getResponse(
            [
                'message' => 'Clients retrieved',
                'clients' => $model->findAll()
            ]
        );
    }

    /**
     * Create a new Client
     */
    public function store()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[client.email]',
            'retainer_fee' => 'required|max_length[255]'
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $clientEmail = $input['email'];
        $model = new ClientModel();
        $model->save($input);
        $client = $model->where('email', $clientEmail)->first();

        return $this->getResponse(
            [
                'message' => 'Client added successfully',
                'client' => $client
            ]
        );
    }

    /**
     * Get a single client by ID
     */
    public function show($id)
    {
        try {
            $model = new ClientModel();
            $client = $model->findClientById($id);

            return $this->getResponse(
                [
                    'message' => 'Client retrieved successfully',
                    'client' => $client
                ]
            );
        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find client for specified ID'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Update an existing Client
     */
    public function update($id)
    {
        try {
            $model = new ClientModel();
            $model->findClientById($id);

            $input = $this->getRequestInput($this->request);

            $model->update($id, $input);
            $client = $model->findClientById($id);

            return $this->getResponse(
                [
                    'message' => 'Client updated successfully',
                    'client' => $client
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

    /**
     * Delete an existing Client
     */
    public function destroy($id)
    {
        try {
            $model = new ClientModel();
            $client = $model->findClientById($id);
            $model->delete($client);

            return $this->getResponse(
                    [
                        'message' => 'Client deleted successfully',
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
            'group_id',
            'user_id' => 'required',
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

    public function updateReminder($id)
    {
        try {
            $model = new ReminderModel();
            $model->findClientById($id);

            $input = $this->getRequestInput($this->request);

            $model->update($id, $input);
            $reminder = $model->findClientById($id);

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

    public function createGroup() {
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
    public function joinGroup() {
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
    public function showGroup()
    {
        try {
            $model = new GroupModel();
            $group = $model->findAll();
            

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