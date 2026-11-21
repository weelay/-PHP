<?php
$uploadDir = __DIR__ . '/uploads/';

function back(string $param, string $text): void {
    header('Location: index.php?' . $param . '=' . urlencode($text));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && empty($_FILES)
    && ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
    back('error', 'Запрос больше post_max_size (' . ini_get('post_max_size') . ')');
}

$file = $_FILES['userfile'] ?? null;

if ($file === null) {
    back('error', 'Файл не был отправлен');
}

if ($file['error'] === UPLOAD_ERR_NO_FILE) {
    back('error', 'Файл не выбран');
}
if ($file['error'] === UPLOAD_ERR_INI_SIZE) {
    back('error', 'Размер файла превышает upload_max_filesize (' . ini_get('upload_max_filesize') . ')');
}
if ($file['error'] !== UPLOAD_ERR_OK) {
    back('error', 'Ошибка загрузки, код: ' . $file['error']);
}

$maxSize = 5 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    back('error', 'Файл больше 5 МБ');
}

$allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'docx', 'xlsx', 'zip'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    back('error', 'Недопустимый тип файла: .' . $ext);
}

$name = basename($file['name']);
$name = preg_replace('/[^\w.\-]/u', '_', $name);

if (file_exists($uploadDir . $name)) {
    $name = time() . '_' . $name;
}

if (move_uploaded_file($file['tmp_name'], $uploadDir . $name)) {
    back('msg', 'Файл загружен');
} else {
    back('error', 'Не удалось сохранить файл');
}