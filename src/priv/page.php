<?php
abstract class page {
    abstract protected function applyMain(Request $request, Config $config, Module $html): void;
    abstract public function main(Request $request, Config $config); // mixed: Module | array
    public function execute(Request $request, Config $config) {
        Module::setInputFolder('views/');

        $page = new Module('base/html');
        $page->head = new Module('base/head');
        $page->body = new Module('base/body');

        $this->applyMain($request, $config, $page);

        yield (string)$page;
    }
}
