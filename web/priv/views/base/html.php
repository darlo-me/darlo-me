<?php
$this->body->process();

if(isset($this->body->css)) {
    $this->head->css = $this->body->css;
}
if(isset($this->body->title)) {
    if(!isset($this->head->title)) {
        $this->head->title = $this->body->title;
    }
}

$this->head->process();
?><html>
<head>
<?php echo pretty_print($this->head); ?>
</head>
<body>
<?php echo pretty_print($this->body); ?>
</body>
</html>
