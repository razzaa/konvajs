<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

</body>
<script>
 //main API:
 var imageObj = new Image();
       imageObj.onload = function () {
         var yoda = new Konva.Image({
           x: 50,
           y: 50,
           image: imageObj,
           width: 106,
           height: 118,
           draggable: true,
         });

          //add the shape to the layer
         layer.add(yoda);
         layer.batchDraw();
       };
       imageObj.src = '/images/octocat.png';
    var imageObj = new Image();
       imageObj.onload = function () {
         var yoda = new Konva.Image({
           x: 50,
           y: 200,
           image: imageObj,
           width: 106,
           height: 118,
           draggable: true,
         });

          //add the shape to the layer
         layer.add(yoda);
         layer.batchDraw();
    };
       imageObj.src = '/images/octocat.png';
       var imageObj = new Image();
       imageObj.onload = function () {
         var yoda = new Konva.Image({
           x: 50,
           y: 350,
           image: imageObj,
           width: 106,
           height: 118,
           draggable: true,
         });

          //add the shape to the layer
         layer.add(yoda);
         layer.batchDraw();
    };
       imageObj.src = '/images/octocat.png';
</script>
</html>
