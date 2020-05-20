<?php
require_once('viewUtils.php');

$this->content->process();

$this->css = $this->content->css ?? [];
$this->css[] = toLink('/css/baselayout.css', $this->currentPage);

if (isset($this->content->title))
    $this->title = $this->content->title;

foreach(($this->content->js ?? []) as $j) {
    printf("<script src='%s'></script>\n", htmlspecialchars(toLink($j, $this->currentPage)));
}
?><div id="header">
    <header><!--
        --><a href="<?php echo toLink('/', $this->currentPage); ?>">darlo</a><!--
    --></header><!--
    --><nav><!--
        --><a href="<?php echo toLink('/posts.html', $this->currentPage); ?>">posts</a><!--
        --><a href="<?php echo toLink('/software.html', $this->currentPage); ?>">software</a><!--
        --><a href="<?php echo toLink('/readings.html', $this->currentPage); ?>">readings</a><!--
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
