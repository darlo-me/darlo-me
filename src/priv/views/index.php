<?php
$this->css = $this->about->css ?? [] + $this->posts->css ?? [];
echo $this->about;
echo $this->posts;
