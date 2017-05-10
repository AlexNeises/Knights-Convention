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
        $this->first_name = $first_name;
    }

    public function get_last_name()
    {
        return $this->last_name;
    }

    public function set_last_name($last_name)
    {
        $this->last_name = $last_name;
    }

    public function get_username()
    {
        return $this->username;
    }

    public function set_username($username)
    {
        $this->username = $username;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function set_password($password, $encrypt = false)
    {
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
        $this->email_address = $email_address;
    }

    public function get_last_login()
    {
        return $this->last_login;
    }

    public function set_last_login($last_login)
    {
        $this->last_login = $last_login;
    }

    public function get_confirmed()
    {
        return $this->confirmed;
    }

    public function set_confirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }

    static public function unique_username($username)
    {
        $ci =& get_instance();

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

    static public function login($username, $password)
    {
        $ci =& get_instance();

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