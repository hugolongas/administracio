<?php
$target = '/home/lalianca/administracio/storage/app/public';
$shortcut = '/home/lalianca/public_html/administracio/storage';
symlink($target, $shortcut);
echo 'symlink'
?>