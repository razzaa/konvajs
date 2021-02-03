<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/konva@7.2.2/konva.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>KonvasJS</title>
</head>
<body>
<div class="flex">
  <div class="w-1/6 border-solid border-4 border-light-blue-500 bg-gray-400 h-screen">

  </div>
  <div class="w-5/6 border-solid border-4 border-light-blue-500 bg-gray-400 h-screen p-4">
        <div class="w-1/2 h-full p-4 bg-gray-500 place-self-auto">
          <div id="container" class="overflow-hidden"></div>
        </div>
  </div>
</div>
<script>
      var width = window.innerWidth;
      var height = window.innerHeight;
      var stage = new Konva.Stage({
        container: 'container',
        width: width,
        height: height,
      });

      var layer = new Konva.Layer();
      stage.add(layer);
      // alternative API:
      Konva.Image.fromURL('/images/template1.png', function (darthNode) {
        darthNode.setAttrs({

          scaleX: 0.5,
          scaleY: 0.4,
        });
        layer.add(darthNode);
        layer.batchDraw();
      });

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
       imageObj.src = '/images/logo.png';

       var imageObj2 = new Image();
       imageObj2.onload = function () {
         var yoda2 = new Konva.Image({
           x: 150,
           y: 50,
           image: imageObj2,
           width: 106,
           height: 118,
           draggable: true,
         });

          //add the shape to the layer
         layer.add(yoda2);
         layer.batchDraw();
        };
       imageObj2.src = '/images/name.png';

</script>
</body>
</html>
