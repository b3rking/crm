<?php

// ------------------------------------------------------------------------
// Mail configuration
// This file just defines variables that are picked up by controller/mail.controller.php
// ------------------------------------------------------------------------

// Old production values (kept here for reference)
// $_from        = 'crm@spidernet-bi.com';
// $_smtp_secure = 'ssl';
// $_host        = 'mail.spidernet-bi.com';
// $_port        = 465;
// $_username    = 'crm@spidernet-bi.com';
// $_password    = 'Crm311282++';

// ------------------------------------------------------------------------
// Mailtrap sandbox configuration (for testing only)
// ------------------------------------------------------------------------

// You can keep using your real "from" address here; Mailtrap will intercept it.
$_from        = 'spidernet@mediabox.bi';

// Mailtrap SMTP settings (from your Mailtrap dashboard)
$_host        = 'vps.mediabox.bi';
$_port        = 587;
$_username    = 'spidernet@mediabox.bi';
$_password    = '{UAn[AKQCbBB*d;b'; // replace with the full password from Mailtrap

// Use TLS for Mailtrap (PHPMailer will map this correctly)
$_smtp_secure = 'tls';
