<!DOCTYPE html>
<html>
  <head>
    <script src="https://unpkg.com/konva@7.2.2/konva.min.js"></script>
    <meta charset="utf-8" />
    <title>Konva Image Demo</title>
    <style>
      body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #f0f0f0;
      }
    </style>
  </head>
  <body>
    <div id="container"></div>
    <script>
    //   var width = window.innerWidth;
    //   var height = window.innerHeight;
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
      Konva.Image.fromURL('/images/octocat.png', function (darthNode) {
        darthNode.setAttrs({
          x: 200,
          y: 50,
          scaleX: 0.5,
          scaleY: 0.4,
        });
        layer.add(darthNode);
        layer.batchDraw();
      });
      function downloadURI(uri, name) {
        var link = document.createElement('a');
        link.download = name;
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        alert(1);
        document.body.removeChild(link);
        var fs = require('fs');
        var imagedata = uri; // get imagedata from POST request
        fs.writeFile("/images/file.png", imagedata, 'binary', function(err) {
        console.log("The file was saved!");
        });
        delete link;
      }

      document.getElementById('save').addEventListener(
        'click',
        function () {
          var dataURL = stage.toDataURL({ pixelRatio: 3 });
          downloadURI(dataURL, 'stage.png');
        },
        false
      );

    </script>
  </body>
</html>
