<?php
// test_mail.php at project root (E:\xampp\htdocs\crm.buja)

// Make sure ROOT exists for mail.controller.php
if (!defined('ROOT')) {
    define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
}

// Load just the mail helper (it will pull in vendor + mail config)
require_once 'controller/mail.controller.php';

$ok = send_email(
    'your-real-email@example.com',               // change this
    'Test from CRM',
    '<p>This is a test email from <strong>crm.buja</strong>.</p>'
);

var_dump($ok);