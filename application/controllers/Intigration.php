<?php

defined("BASEPATH") or ("No Direct Script Access Allowed");
class Intigration extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data['users'] = $this->GetUsers();  //Get data From Database and create Kay Users
        $this->load->view('ViewData', $data); //Load ViewData View file first (Table format data) and pass $data
    }


    public function AddData()
    {
        $this->load->view("AddData");
    }



    public function AddUser()
    {

        $api_url = 'http://localhost/ApiCreation/Creation/AddUser';
        $postData = $this->input->post();


        // $file = $_FILES['profilepic'];

        // if($file['name'] == ""){
        //     $postData['profilepic'] = $postData['old_profile'];
        // } else {
        //     $postData = array_merge($postData, array('profilepic' => new CURLFile($file['tmp_name'], $file['type'], $file['name'])));
        // }


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
}
?>