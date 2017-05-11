<?php
class Users_model extends CI_Model
{
    private $id,
            $first_name,
            $last_name,
            $username,
            $password,
            $email_address,
            $last_login,
            $confirmation,
            $confirmed;

    protected $ci;

    public function __construct($id = 0, $data = null)
    {
        $this->_set_id($id);
        $this->_get($data);
    }

    protected function _get($data = null)
    {
        if ($this->get_id() != 0 && $data == null)
        {
            $query = $this->db->get_where('users', array('id' => $this->get_id()));

            if ($query->num_rows() == 1)
            {
                $data = $query->result()[0];
            }
        }

        if ($data != null)
        {
            $this->set_first_name($data->first_name);
            $this->set_last_name($data->last_name);
            $this->set_username($data->username);
            $this->set_password($data->password);
            $this->set_email_address($data->email_address);
            $this->set_last_login($data->last_login);
            $this->set_confirmation($data->confirmation);
            $this->set_confirmed($data->confirmed);

            return true;
        }

        return false;
    }

    private function encrypt($password)
    {
        return crypt($password, '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22));
    }

    public function save()
    {
        $data = array(
            'first_name'    => $this->get_first_name(),
            'last_name'     => $this->get_last_name(),
            'username'      => $this->get_username(),
            'password'      => $this->get_password(),
            'last_login'    => date('Y-m-d H:i:s'),
            'email_address' => $this->get_email_address(),
            'confirmation'  => $this->get_confirmation(),
            'confirmed'     => $this->get_confirmed()
        );

        if ($this->get_id() === 0)
        {
            if (!$this->db->insert('users', $data))
            {
                return false;
            }
            $this->_set_id($this->db->insert_id());
        }
        else
        {
            $this->db->where('id', $this->get_id());
            if (!$this->db->update('users', $data))
            {
                return false;
            }
        }
    }

    public function delete()
    {
        if ($this->get_id() != 0)
        {
            $this->db->where('id', $this->get_id());
            $this->db->delete('users');
        }
    }

    public function get_id()
    {
        return intval($this->id);
    }

    protected function _set_id($id)
    {
        $this->id = intval($id);
    }

    public function get_first_name()
    {
        return $this->first_name;
    }

    public function set_first_name($first_name)
    {
        $first_name = $this->db->escape_str($first_name);
        $this->first_name = $first_name;
    }

    public function get_last_name()
    {
        return $this->last_name;
    }

    public function set_last_name($last_name)
    {
        $last_name = $this->db->escape_str($last_name);
        $this->last_name = $last_name;
    }

    public function get_username()
    {
        return $this->username;
    }

    public function set_username($username)
    {
        $username = $this->db->escape_str($username);
        $this->username = $username;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function set_password($password, $encrypt = false)
    {
        $password = $this->db->escape_str($password);
        if ($encrypt)
        {
            $this->password = $this->encrypt($password);
        }
        else
        {
            $this->password = $password;
        }
    }

    public function get_email_address()
    {
        return $this->email_address;
    }

    public function set_email_address($email_address)
    {
        $email_address = $this->db->escape_str($email_address);
        $this->email_address = $email_address;
    }

    public function get_last_login()
    {
        return $this->last_login;
    }

    public function set_last_login($last_login)
    {
        $last_login = $this->db->escape_str($last_login);
        $this->last_login = $last_login;
    }

    public function get_confirmation()
    {
        return $this->confirmation;
    }

    public function set_confirmation($confirmation)
    {
        $confirmation = $this->db->escape_str($confirmation);
        $this->confirmation = $confirmation;
    }

    public function get_confirmed()
    {
        return $this->confirmed;
    }

    public function set_confirmed($confirmed)
    {
        $confirmed = $this->db->escape_str($confirmed);
        $this->confirmed = $confirmed;
    }

    static public function unique_username($username)
    {
        $ci =& get_instance();
        $username = $ci->db->escape_str($username);

        $select = sprintf("SELECT * FROM `users` WHERE LOWER(`username`) = '%s'", strtolower($username));
        if (!$query = $ci->db->query($select))
        {
            log_message('debug', $ci->db->_error_message());
            return false;
        }

        if ($query->num_rows() == 0)
        {
            return true;
        }
        return false;
    }

    static public function confirmed($username)
    {
        $ci =& get_instance();
        $username = $ci->db->escape_str($username);

        $select = sprintf("SELECT * FROM `users` WHERE `username` = '%s'", $username);
        if (!$query = $ci->db->query($select))
        {
            log_message('debug', $ci->db->_error_message());
            return false;
        }

        if ($query->num_rows() == 1)
        {
            $row = $query->result()[0];
            $account = new Users_Model($row->id, $row);

            if ($account->get_confirmed() == 1)
            {
                return true;
            }
            return false;
        }
        return false;
    }

    static public function can_resend($username, $email_address)
    {
        $ci =& get_instance();
        $username = $ci->db->escape_str($username);
        $email_address = $ci->db->escape_str($email_address);

        $select = sprintf("SELECT * FROM `users` WHERE `username` = '%s' AND `email_address` = '%s'", $username, $email_address);
        if (!$query = $ci->db->query($select))
        {
            log_message('debug', $ci->db->_error_message());
            return false;
        }

        if ($query->num_rows() == 1)
        {
            $row = $query->result()[0];
            return new Users_Model($row->id, $row);
        }
        return false;
    }

    static public function already_confirmed($hash)
    {
        $ci =& get_instance();
        $hash = $ci->db->escape_str($hash);

        $select = sprintf("SELECT * FROM `users` WHERE `confirmation` = '%s'", $hash);
        if (!$query = $ci->db->query($select))
        {
            log_message('debug', $ci->db->_error_message());
            return false;
        }

        if ($query->num_rows() == 1)
        {
            $row = $query->result()[0];
            $account = new Users_Model($row->id, $row);

            if ($account->get_confirmed() == 1)
            {
                return true;
            }
            return false;
        }
        return false;
    }

    static public function confirm_user($hash)
    {
        $ci =& get_instance();
        $hash = $ci->db->escape_str($hash);

        $select = sprintf("SELECT * FROM `users` WHERE `confirmation` = '%s'", $hash);
        if (!$query = $ci->db->query($select))
        {
            log_message('debug', $ci->db->_error_message());
            return false;
        }

        if ($query->num_rows() == 1)
        {
            $row = $query->result()[0];
            $account = new Users_Model($row->id, $row);

            if ($account->get_confirmed() == 0)
            {
                if ($account->get_confirmation() == $hash)
                {
                    $account->set_confirmed(1);
                    $account->save();
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    static public function login($username, $password)
    {
        $ci =& get_instance();
        $username = $ci->db->escape_str($username);
        $password = $ci->db->escape_str($password);

        $select = sprintf("SELECT * FROM `users` WHERE `username` = '%s'", $username);
        if (!$query = $ci->db->query($select))
        {
            log_message('debug', $ci->db->_error_message());
            return false;
        }

        if ($query->num_rows() == 1)
        {
            $row = $query->result()[0];
            $account = new Users_Model($row->id, $row);

            if ($account->get_confirmed() != 1)
            {
                return false;
            }

            if (crypt($password, $account->get_password()) == $account->get_password())
            {
                $account->save();
                $newdata = array(
                    'username'      => $account->get_username(),
                    'first_name'    => $account->get_first_name(),
                    'last_name'     => $account->get_last_name(),
                    'email_address' => $account->get_email_address(),
                    'logged_in'     => true,
                    'confirmed'     => $account->get_confirmed()
                );
                $ci->session->set_userdata($newdata);
                return true;
            }
            return false;
        }
        return false;
    }

    static public function logout()
    {
        $ci =& get_instance();
        $ci->session->sess_destroy();
        return true;
    }
}
?>