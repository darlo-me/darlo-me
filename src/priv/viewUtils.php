<?php
function toLink(string $link, string $currentPage) {
    if(substr($link, 0, 1) === '/') {
        $count = substr_count($currentPage, '/', 1);
        return './' . join('/', array_fill(0, $count, '..')) . $link;
    }
    return $link;
}
