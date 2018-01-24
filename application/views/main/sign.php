<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Signature Pad demo</title>
  <meta name="description" content="Signature Pad - HTML5 canvas based smooth signature drawing using variable width spline interpolation.">

  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link rel="stylesheet" href="/assets/css/s.css">
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body onselectstart="return false">  
	<img src="/sign/sample.PNG">
	<button onclick="showSign()">사인할래요</button>
  <div id="signature-pad" class="m-signature-pad">
    <div class="m-signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="m-signature-pad--footer">
      <div class="description">서명 부탁드립니다</div>
    
      <div class="left">
        <button type="button" class="button clear" data-action="clear">Clear</button>
      </div>
      <div class="right">
        <button type="button" class="button save" data-action="save-png">Save as PNG</button>
        <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
      </div>
    </div>
  </div>

  <script src="/assets/js/spad.js"></script>
  <script src="/assets/js/app.js"></script>
  <script>
	function showSign(){
		$('#signature-pad').show();
	};
  </script>
</body>
</html>