<?php
$this->content->process();

$this->css = $this->content->css ?? [];
$this->css[] = '/css/baselayout.css';

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
        --><a href="/posts.html">posts</a><!--
        --><a href="/software.html">software</a><!--
        --><a href="/readings.html">readings</a><!--
    --></nav>
</div>
<div id="content">
<?php echo $this->content; ?>
</div>
<footer>
    &copy;
    <?php printf('(2019%s)', date('Y') !== '2019' ? date('-Y') : ''); ?>
    Daryl Anthony Chouinard
    (<a href="mailto:daryl@darlo.me">email</a>)
    (<a href='https://github.com/darlo-me'>github</a>)
</footer>
