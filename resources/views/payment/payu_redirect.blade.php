<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to PayU...</title>
    <style>
        body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; background-color: #f8fafc; }
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin-bottom: 20px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="loader"></div>
    <h3>Redirecting to Secure Payment...</h3>
    <p>Please do not refresh the page.</p>

    <form action="{{ $payuUrl }}" method="post" id="payuForm">
        <input type="hidden" name="key" value="{{ $key }}" />
        <input type="hidden" name="txnid" value="{{ $txnid }}" />
        <input type="hidden" name="amount" value="{{ $amount }}" />
        <input type="hidden" name="productinfo" value="{{ $productinfo }}" />
        <input type="hidden" name="firstname" value="{{ $firstname }}" />
        <input type="hidden" name="email" value="{{ $email }}" />
        <input type="hidden" name="phone" value="{{ $phone }}" />
        <input type="hidden" name="surl" value="{{ $surl }}" />
        <input type="hidden" name="furl" value="{{ $furl }}" />
        <input type="hidden" name="hash" value="{{ $hash }}" />
    </form>

    <script>
        document.getElementById('payuForm').submit();
    </script>
</body>
</html>
