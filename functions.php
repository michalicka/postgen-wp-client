<?php

function pgwc_download_file($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) return false;
    return $data;
}


function pgwc_has_same_image($post_id, $name)
{
    if (has_post_thumbnail($post_id)) {
        $thumb_id = get_post_thumbnail_id($post_id);
        $thumb_name = get_the_title($thumb_id);
        if ($thumb_name === $name) {
            return true;
        }
    }
    return false;    
}

function pgwc_insert_image($post_id, $image_url)
{
    $image_filename = basename($image_url);
    if (strpos($image_filename, '.') === false) $image_filename .= ".jpg";
    $content = pgwc_download_file($image_url);
    if ($content === false) return;

    $hash = sha1($content);
    $image_filename = $hash . '.' . pathinfo($image_filename, PATHINFO_EXTENSION);
    if (pgwc_has_same_image($post_id, $hash)) return;

    $wp_upload_dir = wp_upload_dir();
    $image_path = $wp_upload_dir['path'] . '/' . $image_filename;
    file_put_contents($image_path, $content);

    $wp_filetype = wp_check_filetype($image_filename);
    $attachment = array(
      'guid' => $image_url,
      'post_mime_type' => $wp_filetype['type'],
      'post_title'     => $hash,
      'post_content'   => '',
      'post_status'    => 'inherit'
    );

    $attachment_id = wp_insert_attachment( $attachment, $image_path, $post_id );

    set_post_thumbnail( $post_id, $attachment_id );    
}
