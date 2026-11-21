<?php
$keys = ['file_uploads', 'upload_max_filesize', 'post_max_size',
         'max_file_uploads', 'memory_limit', 'max_execution_time'];
echo '<h2>Настройки загрузки</h2><ul>';
foreach ($keys as $k) {
    echo "<li><b>$k</b>: " . ini_get($k) . '</li>';
}
echo '</ul>';
echo 'Файл настроек: ' . php_ini_loaded_file();