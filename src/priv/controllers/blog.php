<?php
require_once('libs/csrf.php');
require_once('libs/external/php2static/php/Module.php');

return new class {
    public $page;
    public function execute($request, $config) {
        if(!$this->page || !preg_match('/^[a-zA-Z0-9\-_]+[a-zA-Z0-9\-_\.]*$/', $this->page)) {
            throw new HTTPException(400);
        }
        Module::setInputFolder('views/');

        $page = new Module('base/html');
        $page->head = new Module('base/head');
        $page->body = new Module('base/body');
        $page->body->content = new Module('blog-post');
        $page->body->content->content = new Module("blog-posts/{$this->page}");

        try {
            $page->process();
        } catch(Exception $e) {
            throw new HTTPException(404);
        }

        yield (string)$page;
    }
};
