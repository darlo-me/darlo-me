<?php
require_once('libs/Config.php');
require_once('libs/Request.php');

require_once('Module.php');
require_once('page.php');

return new class() extends page {
    protected function applyMain(Request $request, Config $config, Module $html): void {
        $html->head->title = 'software';
        $html->body->content = $this->main($request, $config);
    }
    public function main(Request $request, Config $config) {
        $main = new Module('software');
        return $main;
    }
};
