<?php
$this->content->process();

$this->css = $this->content->css ?? [];
$this->css[] = 'css/baselayout.css';

if (isset($this->content->title))
    $this->title = $this->content->title;

foreach(($this->content->js ?? []) as $j) {
    printf("<script src='%s'></script>\n", htmlspecialchars($j));
}
?><div id="header">
    <header><!--
        --><a href="/">darlo</a><!--
    --></header><!--
    --><nav><!--
        --><a href="/blog.html">blog</a><!--
        --><a href="/software.html">software</a><!--
        --><a href="/about.html">about</a><!--
    --></nav>
</div>
<div id="content">
<?php echo pretty_print($this->content); ?>
</div>
<footer>
    &copy;
    <?php printf('(2019%s)', date('Y') !== '2019' ? date('-Y') : ''); ?>
    Daryl Anthony Chouinard
    (<a href="mailto:daryl@darlo.me">email</a>)
    (<a href='https://github.com/darlo'>github</a>)
</footer>
