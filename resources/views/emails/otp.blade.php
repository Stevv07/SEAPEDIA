<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F3F7FB;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 500px;
            background-color: #ffffff;
            border-radius: 12px;
            margin: 0 auto;
            padding: 30px 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        .title {
            font-size: 22px;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 10px;
        }
        .description {
            font-size: 14px;
            color: #555;
            margin-bottom: 25px;
        }
        .otp-code {
            display: inline-block;
            background-color: #E3F2FD;
            color: #0D47A1;
            font-size: 24px;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 8px;
            letter-spacing: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Kode OTP Anda</div>
        <p class="description">Gunakan kode berikut untuk verifikasi akun Anda. Kode ini hanya berlaku selama beberapa menit.</p>
        <div class="otp-code">{{ $otp }}</div>
        <p class="footer">Jika Anda tidak meminta kode ini, abaikan email ini.</p>
    </div>
</body>
</html>
