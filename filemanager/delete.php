<?php
$name = basename($_GET['file'] ?? '');
$path = __DIR__ . '/uploads/' . $name;

if ($name !== '' && is_file($path)) {
    unlink($path);
}

header('Location: index.php');
exit;