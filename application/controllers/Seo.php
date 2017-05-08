<?php
class Seo extends CI_Controller
{
    function sitemap()
    {
        $data['data'] = [];
        array_push($data['data'], 'news');
        $all_news = News_Model::get_all();
        foreach($all_news as $news)
        {
            array_push($data['data'], $news->get_slug());
        }
        $this->load->view('seo/sitemap', $data);
    }
}
?>