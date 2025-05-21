<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function getUserByName($name)
    {
        $this->db->select('students.*, reference.Email, reference.Password');
        $this->db->from('students');
        $this->db->join('reference', 'students.StudentsID = reference.StudentsID');
        $this->db->where('students.Name', $name);
        return $this->db->get()->row();
    }
}
