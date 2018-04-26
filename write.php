<?php
require_once(__DIR__.'/vendor/autoload.php');

include_once(__DIR__.'/resources/view/layouts/upper.php');
if(empty($_SESSION['id'])) header('Location: /');
// content
include_once(__DIR__.'/resources/view/write_form.php');

include_once(__DIR__.'/resources/view/layouts/lower.php');