<html>
	<head>
		<title>
		</title>
	</head>
	<body> 
		<script src="../colorchain.js">
		</script>
		<div id="element"></div>
		<script>
			start();
               var colors = [
                    ['9400D3', 'FFFFFF'], ['FF7F00', '000000'],
                    ['00FF00', '000000'], ['FF7F00', '000000'],
                    ['FFFF00', '000000'], ['4B0082', 'FFFFFF'],
                    ['00FF00', '000000'], ['0000FF', 'FFFFFF'],
                    ['FFFF00', '000000'], ['FF0000', 'FFFFFF']];
			var index=0;
			var job;
			function start(){
				//colors = ColorSequenceGenerator.createColorSequence(50, {lightnessStart:80, saturationStart:70, randomHueOffset: true}).getColors();
				//alert(colors);
				job = setInterval(function(){
					var string = '<p style="background-color:'+colors[index][0]+';color:'+colors[index][1]+';">'
                                                +(index+219)+' -- '+colors[index][1]+'</p>';
					document.getElementById("element").innerHTML +=string;
					console.log(colors[index]);
					index++;
					if(index==colors.length){
						clearInterval(job);
					}
				},100);
			}
		</script>
	</body>
</html>

