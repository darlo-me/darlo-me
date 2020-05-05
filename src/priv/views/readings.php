<?php
function outputBooks(array $books): void {
    foreach($books as $book) {
        printf('<li>%s</li>', htmlentities($book));
    }
}
$this->css = ['css/reading.css'];
if($this->currentBooks) {
    ?>
    <h1>Currently reading:</h1>
    <ul class='reading'>
        <?php outputBooks($this->currentBooks); ?>
    </ul>
    <?php
}
if($this->books) {
    ?>
    <h1>Past readings:</h1>
        <?php
        outputBooks($this->books);
}
