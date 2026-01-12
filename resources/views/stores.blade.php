<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>店舗管理 - 弁当注文システム</title>
    @vite(['resources/css/app.css', 'resources/js/storeApp.js'])
</head>
<body>
    <div id="store-app"></div>
</body>
</html>

