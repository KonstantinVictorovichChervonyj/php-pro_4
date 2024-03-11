<?php

$example = $argv[1] ?? 'error';
try {
    require_once __DIR__ . "/../examples/$example.php";
} catch (Error $e) {
    echo 'ERROR: ' . $e->getMessage();
}

exit;