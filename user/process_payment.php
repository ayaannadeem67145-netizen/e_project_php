<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['booking']) || !isset($_POST['method'])) {
    header("Location: login.php");
    exit();
}

$method = $_POST['method'];
$_SESSION['selected_method'] = $method; 

switch ($method) {
    case 'easypaisa':
        header("Location: easypaisa_gateway.php");
        break;
    case 'jazzcash':
        header("Location: jazzcash_gateway.php");
        break;
    case 'card':
        header("Location: card_payment.php");
        break;
    case 'cod':
        header("Location: cod_gateway.php");
        break;
    default:
        echo "Invalid Payment Method Selected.";
        break;
}
exit();
