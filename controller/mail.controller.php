<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Generic mail helper to be reused across the app (e.g. for sending invoices).
 *
 * @param string|array $to         Single email or array of emails
 * @param string       $subject    Mail subject
 * @param string       $body       Mail body (HTML by default)
 * @param array        $attachments List of attachment paths or [path => name]
 * @param bool         $isHtml     Whether body is HTML
 * @return bool
 */
function send_email($to, $subject, $body, $attachments = [], $isHtml = true)
{
    // Make sure we have ROOT (defined in index.php)
    if (!defined('ROOT')) {
        // Fallback: base on this file location
        define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
    }

    // Load Composer autoload + mail config (adjust if your paths differ)
    require_once ROOT . 'vendor/autoload.php';
    require_once ROOT . 'config/_config_mail.php';

    // Extract config variables from $GLOBALS (include creates them in global scope)
    // If the include didn't work, getenv/defaults will handle it
    $smtpHost = $GLOBALS['_host'] ?? ($_host ?? (getenv('SMTP_HOST') ?: null));
    $smtpUser = $GLOBALS['_username'] ?? ($_username ?? (getenv('SMTP_USER') ?: null));
    $smtpPass = $GLOBALS['_password'] ?? ($_password ?? (getenv('SMTP_PASS') ?: null));
    $smtpSecure = $GLOBALS['_smtp_secure'] ?? ($_smtp_secure ?? (getenv('SMTP_SECURE') ?: null));
    $smtpPort = $GLOBALS['_port'] ?? ($_port ?? (getenv('SMTP_PORT') ?: null));
    $smtpFrom = $GLOBALS['_from'] ?? ($_from ?? (getenv('SMTP_FROM') ?: null));

    // Diagnostic: log which config symbols are present (don't log secret values)
    $cfgPresence = [
        '_host' => isset($GLOBALS['_host']) || isset($_host) ? true : false,
        '_username' => isset($GLOBALS['_username']) || isset($_username) ? true : false,
        '_password' => isset($GLOBALS['_password']) || isset($_password) ? true : false,
        '_smtp_secure' => isset($GLOBALS['_smtp_secure']) || isset($_smtp_secure) ? true : false,
        '_port' => isset($GLOBALS['_port']) || isset($_port) ? true : false,
        '_from' => isset($GLOBALS['_from']) || isset($_from) ? true : false,
    ];
    error_log('send_email config presence: ' . json_encode($cfgPresence));

    $mail = new PHPMailer(true);

    try {
        // Validate minimal config
        if (empty($smtpHost) || empty($smtpUser) || empty($smtpPass) || empty($smtpFrom)) {
            echo 'Mailer error: missing SMTP configuration';
            error_log('send_email error: missing SMTP configuration variables');
            return false;
        }

        // SMTP configuration from _config_mail.php
        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUser;
        $mail->Password   = $smtpPass;
        $mail->SMTPSecure = $smtpSecure;
        $mail->Port       = $smtpPort;
        $mail->CharSet    = 'UTF-8'; // Ensure UTF-8 encoding for accented characters

        // Sender
        $mail->setFrom($smtpFrom);

        // Recipients - ensure $to is always treated as array
        $recipientList = is_array($to) ? $to : [$to];
        foreach ($recipientList as $address) {
            if (!empty($address) && filter_var($address, FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($address);
            }
        }

        // Verify at least one recipient was added
        if (empty($mail->getAllRecipientAddresses())) {
            throw new Exception('No valid recipient addresses provided');
        }

        // Attachments - handle both file paths and inline data
        foreach ($attachments as $key => $value) {
            if (is_int($key)) {
                // Numeric key: value is the file path
                $filePath = $value;
                // Check if file exists before attempting to attach
                if (file_exists($filePath)) {
                    $fileName = basename($filePath);
                    // Read file content and attach as stream (works with Mailtrap and file paths)
                    $fileContent = file_get_contents($filePath);
                    if ($fileContent !== false) {
                        // Create a stream from the content
                        $stream = fopen('php://memory', 'r+');
                        fwrite($stream, $fileContent);
                        rewind($stream);
                        $mail->addStringAttachment($fileContent, $fileName, PHPMailer::ENCODING_BASE64, 'application/pdf');
                    }
                } else {
                    error_log('send_email warning: attachment file not found - ' . $filePath);
                }
            } else {
                // Associative: key is path, value is name
                $filePath = $key;
                $fileName = $value;
                if (file_exists($filePath)) {
                    $fileContent = file_get_contents($filePath);
                    if ($fileContent !== false) {
                        $mail->addStringAttachment($fileContent, $fileName, PHPMailer::ENCODING_BASE64, 'application/pdf');
                    }
                } else {
                    error_log('send_email warning: attachment file not found - ' . $filePath);
                }
            }
        }

        // Content
        $mail->isHTML($isHtml);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        return $mail->send();
    } catch (Exception $e) {
        // TEMP: show the exact SMTP/PHPMailer error
        echo 'Mailer error: ' . $mail->ErrorInfo;
        error_log('send_email error: ' . $mail->ErrorInfo);
        return false;
    }
}
