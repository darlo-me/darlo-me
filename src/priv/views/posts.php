<?php
$this->css = ['css/blog-post.css'];
if($this->posts) {
    ?>
    <h1>Blog posts:</h1>
    <?php
    foreach($this->posts as $post) {
        ?>
        <a href='<?php echo htmlentities($post->url); ?>'>
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
    <p class='empty'>There are no posts right now</p>
    <?php
}
