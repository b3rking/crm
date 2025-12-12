<?php
// Diagnostic endpoint to check SMTP config presence (masks secrets)
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
}

$cfg = [];
if (file_exists(ROOT . 'config' . DIRECTORY_SEPARATOR . '_config_mail.php')) {
    // include but suppress output
    @include ROOT . 'config' . DIRECTORY_SEPARATOR . '_config_mail.php';

    $cfg['_host'] = isset($_host) ? $_host : null;
    $cfg['_username'] = isset($_username) ? $_username : null;
    $cfg['_password_set'] = isset($_password) ? true : false;
    $cfg['_smtp_secure'] = isset($_smtp_secure) ? $_smtp_secure : null;
    $cfg['_port'] = isset($_port) ? $_port : null;
    $cfg['_from'] = isset($_from) ? $_from : null;
} else {
    $cfg['error'] = '_config_mail.php not found at ' . ROOT . 'config' . DIRECTORY_SEPARATOR . '_config_mail.php';
}

// Mask username for safety
if (!empty($cfg['_username'])) {
    $u = $cfg['_username'];
    $len = strlen($u);
    if ($len <= 4) {
        $cfg['_username_masked'] = substr($u, 0, 1) . str_repeat('*', max(0, $len - 1));
    } else {
        $cfg['_username_masked'] = substr($u, 0, 1) . str_repeat('*', $len - 2) . substr($u, -1);
    }
} else {
    $cfg['_username_masked'] = null;
}
// Mask host minimally
if (!empty($cfg['_host'])) {
    $h = $cfg['_host'];
    $cfg['_host_masked'] = preg_replace('/([^.@])/', '*', $h, 1); // mask first char
} else {
    $cfg['_host_masked'] = null;
}

// Build response
$response = [
    'present' => [
        '_host' => $cfg['_host'] !== null,
        '_username' => $cfg['_username'] !== null,
        '_password_set' => $cfg['_password_set'] === true,
        '_smtp_secure' => $cfg['_smtp_secure'] !== null,
        '_port' => $cfg['_port'] !== null,
        '_from' => $cfg['_from'] !== null,
    ],
    'values' => [
        '_host' => $cfg['_host_masked'],
        '_username' => $cfg['_username_masked'],
        '_smtp_secure' => $cfg['_smtp_secure'],
        '_port' => $cfg['_port'],
        '_from' => $cfg['_from'],
    ],
];
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
