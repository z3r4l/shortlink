<!DOCTYPE html>
<html>
<head>
    <title>How to Generate QR Code in Laravel 8? - ItSolutionStuff.com</title>
</head>
<body>
    
<div class="visible-print text-center">
    <h1>Laravel 8 - QR Code Generator Example</h1>
     
    {!! QrCode::size(250)->generate('https://www.youtube.com/results?search_query=tutorial+membuat+qr+code+laravel'); !!}
     
    <p>example by ItSolutionStuf.com.</p>
</div>
    
</body>
</html>