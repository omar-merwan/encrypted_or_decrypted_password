<?php
session_start();
$method = "AES-256-CBC";
if (!isset($_SESSION["key"])) {

    $_SESSION["key"] = openssl_random_pseudo_bytes(32);
    $iv_lenght = openssl_cipher_iv_length($method);
    $_SESSION["iv"] = openssl_random_pseudo_bytes($iv_lenght);
}
$key = $_SESSION["key"];
$iv  = $_SESSION["iv"];

$encrypted_text = "";
$decrypted_text = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["encrypt"])) {

        $data = $_POST["text"];
        $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
        $encrypted_text = base64_encode($encrypted);}

    if (isset($_POST["decrypt"]))
        {$data = $_POST["text"];
        $decoded = base64_decode($data);
        $decrypted_text = openssl_decrypt($decoded, $method, $key, 0, $iv);}
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>encrypted_or_decrypted_password</title>
</head>
<body style="direction: rtl; font-family: Arial; padding:20px;">
    <form method="POST">
        <input type="text" style="width: 300px; height: 40px;" name="text" placeholder="أكتب النص هنا..." />
        <br><br>
        <button type="submit" name="encrypt">تشفير</button>
        <button type="submit" name="decrypt">فك التشفير</button>
    </form>
    <br>
    <?php 
if ($encrypted_text != ""):
    echo '<h3>النص المشفر:</h3>
          <div style="background: none; border: 2px solid #000000ff;">' . $encrypted_text;
endif;
if ($decrypted_text != ""):
    echo '<h3>النص بعد فك التشفير:</h3>
          <div style="background: none; border: 2px solid #000000ff;">' . $decrypted_text;
endif;
?>
</body>
</html>
