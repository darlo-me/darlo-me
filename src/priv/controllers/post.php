<?php
require_once('libs/Request.php');
require_once('libs/Config.php');
require_once('libs/external/php2static/php/Module.php');

return new class {
    public $page;
    public function execute(Request $request, Config $config) {
        if(!$this->page || basename($this->page) != $this->page) {
            throw new HTTPException(400);
        }
        Module::setInputFolder('views/');

        $page = new Module('base/html');
        $page->head = new Module('base/head');
        $page->body = new Module('base/body');
        $page->body->content = new Module("posts/{$this->page}");

        try {
            $page->process();
        } catch(Exception $e) {
            throw new HTTPException(404, $e);
        }

        yield (string)$page;
    }
};
