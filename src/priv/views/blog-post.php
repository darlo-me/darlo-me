<?php
$this->css = ['css/blog-post.css'];
?><div class='blog post'>
<?php echo pretty_print($this->content->process()); ?>
</div>
