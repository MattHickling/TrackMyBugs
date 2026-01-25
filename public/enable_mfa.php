<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use OTPHP\TOTP;

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT mfa_secret FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!empty($user['mfa_secret'])) {
    die('MFA already enabled.');
}

$totp = TOTP::create();
$totp->setLabel("TrackMyBugs");

$stmt = $conn->prepare("UPDATE users SET mfa_secret = ?, mfa_enabled = 1 WHERE id = ?");
$secret = $totp->getSecret();
$stmt->bind_param("si", $secret, $userId);
$stmt->execute();

$qrUrl = $totp->getProvisioningUri();
?>

<h2>Enable MFA</h2>
<p>Scan this QR code with Google Authenticator / Authy:</p>

<img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=<?php echo urlencode($qrUrl); ?>">

<p>After scanning, log out and log in again.</p>
