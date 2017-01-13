<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Colorpicker</title>
    <link rel="stylesheet" href="colorpicker.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>

<div id="canvas">
    <canvas width="600" height="600" id="canvas_picker"></canvas>
</div>
<div align="center">
    <div id="hex">HEX: <input type="text"></input></div>
    <div id="rgb">RGB: <input type="text"></input></div>
</div>
<script type="text/javascript">
	var canvas = document.getElementById('canvas_picker').getContext('2d');

	// create an image object and get it’s source
	var img = new Image();
	img.src = 'colorwheel.png';

	// copy the image to the canvas
	$(img).load(function(){
	  canvas.drawImage(img,0,0);
	});

	// http://www.javascripter.net/faq/rgbtohex.htm
	function rgbToHex(R,G,B) {return toHex(R)+toHex(G)+toHex(B)}
	function toHex(n) {
	  n = parseInt(n,10);
	  if (isNaN(n)) return "00";
	  n = Math.max(0,Math.min(n,255));
	  return "0123456789ABCDEF".charAt((n-n%16)/16)  + "0123456789ABCDEF".charAt(n%16);
	}
	$('#canvas_picker').click(function(event){
	  // getting user coordinates
	  var x = event.pageX - this.offsetLeft;
	  var y = event.pageY - this.offsetTop;
	  // getting image data and RGB values
	  var img_data = canvas.getImageData(x, y, 1, 1).data;
	  var R = img_data[0];
	  var G = img_data[1];
	  var B = img_data[2];
      var rgb = R + ',' + G + ',' + B;
	  // convert RGB to HEX
	  var hex = rgbToHex(R,G,B);
	  // making the color the value of the input
	  $('#rgb input').val(rgb);
	  $('#hex input').val('#' + hex);

      var r_light = Math.round((R*100)/255);
      var g_light = Math.round((G*100)/255);
      var b_light = Math.round((B*100)/255);
    //   console.log(g_light);
      var xhr = new XMLHttpRequest();
      xhr.open('GET', "http://192.168.0.157/arduino/rgb/".concat(r_light.toString(),"/",g_light.toString(),"/",b_light.toString()), true);
      xhr.send();

    });
</script>

</body>
</html>
