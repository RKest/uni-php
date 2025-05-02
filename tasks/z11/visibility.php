<div id="layer1" style="position:absolute;width:100px;height:100px;
	background-color:yellow;left:50px;top:150px;visibility:visible;">
</div>
<div id="layer2" style="position:absolute;width:100px;height:100px;
	background-color:brown;left:150px;top:150px;visibility:hidden;">
</div>
<div id="layer3" style="position:absolute;width:100px;height:100px;
	background-color:red;left:250px;top:150px;visibility:hidden;">
</div>
<div>
	<input type="radio" name="rd1" onclick="myShowLayer('layer1');" checked>yellow
	<input type="radio" name="rd1" onclick="myShowLayer('layer2');">brown
	<input type="radio" name="rd1" onclick="myShowLayer('layer3');">red
</div>

<script>
function myShowLayer(id)
{
	document.getElementById('layer1').style.visibility = "hidden";
	document.getElementById('layer2').style.visibility = "hidden";
	document.getElementById('layer3').style.visibility = "hidden";
	document.getElementById(id).style.visibility = "visible";
}
</script>
