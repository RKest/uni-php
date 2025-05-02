
<div id="layer4" style="position:absolute;left:0px;top:150px;visibility:visible;">
	<svg width="100" height="200">
		<circle cx="30" cy="30" r="20" stroke="red" stroke-width="4" fill="yellow" />
		<text fill="black" font-size="14" font-family="Verdana" x="15" y="34">L4</text>
	</svg>
</div>
<div id="layer5" style="position:absolute;left:100px;top:150px;visibility:hidden;">
	<svg width="50" height="40">
		<rect width="50" height="40" style="fill:yellow;stroke-width:4;stroke:red" />
		<text fill="black" font-size="15" font-family="Verdana" x="10" y="20">L5</text>
	</svg>
</div>
	<div id="layer6" style="position:absolute;left:0px;top:150px;visibility:hidden;">
		<svg width="100" height="100">
		<rect x="5" y="5" rx="20" ry="20" width="50" height="50" style="fill:yellow;stroke:black;stroke-width:2;">
			<animate attributeType="CSS" attributeName="opacity" from="1" to="0" dur="5s" repeatCount="indefinite" />
		</rect>
	<text fill="black" font-size="14" font-family="Verdana" x="15" y="25">L6</text>
</svg>
</div>
	<div id="layer7" style="position:absolute;left:200px;top:150px;visibility:hidden;">
	<svg height="100" width="150">
<defs>
	<linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
		<stop offset="0%" style="stop-color:rgb(255,255,0);stop-opacity:1" />
		<stop offset="100%" style="stop-color:rgb(255,0,0);stop-opacity:1" />
	</linearGradient>
</defs>
	<ellipse cx="100" cy="70" rx="45" ry="25" fill="url(#grad1)" />
	<text fill="black" font-size="22" font-family="Verdana" font-weight="bold" x="70" y="77">L7</text>
</svg>
</div>
<div>
	<input type="radio" name="rd1" onclick="myShowLayer('layer4');" checked>Circle
	<input type="radio" name="rd1" onclick="myShowLayer('layer5');">Rectangle
	<input type="radio" name="rd1" onclick="myShowLayer('layer6');">Rounded
	<input type="radio" name="rd1" onclick="myShowLayer('layer7');">Oval
</div>

<script>
function myShowLayer(id)
{
	document.getElementById('layer4').style.visibility = "hidden";
	document.getElementById('layer5').style.visibility = "hidden";
	document.getElementById('layer6').style.visibility = "hidden";
	document.getElementById('layer7').style.visibility = "hidden";
	document.getElementById(id).style.visibility = "visible";
}
</script>
