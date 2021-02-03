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
      Konva.Image.fromURL('/images/template1.png', function (darthNode) {
        darthNode.setAttrs({

          scaleX: 0.5,
          scaleY: 0.4,
        });
        layer.add(darthNode);
        layer.batchDraw();
      });

      //main template
      var template = new Konva.Image({
        x: 20,
        y: 20,
        scaleX: 0.5,
        scaleY: 0.4,
      });
      layer.add(template);

      // darth vader
      var darthVaderImg = new Konva.Image({
        x: 20,
        y: 20,
        width: 200,
        height: 137,
        draggable: true,
      });
      layer.add(darthVaderImg);

      // yoda
      var yodaImg = new Konva.Image({
        x: 240,
        y: 20,
        width: 93,
        height: 104,
        draggable: true,
      });
      layer.add(yodaImg);

      //template
      var template = new Image();
      template.onload = function () {
        template.image(template);
        layer.draw();
      };
      template.src = '/images/template1.png';


      var imageObj1 = new Image();
      imageObj1.onload = function () {
        darthVaderImg.image(imageObj1);
        layer.draw();
      };
      imageObj1.src = '/images/logo.png';

      var imageObj2 = new Image();
      imageObj2.onload = function () {
        yodaImg.image(imageObj2);
        layer.draw();
      };
      imageObj2.src = '/images/name.png';

</script>
</body>
</html>
