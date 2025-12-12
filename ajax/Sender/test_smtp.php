    <?php

    /**
     * Quick SMTP Configuration Tester
     * Test your mail server settings before deploying to production
     */

    // e:\xampp\htdocs\crm.buja\ajax\Sender\test_smtp.php -> go up 2 levels to project ROOT
    $ROOT = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
    require_once($ROOT . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load your mail config
    if (file_exists($ROOT . 'config' . DIRECTORY_SEPARATOR . '_config_mail.php')) {
        include $ROOT . 'config' . DIRECTORY_SEPARATOR . '_config_mail.php';
    } else {
        die("Error: Mail config file not found.");
    }

    $testEmail = isset($_GET['email']) ? $_GET['email'] : (isset($_POST['email']) ? $_POST['email'] : '');

    // Handle HTML form
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET['send'])) {
    ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>SMTP Configuration Tester</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 40px;
                    background: #f5f5f5;
                }

                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                h1 {
                    color: #333;
                }

                .form-group {
                    margin: 15px 0;
                }

                label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 5px;
                }

                input {
                    width: 100%;
                    padding: 8px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }

                button {
                    background: #007bff;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    margin-top: 10px;
                }

                button:hover {
                    background: #0056b3;
                }

                .config-info {
                    background: #f9f9f9;
                    padding: 15px;
                    border-left: 4px solid #007bff;
                    margin: 20px 0;
                }

                .config-info p {
                    margin: 5px 0;
                    font-size: 14px;
                    font-family: monospace;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h1>📧 SMTP Configuration Tester</h1>

                <div class="config-info">
                    <p><strong>Current SMTP Settings:</strong></p>
                    <p>Host: <?= htmlspecialchars($_host ?? 'Not set') ?></p>
                    <p>Port: <?= htmlspecialchars($_port ?? 'Not set') ?></p>
                    <p>Username: <?= htmlspecialchars($_username ?? 'Not set') ?></p>
                    <p>Secure: <?= htmlspecialchars($_smtp_secure ?? 'Not set') ?></p>
                    <p>From: <?= htmlspecialchars($_from ?? 'Not set') ?></p>
                </div>

                <form method="POST">
                    <div class="form-group">
                        <label for="email">Test Email Address:</label>
                        <input type="email" id="email" name="email" placeholder="your-email@example.com" required value="<?= htmlspecialchars($testEmail) ?>">
                    </div>
                    <button type="submit" name="send" value="1">🚀 Send Test Email</button>
                </form>
            </div>
        </body>

        </html>
        <?php
        exit;
    }

    // Handle test send
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['send']) && $_GET['send'] === '1')) {
        $recipientEmail = isset($_POST['email']) ? sanitize_email($_POST['email']) : (isset($_GET['email']) ? sanitize_email($_GET['email']) : '');

        if (empty($recipientEmail)) {
            die(json_encode(['success' => false, 'message' => 'No recipient email provided']));
        }

        try {
            $mail = new PHPMailer(true);

            // Enable debug output (optional)
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->isSMTP();
            $mail->Host = $_host;
            $mail->SMTPAuth = true;
            $mail->Username = $_username;
            $mail->Password = $_password;
            $mail->SMTPSecure = ($_smtp_secure === 'tls') ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $_port;
            $mail->Timeout = 10;
            $mail->ConnectTimeout = 10;

            // Set charset
            $mail->CharSet = 'UTF-8';

            // Email details
            $mail->setFrom($_from, 'SPIDERNET Test');
            $mail->addAddress($recipientEmail);
            $mail->Subject = '[TEST] SPIDERNET SMTP Configuration Test - ' . date('Y-m-d H:i:s');
            $mail->isHTML(true);
            $mail->Body = '
            <html>
                <body style="font-family: Arial, sans-serif;">
                    <h2>✅ SMTP Configuration Test Successful!</h2>
                    <p>Your SMTP settings are working correctly.</p>
                    <hr>
                    <p><strong>Test Details:</strong></p>
                    <ul>
                        <li>Sent from: ' . htmlspecialchars($_from) . '</li>
                        <li>To: ' . htmlspecialchars($recipientEmail) . '</li>
                        <li>SMTP Host: ' . htmlspecialchars($_host) . ':' . $_port . '</li>
                        <li>Security: ' . htmlspecialchars($_smtp_secure) . '</li>
                        <li>Time: ' . date('Y-m-d H:i:s') . '</li>
                    </ul>
                    <p>You can now use this configuration in your application.</p>
                </body>
            </html>
            ';
            $mail->AltBody = 'SMTP Configuration Test Successful!';

            // Send
            if ($mail->send()) {
                $result = [
                    'success' => true,
                    'message' => 'Test email sent successfully to: ' . htmlspecialchars($recipientEmail),
                    'details' => [
                        'host' => $_host,
                        'port' => $_port,
                        'from' => $_from,
                        'to' => $recipientEmail,
                        'timestamp' => date('Y-m-d H:i:s')
                    ]
                ];
            } else {
                $result = [
                    'success' => false,
                    'message' => 'Failed to send email: ' . $mail->ErrorInfo
                ];
            }
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'message' => 'SMTP Error: ' . $e->getMessage(),
                'error_code' => $e->getCode()
            ];
        }

        // Return JSON for AJAX requests, HTML for direct browser access
        if (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false || isset($_POST['email'])) {
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
        ?>
            <!DOCTYPE html>
            <html>

            <head>
                <title>SMTP Test Result</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 40px;
                        background: #f5f5f5;
                    }

                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background: white;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }

                    .success {
                        border-left: 4px solid #28a745;
                        background: #f0fff4;
                    }

                    .error {
                        border-left: 4px solid #dc3545;
                        background: #fff5f5;
                    }

                    .result-box {
                        padding: 15px;
                        border-radius: 4px;
                        margin: 20px 0;
                    }

                    button {
                        background: #007bff;
                        color: white;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                    }

                    button:hover {
                        background: #0056b3;
                    }
                </style>
            </head>

            <body>
                <div class="container">
                    <div class="result-box <?= $result['success'] ? 'success' : 'error' ?>">
                        <h2><?= $result['success'] ? '✅ Success!' : '❌ Error' ?></h2>
                        <p><?= htmlspecialchars($result['message']) ?></p>
                        <?php if (isset($result['details'])): ?>
                            <hr>
                            <p><strong>Details:</strong></p>
                            <ul>
                                <?php foreach ($result['details'] as $key => $value): ?>
                                    <li><strong><?= ucfirst($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <button onclick="window.location.reload()">🔄 Test Again</button>
                </div>
            </body>

            </html>
    <?php
        }
        exit;
    }

    function sanitize_email($email)
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }
    ?>