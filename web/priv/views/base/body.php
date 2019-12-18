<?php
$this->content->process();

if (isset($this->content->css))
    $this->css = $this->content->css;
if (isset($this->content->title))
    $this->title = $this->content->title;

foreach(($this->content->js ?? []) as $j) {
    printf("<script src='%s'></script>\n", htmlspecialchars($j));
}
?><header>
    <a href="/"><img src="/img/darlo.png" alt="darlo" /></a>
</header>
<nav>
    <a href="/blog.html">blog</a>
    <a href="/software.html">software</a>
    <a href="/about.html">about</a>
</nav>
<?php echo $this->content; ?>
<footer>
    &cp; <a href="mailto:daryl@darlo.me">Daryl Anthony Chouinard</a> (<a href='https://github.com/darlo'>github</a>) (2019-<?php echo date('y'); ?>)
</footer>
