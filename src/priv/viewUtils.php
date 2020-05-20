<?php
function toLink(string $link, string $currentPage) {
    if(substr($link, 0, 1) === '/') {
        $count = substr_count($currentPage, '/', 1);
        return '.' . str_repeat('/..', $count) . $link;
    }
    return $link;
}
