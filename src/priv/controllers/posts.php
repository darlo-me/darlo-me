<?php
require_once('libs/Request.php');
require_once('libs/Config.php');

require_once('libs/posts.php');
require_once('quickfixes.php');

require_once('Module.php');
require_once('page.php');

return new class() extends page {
    protected function applyMain(Request $request, Config $config, Module $html): void {
        $html->head->title = 'Posts';
        $html->body->content = $this->main($request, $config);
    }
    public function main(Request $request, Config $config) {
        $last = $request->get['last'] ?? null;
        $posts = getPosts(get_include_path() . "/views/posts", PHP_INT_MAX, $last);
        if(count($posts) == PHP_INT_MAX) {
            throw new Exception("Too many posts");
        }
        
        $main = new Module("posts");
        $main->posts = array_map('postFix', $posts);

        return $main;
    }
};
