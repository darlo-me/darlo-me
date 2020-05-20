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
<?php echo $this->head; ?>
</head>
<body>
<?php echo $this->body; ?>
</body>
</html>
