<?php
class User_model extends CI_Model{
    public function validate_login()
    {
        $email = $this->input->post('email');
        $password = sha1($this->input->post('password'));

        $query = $this->db->get_where('users', array('email' => $email, 'password' => $password));
        if ($query->num_rows() == 1) 
        {
            return TRUE;
        }
        return FALSE;
    }
}