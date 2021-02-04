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
        <div class="w-2/5 h-full p-4 border-gray-900 place-self-auto bg-cover bg-center bg-hero-lg">
          <div id="container" class="overflow-hidden"></div>
        </div>
  </div>
</div>
<style>
  @font-face {
    font-family: 'FontAwesome';
    src: url('/template1/font/Universal-Knowledge/UniversalKnowledge.ttf');
    font-weight: normal;
    font-style: normal;
  }
  @font-face {
    font-family: 'RodenBerg';
    src: url('/template1/font/rodenberg/RODENBERG_DEMO.ttf');
    font-weight: normal;
    font-style: normal;
  }
  @font-face {
    font-family: 'havelock';
    src: url('/template1/font/hovelock/HavelockRegular.ttf');
    font-weight: normal;
    font-style: normal;
  }
</style>
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


    //    var imageObj2 = new Image();
    //    imageObj2.onload = function () {
    //      var yoda2 = new Konva.Image({
    //        x: 150,
    //        y: 50,
    //        image: imageObj2,
    //        width: 106,
    //        height: 118,
    //        draggable: true,
    //      });

    //       //add the shape to the layer
    //      layer.add(yoda2);
    //      layer.batchDraw();
    //     };
    //    imageObj2.src = '/images/name.png';

        //----------------------------
        var textNode = new Konva.Text({
        text: 'ASHLAR',
        x: 250,
        y: 80,
        fontSize: 30,
        draggable: true,
        width: 250,
        fontFamily:'havelock',
        fill: '#273A55',
      });

      layer.add(textNode);

      var tr = new Konva.Transformer({
        node: textNode,
        enabledAnchors: ['middle-left', 'middle-right'],
        // set minimum width of text
        boundBoxFunc: function (oldBox, newBox) {
          newBox.width = Math.max(30, newBox.width);
          return newBox;
        },
      });

      textNode.on('transform', function () {
        // reset scale, so only with is changing by transformer
        textNode.setAttrs({
          width: textNode.width() * textNode.scaleX(),
          scaleX: 1,
        });
      });

      layer.add(tr);

      layer.draw();

      textNode.on('dblclick', () => {
        // hide text node and transformer:
        textNode.hide();
        tr.hide();
        layer.draw();

        // create textarea over canvas with absolute position
        // first we need to find position for textarea
        // how to find it?

        // at first lets find position of text node relative to the stage:
        var textPosition = textNode.absolutePosition();

        // then lets find position of stage container on the page:
        var stageBox = stage.container().getBoundingClientRect();

        // so position of textarea will be the sum of positions above:
        var areaPosition = {
          x: stageBox.left + textPosition.x,
          y: stageBox.top + textPosition.y,
        };

        // create textarea and style it
        var textarea = document.createElement('textarea');
        document.body.appendChild(textarea);

        // apply many styles to match text on canvas as close as possible
        // remember that text rendering on canvas and on the textarea can be different
        // and sometimes it is hard to make it 100% the same. But we will try...
        textarea.value = textNode.text();
        textarea.style.position = 'absolute';
        textarea.style.top = areaPosition.y + 'px';
        textarea.style.left = areaPosition.x + 'px';
        textarea.style.width = textNode.width() - textNode.padding() * 2 + 'px';
        textarea.style.height =
        textNode.height() - textNode.padding() * 2 + 5 + 'px';
        textarea.style.fontSize = textNode.fontSize() + 'px';
        textarea.style.border = 'none';
        textarea.style.padding = '0px';
        textarea.style.margin = '0px';
        textarea.style.overflow = 'hidden';
        textarea.style.background = 'none';
        textarea.style.outline = 'none';
        textarea.style.resize = 'none';
        textarea.style.lineHeight = textNode.lineHeight();
        textarea.style.fontFamily = textNode.fontFamily();
        textarea.style.transformOrigin = 'left top';
        textarea.style.textAlign = textNode.align();
        textarea.style.color = textNode.fill();
        rotation = textNode.rotation();
        var transform = '';
        if (rotation) {
          transform += 'rotateZ(' + rotation + 'deg)';
        }

        var px = 0;
        // also we need to slightly move textarea on firefox
        // because it jumps a bit
        var isFirefox =
          navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
        if (isFirefox) {
          px += 2 + Math.round(textNode.fontSize() / 20);
        }
        transform += 'translateY(-' + px + 'px)';

        textarea.style.transform = transform;

        // reset height
        textarea.style.height = 'auto';
        // after browsers resized it we can set actual value
        textarea.style.height = textarea.scrollHeight + 3 + 'px';

        textarea.focus();

        function removeTextarea() {
          textarea.parentNode.removeChild(textarea);
          window.removeEventListener('click', handleOutsideClick);
          textNode.show();
          tr.show();
          tr.forceUpdate();
          layer.draw();
        }

        function setTextareaWidth(newWidth) {
          if (!newWidth) {
            // set width for placeholder
            newWidth = textNode.placeholder.length * textNode.fontSize();
          }
          // some extra fixes on different browsers
          var isSafari = /^((?!chrome|android).)*safari/i.test(
            navigator.userAgent
          );
          var isFirefox =
            navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
          if (isSafari || isFirefox) {
            newWidth = Math.ceil(newWidth);
          }

          var isEdge =
            document.documentMode || /Edge/.test(navigator.userAgent);
          if (isEdge) {
            newWidth += 1;
          }
          textarea.style.width = newWidth + 'px';
        }

        textarea.addEventListener('keydown', function (e) {
          // hide on enter
          // but don't hide on shift + enter
          if (e.keyCode === 13 && !e.shiftKey) {
            textNode.text(textarea.value);
            removeTextarea();
          }
          // on esc do not set value back to node
          if (e.keyCode === 27) {
            removeTextarea();
          }
        });

        textarea.addEventListener('keydown', function (e) {
          scale = textNode.getAbsoluteScale().x;
          setTextareaWidth(textNode.width() * scale);
          textarea.style.height = 'auto';
          textarea.style.height =
            textarea.scrollHeight + textNode.fontSize() + 'px';
        });

        function handleOutsideClick(e) {
          if (e.target !== textarea) {
            textNode.text(textarea.value);
            removeTextarea();
          }
        }
        setTimeout(() => {
          window.addEventListener('click', handleOutsideClick);
        });
      });


        //----------------------------
        //----------------------------------------------------------------------------------------------------
        //text area 2
        var textNode2 = new Konva.Text({
        text: 'Apply & join our team!',
        x: 220,
        y: 120,
        fontSize: 20,
        draggable: true,
        width: 200,
        fill: '#273A55',
      });

      layer.add(textNode2);

      var tr2 = new Konva.Transformer({
        node: textNode2,
        enabledAnchors: ['middle-left', 'middle-right'],
        // set minimum width of text
        boundBoxFunc: function (oldBox, newBox) {
          newBox.width = Math.max(30, newBox.width);
          return newBox;
        },
      });

      textNode2.on('transform', function () {
        // reset scale, so only with is changing by transformer
        textNode2.setAttrs({
          width: textNode2.width() * textNode2.scaleX(),
          scaleX: 1,
        });
      });

      layer.add(tr2);

      layer.draw();

      textNode2.on('dblclick', () => {
        // hide text node and transformer:
        textNode2.hide();
        tr2.hide();
        layer.draw();

        // create textarea over canvas with absolute position
        // first we need to find position for textarea
        // how to find it?

        // at first lets find position of text node relative to the stage:
        var textPosition2 = textNode2.absolutePosition();

        // then lets find position of stage container on the page:
        var stageBox2 = stage.container().getBoundingClientRect();

        // so position of textarea will be the sum of positions above:
        var areaPosition2 = {
          x: stageBox2.left + textPosition2.x,
          y: stageBox2.top + textPosition2.y,
        };

        // create textarea and style it
        var textarea2 = document.createElement('textarea');
        document.body.appendChild(textarea2);

        // apply many styles to match text on canvas as close as possible
        // remember that text rendering on canvas and on the textarea can be different
        // and sometimes it is hard to make it 100% the same. But we will try...
        textarea2.value = textNode2.text();
        textarea2.style.position = 'absolute';
        textarea2.style.top = areaPosition2.y + 'px';
        textarea2.style.left = areaPosition2.x + 'px';
        textarea2.style.width = textNode2.width() - textNode2.padding() * 2 + 'px';
        textarea2.style.height =
        textNode2.height() - textNode2.padding() * 2 + 5 + 'px';
        textarea2.style.fontSize = textNode2.fontSize() + 'px';
        textarea2.style.border = 'none';
        textarea2.style.padding = '0px';
        textarea2.style.margin = '0px';
        textarea2.style.overflow = 'hidden';
        textarea2.style.background = 'none';
        textarea2.style.outline = 'none';
        textarea2.style.resize = 'none';
        textarea2.style.lineHeight = textNode2.lineHeight();
        textarea2.style.fontFamily = textNode2.fontFamily();
        textarea2.style.transformOrigin = 'left top';
        textarea2.style.textAlign = textNode2.align();
        textarea2.style.color = textNode2.fill();
        rotation2 = textNode.rotation();
        var transform2 = '';
        if (rotation2) {
          transform2 += 'rotateZ(' + rotation2 + 'deg)';
        }

        var px2 = 0;
        // also we need to slightly move textarea on firefox
        // because it jumps a bit
        var isFirefox2 =
          navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
        if (isFirefox2) {
          px2 += 2 + Math.round(textNode2.fontSize() / 20);
        }
        transform2 += 'translateY(-' + px2 + 'px)';

        textarea2.style.transform = transform;

        // reset height
        textarea2.style.height = 'auto';
        // after browsers resized it we can set actual value
        textarea2.style.height = textarea2.scrollHeight + 3 + 'px';

        textarea2.focus();

        function removeTextarea2() {
          textarea2.parentNode.removeChild(textarea2);
          window2.removeEventListener('click', handleOutsideClick);
          textNode2.show();
          tr2.show();
          tr2.forceUpdate();
          layer.draw();
        }

        function setTextareaWidth(newWidth2) {
          if (!newWidth2) {
            // set width for placeholder
            newWidth2 = textNode2.placeholder.length * textNode2.fontSize();
          }
          // some extra fixes on different browsers
          var isSafari2 = /^((?!chrome|android).)*safari/i.test(
            navigator.userAgent
          );
          var isFirefox2 =
            navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
          if (isSafari2 || isFirefox2) {
            newWidth2 = Math.ceil(newWidth2);
          }

          var isEdge2 =
            document.documentMode || /Edge/.test(navigator.userAgent);
          if (isEdge2) {
            newWidth2 += 1;
          }
          textarea2.style.width = newWidth2 + 'px';
        }

        textarea2.addEventListener('keydown', function (e) {
          // hide on enter
          // but don't hide on shift + enter
          if (e.keyCode === 13 && !e.shiftKey) {
            textNode2.text(textarea2.value);
            removeTextarea2();
          }
          // on esc do not set value back to node
          if (e.keyCode === 27) {
            removeTextarea2();
          }
        });

        textarea2.addEventListener('keydown', function (e) {
          scale = textNode2.getAbsoluteScale().x;
          setTextareaWidth(textNode2.width() * scale);
          textarea2.style.height = 'auto';
          textarea2.style.height =
          textarea2.scrollHeight + textNode2.fontSize() + 'px';
        });

        function handleOutsideClick(e) {
          if (e.target !== textarea2) {
            textNode2.text(textarea2.value);
            removeTextarea2();
          }
        }
        setTimeout(() => {
          window2.addEventListener('click', handleOutsideClick);
        });
      });
        //end text area 2
        //-----------------------------------------------------------------------------------
        //-----------------------------------------------------------------------------------
        //start 3rd area text

        var textNode3 = new Konva.Text({
        text: 'WE ARE HIRING!',
        x: 140,
        y: 210,
        fontSize: 100,
        draggable: true,
        width: 400,
        fill: '#273A55',
        fontFamily:'FontAwesome',
        });

        layer.add(textNode3);
        //---end 4rd area text-------------------
        var textNode4 = new Konva.Text({
        text: 'FRONTEND ENGINEERS',
        x: 190,
        y: 460,
        fontSize: 80,
        draggable: true,
        width: 450,
        fill: '#273A55',
        fontFamily:'RodenBerg',
        });

        layer.add(textNode4);
        //---end 5rd area text-------------------
        var textNode5 = new Konva.Text({
        text: 'JAVASCRIPT',
        x: 280,
        y: 620,
        fontSize: 18,
        draggable: true,
        width: 300,
        fill: '#273A55',
        fontFamily:'Calbiri',
        });
        // font.addFace(fontFile('Ubuntu-Italic.ttf'), 'normal', 'italic');
        // font.addFace(fontFile('Ubuntu-BoldItalic.ttf'), 'bold', 'italic');
        layer.add(textNode5);
        //---end 5th area text-------------------
        // function fontFile(name) {
        // return path.join(__dirname, '/template1/opensans/', name);
        // }
        // var font = new Font('Ubuntu', fontFile('OpenSansBold.ttf'));
        // font.addFace(fontFile('OpenSansBold.ttf'),'bold');
        var textNode5 = new Konva.Text({
        text: 'hr@ashlarglobal.com',
        x: 180,
        y: 700,
        fontSize: 30,
        draggable: true,
        width: 300,
        fill: '#273A55',
        fontFamily : 'Havelock'
        });

        layer.add(textNode5);
        //---end 6th area text-------------------
        var textNode6 = new Konva.Text({
        text: 'Lahore, Paksitan',
        x: 240,
        fill: '#273A55',
        y: 735,
        fontSize: 18,
        draggable: true,
        width: 300,
        });

        layer.add(textNode6);
        //---end 6th area text-------------------
</script>
</body>
</html>
