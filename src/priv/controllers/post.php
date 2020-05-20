<?php
require_once('libs/Request.php');
require_once('libs/Config.php');

require_once('libs/posts.php');
require_once('quickfixes.php');

require_once('Module.php');
require_once('page.php');

return new class() extends page {
    protected function applyMain(Request $request, Config $config, Module $html): void {
        $main = $this->main($request, $config);
        $html->head->title = $main['post']->title;
        $html->body->content = $main['module'];
    }
    public function main(Request $request, Config $config) {
        $post = postFix(new post(get_include_path() . "/views/posts/{$this->page}"));
        $main = new Module("posts/{$this->page}");
        return [
            'post' => $post,
            'module' => $main,
        ];
    }
};
