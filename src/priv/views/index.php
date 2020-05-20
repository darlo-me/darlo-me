<?php
echo $this->about;
if($this->posts->posts) {
    echo $this->posts;
}
$this->css = ($this->about->css ?? []) + ($this->posts->css ?? []);
