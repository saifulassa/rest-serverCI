<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Mahasiswa extends REST_Controller 
{
    
    public function __construct()
    {
    parent::__construct();
    $this->load->model('Mahasiswa_model', 'mhs');
    }

    public function index_get()
    {

        $id = $this->get('id');
        if ($id === null) {
            $mahasiswa = $this->mhs->getMahasiswa();
        }else {
            $mahasiswa = $this->mhs->getMahasiswa($id);
        }
        

        if($mahasiswa){
            $this->response([
                'status' => true,
                'message' => $mahasiswa
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }


    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } else {
            if( $this->mhs->deleteMahasiswa($id) > 0 ) {
               //OKe
               $this->response([
                'status' => true,
                'id' => $id,
                'message' => 'id terhapus'
               ], REST_Controller::HTTP_NO_CONTENT);  
            } else {
              //ID Not Found
              $this->response([
                'status' => false,
                'message' => 'id not found!'
              ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } 
    }


    public function index_post()
        {
            $data = [
                'nrp' => $this->post('nrp'),
                'nama' => $this->post('nama'),
                'email' => $this->post('email'),
                'jurusan' => $this->post('jurusan')
            ];

            if( $this->mhs->createMahasiswa($data) > 0){
                $this->response([
                    'status' => true,
                    'message' => 'new mahasiswa has ben created'
                ], REST_Controller::HTTP_CREATED);    
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed create new data!'
                  ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
        
    public function index_put()
        {
            $id = $this->put('id');
            $data = [
                'nrp' => $this->put('nrp'),
                'nama' => $this->put('nama'),
                'email' => $this->put('email'),
                'jurusan' => $this->put('jurusan')
            ];

            if( $this->mhs->updateMahasiswa($data, $id) > 0){
                $this->response([
                    'status' => true,
                    'message' => 'data mahasiswa has ben updated'
                ], REST_Controller::HTTP_NO_CONTENT);    
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to update data!'
                  ], REST_Controller::HTTP_BAD_REQUEST);
            }       
        }      

}