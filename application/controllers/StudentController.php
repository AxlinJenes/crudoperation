<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Crud_model');

        if (!$this->session->userdata('user')) {
            redirect('auth?message=unauthorized');
            exit;
        }
    }

    public function index()
    {
        $data['action'] = $this->Crud_model->getAllStudents();
        $this->load->view('students_view', $data);
    }

    public function handleRequest()
    {
        $action = $this->input->post('action', TRUE);

        switch ($action) {
            case 'read': $this->read(); break;
            case 'create': $this->create(); break;
            case 'update': $this->update(); break;
            case 'delete': $this->delete(); break;
            default:
                $this->output->set_output(json_encode(['status' => 'error', 'message' => 'Invalid action']));
        }
    }

    private function read()
    {
        $data = $this->Crud_model->getAllStudents();
        $this->output->set_output(json_encode($data));
    }

    private function create()
    {
        $name  = $this->input->post('name', TRUE);
        $age   = $this->input->post('age', TRUE);
        $email = $this->input->post('email', TRUE);
        $password = password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);

        if (empty($name) || empty($email) || !is_numeric($age) || empty($password)) {
            echo "Invalid input";
            return;
        }

        if ($this->Crud_model->insert('students', ['Name' => $name, 'Age' => $age])) {
            $id = $this->db->insert_id();
            $this->Crud_model->insert('reference', ['StudentsID' => $id, 'Email' => $email, 'Password' => $password]);
            echo "success";
        } else {
            echo "error";
        }
    }

    private function update()
    {
        $id    = $this->input->post('id', TRUE);
        $name  = $this->input->post('name', TRUE);
        $age   = $this->input->post('age', TRUE);
        $email = $this->input->post('email', TRUE);

        $this->Crud_model->update('students', ['Name' => $name, 'Age' => $age], $id);
        $this->Crud_model->update('reference', ['Email' => $email], $id);

        echo "success";
    }

    private function delete()
    {
        $id = $this->input->post('id', TRUE);
        $this->Crud_model->delete('reference', $id);
        $this->Crud_model->delete('students', $id);
        echo "success";
    }
}
