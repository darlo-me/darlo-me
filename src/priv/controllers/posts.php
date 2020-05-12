<?php
require_once('libs/Request.php');
require_once('libs/Config.php');

require_once('libs/external/php2static/php/Module.php');
require_once('libs/posts.php');

return new class {
    public $page;
    public function execute(Request $request, Config $config) {
        Module::setInputFolder('views/');

        $page = new Module('base/html');
        $page->head = new Module('base/head');
        $page->body = new Module('base/body');
        $page->body->content = new Module("posts");

        $last = $request->get['last'] ?? null;
        $posts = getPosts(get_include_path() . "/views/posts", PHP_INT_MAX, $last);
        if(count($posts) == PHP_INT_MAX) {
            throw new Exception("Too many posts");
        }
        
        $page->body->content->posts = array_map(function($post) {
            if(substr($post->filename, -4) == '.php') {
                $post->filename = substr($post->filename, 0, -4);
            }
            if(substr($post->title, -5) == '.html') {
                $post->title = substr($post->title, 0, -5);
            }
            $post->url = "/posts/" . rawurlencode($post->filename);
            return $post;
        }, $posts);

        try {
            $page->process();
        } catch(Exception $e) {
            throw new HTTPException(404, $e);
        }

        yield (string)$page;
    }
};
