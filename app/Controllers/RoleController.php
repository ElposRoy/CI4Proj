<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class RoleController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        // Load the User and AuthGroupUser models
        $userModel = new \App\Models\Role();
        $authGroupUserModel = new \App\Models\AuthGroupUserModel();

        // Fetch all users and related data from the database
        $data['users'] = $userModel->findAll();
        $data['authGroupUser'] = $authGroupUserModel->findAll();

        // Load the view with the user and auth-group-user data
        return view('pages/roles.php', $data);
    }

    public function list()
    {
        $roleModel = new \App\Models\Role();
        $postData = $this->request->getPost();

        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $searchValue = $postData['search']['value'];
        $sortby = $postData['order'][0]['column']; // Column index
        $sortdir = $postData['order'][0]['dir']; // asc or desc
        $sortcolumn = $postData['columns'][$sortby]['data']; // Column name

        //total number of records
        $totalRecords = $roleModel->select('id')->countAllResults();

        //total number of records with filter
        $totalRecordswithFilter = $roleModel->select('id')
            ->join("users", "users.id = auth_groups_users.user_id")
            ->like('users.username', $searchValue)
            ->orLike('users.active', $searchValue)
            ->orLike('auth_groups_users.group', $searchValue)
            ->orderBy($sortcolumn, $sortdir)
            ->countAllResults();

        //fetch records
        $records = $roleModel->select('users.*, CONCAT( users.username AS user_name) 
        AS full_name, auth_groups_users.group AS user_role')
        ->join("users", "users.id = auth_groups_users.user_id")
        ->like('users.username', $searchValue)
        ->orLike('users.active', $searchValue)
        ->orLike('auth_groups_users.group', $searchValue)
            ->orderBy($sortcolumn, $sortdir)
            ->findAll($rowperpage, $start);

        $data = array();

        foreach ($records as $record) {
            $data[] = array(
                "id" => $record['id'],
                "username" => $record['user_name'],
                "active" => $record['active'],
                "last_active" => $record['last_active'],
                "Role" => $record['user_role'],
                "created_at" => $record['created_at'],
            );
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data
        );

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
    }



    // public function updateRole($userId, $newRole)
    // {
    //     // Get the Auth service
    //     $auth = Services::auth();

    //     // Find the user by ID
    //     $user = $auth->getUser($userId);

    //     if (!$user) {
    //         $response = [
    //             'status'  => 'error',
    //             'message' => 'User not found',
    //         ];

    //         return $this->response->setStatusCode(Response::HTTP_NOT_FOUND)->setJSON($response);
    //     }

    //     // Update the user's role
    //     $auth->addUserToGroup($user->id, $newRole);

    //     $response = [
    //         'status'  => 'success',
    //         'message' => 'User role updated successfully',
    //     ];

    //     return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
    // }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
