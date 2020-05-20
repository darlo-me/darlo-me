<?php
// Must be before to get return arguments
$this->about->process();
$this->posts->process();

$this->css = ($this->about->css ?? []) + ($this->posts->css ?? []);
echo $this->about;
echo $this->posts;
