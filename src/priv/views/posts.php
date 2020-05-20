<?php
require_once('viewUtils.php');
?>
<h1>Blog posts:</h1>
<?php
if($this->posts) {
    foreach($this->posts as $post) {
        ?>
        <a href='<?php echo htmlentities(toLink($post->url, $this->currentPage)); ?>'>
            <span class='date'>
                <?php echo htmlentities($post->created->format("Y-m-d")); ?>
            </span>
            <span class='title'>
                <?php echo htmlentities($post->title); ?>
            </span>
        </a>
        <?php
    }
} else {
    ?>
    <p class='empty'>There are no posts right now.</p>
    <?php
}
