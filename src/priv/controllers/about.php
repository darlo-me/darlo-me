<?php
require_once('libs/csrf.php');
require_once('libs/external/php2static/php/Module.php');

return new class {
    public function execute($request, $config) {
        Module::setInputFolder('views/');

        $page = new Module('base/html');
        $page->head = new Module('base/head');
        $page->body = new Module('base/body');
        $page->body->content = new Module('pages/about');

        try {
            $page->process();
        } catch(Exception $e) {
            throw new HTTPException(404);
        }

        yield (string)$page;
    }
};
