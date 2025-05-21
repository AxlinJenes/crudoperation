<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model
{
    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function update($table, $data, $id, $key = 'StudentsID')
    {
        return $this->db->where($key, $id)->update($table, $data);
    }

    public function delete($table, $id, $key = 'StudentsID')
    {
        return $this->db->where($key, $id)->delete($table);
    }

    public function getAllStudents()
    {
        $this->db->select('students.StudentsID, students.Name, students.Age, reference.Email');
        $this->db->from('students');
        $this->db->join('reference', 'students.StudentsID = reference.StudentsID');
        return $this->db->get()->result();
    }
}
