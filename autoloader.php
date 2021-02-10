<?php
const extension = ".php";

function loadClass($className) {
    include_once $className.extension;
}

spl_autoload_register('loadClass');