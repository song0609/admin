<?php
if( ! function_exists('pagination')){
function pagination($uri,$per_page,$total){
        $ci =& get_instance();
        $ci->load->library('pagination');
        $config['base_url'] = $uri;
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        //$config['uri_segment'] = $uri_segment;
        $config['num_links'] = 4;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;

        $config['next_link'] = '>>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<<';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $ci->pagination->initialize($config);

        return $ci->pagination->create_links();
    }
}
?>
 
 