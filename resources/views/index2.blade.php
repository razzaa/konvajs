<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div><button id="save">Save as image</button></div>
    <div class="container">
        @include('konva.sidebar')
         <div>
            @include('konva.index')
         </div>
    </div>
</body>
</html>
