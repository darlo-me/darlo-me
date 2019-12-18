<?php
foreach(($this->css ?? []) as $css) {
    printf("<link rel='stylesheet' href='%s' />\n", htmlspecialchars($css));
}
printf("<title>%s</title>\n", htmlspecialchars($this->title));
