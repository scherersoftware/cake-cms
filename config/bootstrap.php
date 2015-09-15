<?php
use Cake\Core\Configure;
use Cake\Utility\Hash;

// Load and merge default with app config
$config = include 'cms.default.php';
$config = $config['Cms'];
if ($appCmsConfig = Configure::read('Cms')) {
    $config = Hash::merge($config, $appCmsConfig);
}
Configure::write('Cms', $config);
