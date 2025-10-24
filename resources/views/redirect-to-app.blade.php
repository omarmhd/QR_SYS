<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>فتح التطبيق</title>
</head>
<body style="text-align:center; font-family: sans-serif; margin-top: 50px;">
<h2>اضغط لفتح التطبيق</h2>
<button onclick="openApp()" style="padding:10px 20px; font-size:16px;">فتح التطبيق الآن</button>

<script>
    function openApp() {
        window.location.href = "ElUnicoQR://payment-result?status={{ request('status', 'failed') }}";
        setTimeout(() => {
            window.location.href = "https://elunicolounge.com/download";
        }, 2000);
    }
</script>
</body>
</html>
