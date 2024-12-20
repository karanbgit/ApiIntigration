<?php

defined("BASEPATH") or ("No Direct Script Access Allowed");
class Intigration extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // load 1st function
    public function index()
    {
        $data['users'] = $this->GetUsers();  //Get data From Database and create Kay Users
        $this->load->view('ViewData', $data); //Load ViewData View file first (Table format data) and pass $data
    }


    //Load Data View  in api integration
    public function AddData()
    {
        $this->load->view("AddData");
    }


    // Get Data from API integration
    public function GetUsers()
    {

        $api_url = 'http://localhost/ApiCreation/Creation/GetUserData';

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute cURL request
        $response = curl_exec($ch);
        $response_data = json_decode($response, true);

        // print_r($response_data);die;

        if ($response_data['status'] == 'success') {
            $data = $response_data['data'];
        } else {
            $data = null;
        }
        curl_close($ch);

        return $data;

    }




    // Add Data to API integration from API
    public function AddUser()
    {

        $api_url = 'http://localhost/ApiCreation/Creation/AddUser';
        $postData = $this->input->post();


        $file = $_FILES['image'];


        $postData = array_merge($postData, array('image' => new CURLFile($file['tmp_name'], $file['type'], $file['name'])));



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response_data = json_decode($response, true);

        curl_close($ch);

        if (isset($response_data['status']) && $response_data['status'] == 'success') {

            redirect("Intigration/index");
        }
    }


    // Delete Data from API integration
    public function DeleteUser($id)
    {

        $api_url = 'http://localhost/ApiCreation/Creation/DeleteUserData/' . $id;

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute cURL request
        $response = curl_exec($ch);
        $response_data = json_decode($response, true);

        // print_r($response_data);die;

        if ($response_data['status'] == 'success') {
            $this->session->set_flashdata('success', 'User deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'User deleted failed');
        }

        curl_close($ch);

        redirect("Intigration/index");

    }


    // Update Data From API Integration


    public function EditUser($id)
    {
        $data['user'] = $this->GetUserById($id);
        $this->load->view('EditForm', $data);
    }

    public function GetUserById($id)
    {

        $api_url = 'http://localhost/ApiCreation/Creation/GetUserById/' . $id;

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute cURL request
        $response = curl_exec($ch);
        $response_data = json_decode($response, true);

        // print_r($response_data);die;

        if ($response_data['status'] == 'success') {
            $data = $response_data['data'];
        } else {
            $data = null;
        }
        curl_close($ch);

        return $data;
    }





    // Update User Function 
    public function UpdateUser()
    {
        $id = $this->input->post('id');
        $api_url = 'http://localhost/ApiCreation/Creation/UpdateUser/' . $id;
        $postData = $this->input->post();


        $file = $_FILES['image'];

        if ($file['name'] == "") {
            $postData['image'] = $postData['old_image'];
        } else {
            $postData = array_merge($postData, array('image' => new CURLFile($file['tmp_name'], $file['type'], $file['name'])));
        }


        unset($postData['id'], $postData['old_image']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response_data = json_decode($response, true);


        curl_close($ch);

        if (isset($response_data['status']) && $response_data['status'] == 'success') {

            redirect("Intigration/index");
        }
    }



}
?>