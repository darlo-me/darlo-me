<link rel="alternate" type="application/rss+xml" title="Subscribe by RSS" href="/rss.xml" />
<?php
foreach(($this->css ?? []) as $css) {
    printf("<link rel='stylesheet' href='%s' />\n", htmlspecialchars($css));
}
printf("<title>%s</title>\n", htmlspecialchars($this->title));
