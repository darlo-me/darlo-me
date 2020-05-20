<?php
require_once('libs/Config.php');
require_once('libs/Request.php');
require_once('libs/external/dist/php2static/Module.php');

require_once('page.php');

require_once('libs/books.php');

return new class() extends page {
    protected function applyMain(Request $request, Config $config, Module $html): void {
        $html->head->title = 'readings';
        $html->body->content = $this->main($request, $config);
    }
    public function main(Request $request, Config $config) {
        $main = new Module('readings');

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
        $main->currentBooks = $books;
        $main->books = [];

        return $main;
    }
};
