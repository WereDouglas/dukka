<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('helper');
    }

    public function index() {
        $data['users'] = array();
        $query = $this->Md->show('user');
        //  var_dump($query);
        if ($query)
            $data['users'] = $query;

        $this->load->view('user', $data);
    }

    public function save() {

        $this->load->helper(array('form', 'url'));
        $username = $this->input->post('username');
        $name = $this->input->post('name');
        $contact = $this->input->post('contact');
        $file_element_name = 'userfile';



        $config['upload_path'] = 'uploads/';

        $config['allowed_types'] = '*';
        $config['encrypt_name'] = FALSE;

        $this->load->library('upload', $config);
        $this->load->library('image_lib', $config);



        if (!$this->upload->do_upload($file_element_name)) {
            $status = 'error';
            echo $msg = $this->upload->display_errors('', '');
        } else {
            //Image Resizing
        }

        $data = $this->upload->data();
        $file = $data['file_name'];
        /**/
        $config['image_library'] = 'gd2';
        $config['source_image'] = $this->upload->upload_path . $file;
        $config['new_image'] = $upload_data["file_path"] . $file;
        $config['maintain_ratio'] = FALSE;
        $config['overwrite'] = TRUE;
        $config['width'] = 25;
        $config['height'] = 23;
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            $this->session->set_flashdata('message', $this->image_lib->display_errors('', ''));
        }

        /*         * */


        $get_result = $this->Md->check($name, 'name', 'user');
        if (!$get_result) {
            $this->session->set_flashdata('msg', 'this name is already in use');
            redirect('/User', 'refresh');
        }
        $get_result = $this->Md->check($username, 'username', 'user');
        if (!$get_result) {
            $this->session->set_flashdata('msg', 'this name is already in use');
            redirect('/user', 'refresh');
        }
        if ($username != "") {
            $user = array('image' => $file, 'username' => $username, 'name' => $name, 'contact' => $contact, 'created' => date('Y-m-d'));
            $this->Md->save($user, 'user');

            redirect('/user', 'refresh');
        } else {
            $this->session->set_flashdata('msg', 'Please input username  ');
            redirect('/user', 'refresh');
        }
    }
    
    
    public function register() {

        $this->load->helper(array('form', 'url'));
       
        $username = $this->input->post('username');
        $password = $this->input->post('password');      


        $get_result = $this->Md->check($username, 'username', 'user');
        if (!$get_result) {
           
              $b["info"] = "username in use";
                $b["status"] = "false";
                echo json_encode($b);
                return;          
        }     
       
        if ($username != "") {           
       
        $key =$username;

        $password = $this->encrypt->encode($password, $key);
            
            $user = array( 'username' => $username, 'password' => $password, 'created' => date('Y-m-d'));
            $this->Md->save($user, 'user');           
              $b["info"] = "registered";
                $b["status"] = "true";
                echo json_encode($b);
                return;
                
        } else {
                $b["info"] = "you are missing a user name";
                $b["status"] = "false";
                echo json_encode($b);
                return;
        }
    }

    public function update() {

        $this->load->helper(array('form', 'url'));
        $id = $this->input->post('userID');
        $username = $this->input->post('username');
        $name = $this->input->post('name');
        $contact = $this->input->post('contact');

        $user = array('username' => $username, 'name' => $name, 'contact' => $contact, 'created' => date('Y-m-d'));
        $this->Md->update($id, $user, 'user');

        $this->session->set_flashdata('msg', 'The ' . $name . ' has been updated');
    }

    public function delete() {

        $id = $this->uri->segment(3);

        $query = $this->Md->delete($id, 'user');


        if ($this->db->affected_rows() > 0) {
            $msg = '<span style="color:red">Information Deleted Fields</span>';
            $this->session->set_flashdata('msg', $msg);
            redirect('/user', 'refresh');
        } else {
            $msg = '<span style="color:red">action failed</span>';
            $this->session->set_flashdata('msg', $msg);
            redirect('/user', 'refresh');
        }
    }

    public function location() {

        $data['locations'] = array();

        $username = $this->uri->segment(3);

        $data['username'] = $username;
        $all = $this->Md->query("select * from (select * from location where username = '" . $username . "'  order by id desc limit 500) location order by id desc");
        $data['locations'] = $all;
        //select session, SUM(distance) as total  from location WHERE session in (Select DISTINCT(session) FROM location) GROUP BY session
        $sessions = $this->Md->query("select DISTINCT session,SUM(distance) as total,MIN(created)as starttime, MAX(created) as endtime  from location  where username='".$username."' AND session in (Select DISTINCT(session) FROM location) GROUP BY session");
         $data['sessions'] = $sessions;
        //var_dump($sessions);
     
        $this->load->view('view-user', $data);
    }
    
     public function session() {

        $data['locations'] = array();
        $session = $this->uri->segment(3);
          $username = $this->uri->segment(4);
        $data['username'] = $username;
         $data['session'] = $session;
        $all = $this->Md->query("select * from (select * from location where username = '" . $username . "' and session= '".$session."' order by id desc limit 500) location order by id desc");
        $data['locations'] = $all;        
     
        $this->load->view('view-session', $data);
    }
     public function session_movement() {
        
         $data['movements'] = "";
         $username = $this->input->post('username');
         $session = $this->input->post('session');
         $movement = array();
         $movement = $this->Md->query("select * from (select * from location where username = '" . $username . "' and session= '".$session."'  order by id desc limit 500) location order by id desc");

         echo json_encode($movement);
    }
    public function movement() {
        
        $data['movements'] = "";
        $username = $this->input->post('username');
       $username = 'Douglas';
        // $movement = $this->Md->query("select * from location where username = '".$username."' LIMIT 20");

         $movement = array();
         $movement = $this->Md->query("select * from location where session=(select DISTINCT session from location  where username='".$username."' order by id desc limit 1) order by id desc");

        echo json_encode($movement);
    }

    public function check() {

        $username = $this->input->post('username');

        //  $username = "douglas";  
        //check($value,$field,$table)
        $get_result = $this->Md->check($username, 'username', 'user');


        $a = array();
        $b = array();
        if ($username != "") {
            if (!$get_result) {

                $b["status"] = "valid user ";
                $b["username"] = $username;
                $b["login"] = "true";

                array_push($a, $b);
                echo json_encode($b);
            } else {
                $b["status"] = "invalid user";
                $b["username"] = $username;
                $b["login"] = "false";

                array_push($a, $b);
                echo json_encode($b);
            }
        } else {
            $b["status"] = "no user specified";
            $b["username"] = $username;
            $b["login"] = "false";

            array_push($a, $b);
            echo json_encode($b);
        }
    }

    public function checks() {
        $this->load->helper(array('form', 'url'));

        $username = $this->input->post('username');
        if ($username == "") {
            echo '<span style="color:#f00"> empty username fields. </span>';
        } else {
            //check($value,$field,$table)
            $get_result = $this->Md->check($username, 'username', 'user');
            if (!$get_result)
                echo '<span style="color:#f00"> username already in use. </span>';
            else
                echo '<span style="color:#0c0"> username not in use</span>';
        }
    }

}
