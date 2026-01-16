<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>購入管理システム</title>
    @vite(['resources/css/app.css', 'resources/js/purchaseApp.js'])
</head>
<body>
    <div id="purchase-app"></div>
</body>
</html>


