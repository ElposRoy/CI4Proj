<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Http\Response;
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

        // total number of records
        $totalRecords = $roleModel->countAll();

        // total number of records with filter
        $totalRecordswithFilter = $roleModel
            ->join("auth_groups_users", "users.id = auth_groups_users.user_id")
            ->like('users.username', $searchValue)
            ->orLike('users.active', $searchValue)
            ->orLike('auth_groups_users.group', $searchValue)
            ->countAllResults();

        // fetch records
        $records = $roleModel
            ->select('users.*, auth_groups_users.group AS user_role')
            ->join("auth_groups_users", "users.id = auth_groups_users.user_id")
            ->like('users.username', $searchValue)
            ->orLike('users.active', $searchValue)
            ->orLike('auth_groups_users.group', $searchValue)
            ->orderBy($sortcolumn, $sortdir)
            ->findAll($rowperpage, $start);

        $data = [];

        foreach ($records as $record) {
            $data[] = [
                "id" => $record['id'],
                "username" => $record['username'], // Assuming 'username' is a field in the 'users' table
                "active" => $record['active'],
                "role" => $record['user_role'],
                "created_at" => $record['created_at'],
            ];
        }

        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data
        ];

        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);
    }




    public function updateRole($userId, $newRole)
    {
       

      
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $roleModel = new \App\Models\Role();
        
        // Fetch user data with associated role from auth_groups_users
        $data = $roleModel
            ->select('users.*, auth_groups_users.group AS role')
            ->join("auth_groups_users", "users.id = auth_groups_users.user_id")
            ->find($id);
    
        if (!$data) {
            $response = [
                'status' => 'error',
                'message' => 'Data cannot be found'
            ];
    
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)->setJSON($response);
        }
    
        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($data);
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
       
        $authGroupUserModel = new \App\Models\AuthGroupUserModel();

        $data = $this->request->getJSON();
  
        if(!$authGroupUserModel -> validate($data)){
          $response = array(
              'status' => 'error',
              'message' => $authGroupUserModel->errors()
          );
  
        //   return $this->response->setStatusCode(Response::HTTP_NOT_MODIFIED)->setJSON($response);
        return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)->setJSON($response);
  
        }
  
        $authGroupUserModel->update($id, $data);
        $response = array(
          'status' => 'sucess',
          'message' => 'Role updated successfully'
      );
  
        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($response);

        
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
