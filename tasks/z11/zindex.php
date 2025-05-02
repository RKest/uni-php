<div id="layer1" style="position:absolute;width:150px;height:150px;
	background-color:yellow;left:100px;top:100px;visibility:visible;">
	Yellow
</div>
<div id="layer2" style="position:absolute;width:100px;height:100px;
	background-color:orange;left:70px;top:130px;visibility:visible;">
	Orange
</div>
<div id="layer3" style="position:absolute;width:100px;height:100px;
	background-color:red;left:130px;top:160px;visibility:visible;">
	Red
</div>
<div id="layer4" style="position:absolute;width:100px;height:100px;
	background-color:blue;left:160px;top:90px;visibility:visible;">
	Blue
</div>
<div>
	<input type="radio" name="rd1" onclick="ontop('layer1');">Yellow
	<input type="radio" name="rd1" onclick="ontop('layer2');">Orange
	<input type="radio" name="rd1" onclick="ontop('layer3');">Red
	<input type="radio" name="rd1" onclick="ontop('layer4');">Blue
</div>
<script>
function ontop(id)
{
	document.getElementById('layer1').style.zIndex = 0;
	document.getElementById('layer2').style.zIndex = 0;
	document.getElementById('layer3').style.zIndex = 0;
	document.getElementById('layer4').style.zIndex = 0;
	document.getElementById(id).style.zIndex = 1;
}
</script>
