<!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="stickers.css">

<style>
    .spinner {
  margin: 100px auto 0;
  width: 70px;
  text-align: center;
}

.spinner > div {
  width: 18px;
  height: 18px;
  background-color: #333;

  border-radius: 100%;
  display: inline-block;
  -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}

.spinner .bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}

.spinner .bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}

@-webkit-keyframes sk-bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0) }
  40% { -webkit-transform: scale(1.0) }
}

@keyframes sk-bouncedelay {
  0%, 80%, 100% { 
    -webkit-transform: scale(0);
    transform: scale(0);
  } 40% { 
    -webkit-transform: scale(1.0);
    transform: scale(1.0);
  }
}
</style>
<?php
if (!isset($_COOKIE['slogin'])) {
			header('Location:login.php',true);
} else if ($_COOKIE['slogin'] != "admin") {
			header('Location:login.php?admin=true',true);
} 
?>
<script>
    function reset() {
      var xmlHttp = new XMLHttpRequest();
					xmlHttp.open( "GET", "stickerfunctions.php?reset=true",false );
					xmlHttp.send( null );
					console.log(xmlHttp.responseText);
        if (xmlHttp.responseText.indexOf("Reset Complete")>=0){
				  document.getElementById("reset").innerHTML ='<p> Reset Complete </p>';
			}
    }
    
    function resetStickers() {
		  document.getElementById("reset").innerHTML ='<p> Reset in progress </p><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
      reset();
    }  
</script>
</head>
<body>
	
<div id="reset">
	<button onclick="resetStickers()"> Reset </button>
</div>

</body>

</html>