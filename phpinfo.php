<?php
echo phpinfo();

echo '<pre>';
echo 'EXTENSÕES CARREGADAS:<br/>';
print_r(get_loaded_extensions());
echo '</pre>';

?>