<?php
// Afficher uniquement les informations de configuration des téléchargements de fichiers
echo '<h1>Configuration PHP pour les téléchargements</h1>';
echo '<p>upload_max_filesize = ' . ini_get('upload_max_filesize') . '</p>';
echo '<p>post_max_size = ' . ini_get('post_max_size') . '</p>';
echo '<p>max_file_uploads = ' . ini_get('max_file_uploads') . '</p>';
echo '<p>max_execution_time = ' . ini_get('max_execution_time') . '</p>';
echo '<p>memory_limit = ' . ini_get('memory_limit') . '</p>';
echo '<p>file_uploads = ' . ini_get('file_uploads') . '</p>';
echo '<p>upload_tmp_dir = ' . ini_get('upload_tmp_dir') . '</p>';
?> 