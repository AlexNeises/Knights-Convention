<?php
class News_model extends CI_Model
{
	private $id,
			$title,
			$slug,
			$blurb,
			$submitted_on,
			$text;

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
			$query = $this->db->get_where('news', array('id' => $this->get_id()));

			if ($query->num_rows == 1)
			{
				$data = $query->row();
			}
		}

		if ($data != null)
		{
			$this->set_title($data->title);
			$this->set_slug($data->slug);
			$this->set_blurb($data->blurb);
			$this->set_submitted_on($data->submitted_on);
			$this->set_text($data->text);

			return true;
		}

		return false;
	}

	public function save()
	{
		$data = array(
			'title'			=> $this->get_title(),
			'slug'			=> $this->get_slug(),
			'blurb'			=> $this->get_blurb(),
			'text'			=> $this->get_text()
		);

		if ($this->get_id() === 0)
		{
			if (!$this->db->insert('news', $data))
			{
				return false;
			}
			$this->_set_id($this->db->insert_id());
		}
		else
		{
			$this->db->where('id', $this->get_id());
			if (!$this->db->update('news', $data))
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
			$this->db->delete('news');
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

	public function get_title()
	{
		return $this->title;
	}

	public function set_title($title)
	{
		$this->title = $title;
	}

	public function get_slug()
	{
		return $this->slug;
	}

	public function set_slug($slug)
	{
		$this->slug = $slug;
	}

	public function get_blurb()
	{
		return $this->blurb;
	}

	public function set_blurb($blurb)
	{
		$this->blurb = $blurb;
	}

	public function get_submitted_on()
	{
		return $this->submitted_on;
	}

	public function set_submitted_on($submitted_on)
	{
		$this->submitted_on = $submitted_on;
	}

	public function get_text()
	{
		return $this->text;
	}

	public function set_text($text)
	{
		$this->text = $text;
	}

	static public function get_by_slug($slug)
	{
		$ci =& get_instance();

		$select = sprintf("SELECT * FROM `news` WHERE `slug` = '%s'", $slug);
		if (!$query = $ci->db->query($select))
		{
			log_message('debug', $ci->db->_error_message());
			return false;
		}

		if ($query->num_rows() == 1)
		{
			$row = $query->result()[0];
			return new News_Model($row->id, $row);
		}
		return false;
	}

	static public function get_all()
	{
		$ci =& get_instance();

		$select = sprintf("SELECT * FROM `news` WHERE 1 ORDER BY `submitted_on` DESC");
		if (!$query = $ci->db->query($select))
		{
			log_message('debug', $ci->db->_error_message());
			return false;
		}

		$results = [];

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$results[] = new News_Model($row->id, $row);
			}
		}

		return $results;
	}
}
?>