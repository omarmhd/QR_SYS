<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Status</title>
</head>
<body>
<h2>EN: {{ $messages['en'] }}</h2>
<h2>RO: {{ $messages['ro'] }}</h2>

<script>
    @if($status === 'success')
    setTimeout(() => {
        window.location.href = "myapp://payment-success";
    }, 1500);
    @elseif($status === 'failed')
    setTimeout(() => {
        window.location.href = "myapp://payment-failed";
    }, 2000);
    @else
    setTimeout(() => {
        window.location.href = "/dashboard";
    }, 3000);
    @endif
</script>
</body>
</html>
