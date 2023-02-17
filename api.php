<?php

include_once('../../../wp-load.php');
include_once('./functions.php');

header('Content-Type: application/json');

if (!get_option('pgwc_enabled')) {
    http_response_code(401);
    echo json_encode(['error' => 'Disabled']);
    exit();
}

if (!isset($_SERVER['HTTP_AUTHORIZATION']) 
    || empty($_SERVER['HTTP_AUTHORIZATION']) 
    || $_SERVER['HTTP_AUTHORIZATION'] !== 'Bearer '.get_option('pgwc_api_key')
) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$post = $data->post;

$wpPost = [
    'post_title' => $post->title ?? '',
    'post_content' => $post->content ?? '',
    'post_excerpt' => $post->excerpt ?? '',
    'post_date' => $post->date ?? '',
    'post_status' => ($post->date ?? '') && strtotime($post->date) > time() ? 'future' : get_option('pgwc_status', 'publish'),
    'post_author' => get_option('pgwc_author_id'),
    'post_category' => [ get_cat_ID($post->category ?? '') ?: get_option('pgwc_category_id') ],
    'tags_input' => $post->tags ?? [],
];

if ($data->action === 'create') {
    $postId = wp_insert_post($wpPost);
    if ($image = ($post->image ?? '')) pgwc_insert_image($postId, $image);
    
    echo json_encode([
        'success' => true,
        'post' => [
            'id' => $postId,
            'link' => get_permalink($postId),
        ]
    ]);
} else if ($data->action === 'update') {
    $wpPost['ID'] = $post->id ?? null;

    $postId = wp_update_post($wpPost);
    if ($image = ($post->image ?? '')) pgwc_insert_image($postId, $image);

    echo json_encode([
        'success' => true,
        'post' => [
            'id' => $postId,
            'link' => get_permalink($postId),
        ]
    ]);
} else if ($data->action === 'delete') {
    $postId = wp_update_post([
        'ID' => $post->id ?? null,
        'post_status' => 'trash'
    ]);

    echo json_encode([
        'success' => true,
    ]);
}
