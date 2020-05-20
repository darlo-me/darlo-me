<?php
require_once('libs/posts.php');

function postFix(post $post) {
	if(substr($post->filename, -4) == '.php') {
			$post->filename = substr($post->filename, 0, -4);
	}
	if(substr($post->title, -5) == '.html') {
			$post->title = substr($post->title, 0, -5);
	}
    $post->title = str_replace('-', ' ', $post->title); // This is needed because make does not support files with spaces
	$post->url = "/posts/" . rawurlencode($post->filename);
	return $post;
}
