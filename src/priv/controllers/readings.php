<?php
require_once('libs/Config.php');
require_once('libs/Request.php');
require_once('libs/books.php');
require_once('libs/external/php2static/php/Module.php');

return new class {
    public $page;
    public function execute(Request $request, Config $config) {
        Module::setInputFolder('views/');

        $page = new Module('base/html');
        $page->head = new Module('base/head');
        $page->body = new Module('base/body');
        $page->body->content = new Module('readings');

        $books = array();
        foreach([ // ISBN-10
            '0872205819', // The Inner Chapters (translator A.C. Graham) - Mandala Books - real ISBN: 0 04 299013 0
            '0521592712', // E. T. Jaynes, Probability Theory - Logic of Science
        ] as $isbn) {
            $books[$isbn] = Book::fromGoogleBookAPIv1ByISBN($isbn, $config->secrets->googleBooksAPIKey);
        }
        // Google book doesnt return translator
        if(!array_filter($books['0872205819']->authors, function($author) { return (bool)preg_match('/graham/i', $author); })) {
            $books['0872205819']->authors[] = "Angus C. Graham";
        }
        $page->body->content->currentBooks = $books;
        $page->body->content->books = [];

        try {
            $page->process();
        } catch(Exception $e) {
            throw new HTTPException(404);
        }

        yield (string)$page;
    }
};
