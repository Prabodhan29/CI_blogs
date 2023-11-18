<?php
function resizeImage($source_path, $new_path, $width, $height) {
    $CI = &get_instance();

    $config['image_library'] = 'gd2';
    $config['source_image'] = $source_path;
    $config['new_image'] = $new_path;
    $config['create_thumb'] = TRUE;
    $config['maintain_ratio'] = TRUE;
    $config['width'] = $width;
    $config['height'] = $height;
    $config['thumb_marker'] = '';
    $CI->load->library('image_lib', $config);
    $CI->image_lib->initialize($config);
    $CI->image_lib->resize();
    $CI->image_lib->clear();
}

function addPagination($base_url, $total_rows, $perpage) {
    $CI = &get_instance();
    $CI->load->library('pagination');

    $config['base_url'] = $base_url;
    $config['total_rows'] = $total_rows;
    //$config['uri_segment'] = 4; codeigniter does this automatically
    $config['per_page'] = $perpage;
    $config['use_page_numbers'] = true;

    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Prev';
    $config['full_tag_open'] = "<ul class='pagination'>";
    $config['full_tag_close'] = "</ul>";
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = "<li class='disabled page-item'><li class='active page-item'><a href='#' class=\"page-link\">";
    $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
    $config['next_tag_open'] = "<li class=\"page-item\">";
    $config['next_tagl_close'] = "</li>";
    $config['prev_tag_open'] = "<li  class=\"page-item\">";
    $config['prev_tagl_close'] = "</li>";
    $config['first_tag_open'] = "<li  class=\"page-item\">";
    $config['first_tagl_close'] = "</li>";
    $config['last_tag_open'] = "<li  class=\"page-item\">";
    $config['last_tagl_close'] = "</li>";
    $config['attributes'] = array('class' => 'page-link');

    $CI->pagination->initialize($config);
    $pagination_links = $CI->pagination->create_links();
    return $pagination_links;
}

?>
