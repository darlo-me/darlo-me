<?php
require_once('libs/Request.php');
require_once('libs/Config.php');

require_once('libs/posts.php');

require_once('quickfixes.php');

require_once('Module.php');
require_once('page.php');

return new class() extends page {
    protected function applyMain(Request $request, Config $config, Module $html): void {
        $html->head->title = 'index';
        $html->body->content = $this->main($request, $config);
    }
    public function main(Request $request, Config $config) {
        $main = new Module('index');
        $about = include('controllers/about.php');
        $main->about = $about->main($request, $config);
        $posts = include('controllers/posts.php');
        $main->posts = $posts->main($request, $config);
        return $main;
    }
};
