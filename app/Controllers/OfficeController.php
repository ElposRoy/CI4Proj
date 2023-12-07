<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Http\Response;
class OfficeController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $officeModel = new \App\Models\Office();
        $data = $officeModel->find($id);
        if (!$data){
            return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $this->response->setStatusCode(Response::HTTP_OK)->setJSON($data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
      $officeModel = new \App\Models\Office();
      $data = $this->request->getPost();

      if(!$officeModel -> validate($data)){
        $response = array(
            'status' => 'error',
            'message' => $officeModel->errors()
        );

        return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST)->setJSON($response);

      }

      $officeModel->insert($data);
      $response = array(
        'status' => 'sucess',
        'message' => 'Office created successfully'
    );

      return $this->response->setStatusCode(Response::HTTP_CREATED)->setJSON($response);


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
        $officeModel = new \App\Models\Office();
        $data = $this->request->getJSON();
  
        if(!$officeModel -> validate($data)){
          $response = array(
              'status' => 'error',
              'message' => $officeModel->errors()
          );
  
          return $this->response->setStatusCode(Response::HTTP_NOT_MODIFIED)->setJSON($response);
  
        }
  
        $officeModel->update($id, $data);
        $response = array(
          'status' => 'sucess',
          'message' => 'Office updated successfully'
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
