
<div id="layer1" style="position:absolute;width:100px;height:100px;background-color:yellow;left:50px;top:100px;visibility:visible;"></div>
<div id="layer2" style="position:absolute;width:100px;height:100px;background-color:red;left:150px;top:100px;visibility:visible;"></div>
<div id="layer3" style="position:absolute;width:100px;height:100px;background-color:blue;left:250px;top:100px;visibility:visible;"></div>
<div id="layer4" style="position:absolute;width:100px;height:100px;background-color:brown;left:350px;top:100px;visibility:visible;"></div>
<div>
	<input type="checkbox" class="btn-check" id="btn-check-outlined1" autocomplete="off" onclick="ToggleLayer1()";>
	<label class="btn btn-outline-primary" for="btn-check-outlined1">Layer 1</label>
	<input type="checkbox" class="btn-check" id="btn-check-outlined2" autocomplete="off" onclick="ToggleLayer2()";>
	<label class="btn btn-outline-primary" for="btn-check-outlined2">Layer 2</label>
	<input type="checkbox" class="btn-check" id="btn-check-outlined3" autocomplete="off" onclick="ToggleLayer3()";>
	<label class="btn btn-outline-primary" for="btn-check-outlined3">Layer 3</label>
	<input type="checkbox" class="btn-check" id="btn-check-outlined4" autocomplete="off" onclick="ToggleLayer4()";>
	<label class="btn btn-outline-primary" for="btn-check-outlined4">Layer 4</label>
</div>

<script>
function ToggleLayer1() { 
	var x = document.getElementById('layer1');
	if (x.style.visibility === 'hidden') { x.style.visibility = 'visible'; } 
	else { x.style.visibility = 'hidden'; }
}
function ToggleLayer2() { 
	var x = document.getElementById('layer2');
	if (x.style.visibility === 'hidden') { x.style.visibility = 'visible'; } 
	else { x.style.visibility = 'hidden'; }
}
function ToggleLayer3() { 
	var x = document.getElementById('layer3');
	if (x.style.visibility === 'hidden') { x.style.visibility = 'visible'; } 
	else { x.style.visibility = 'hidden'; }
}
function ToggleLayer4() { 
	var x = document.getElementById('layer4');
	if (x.style.visibility === 'hidden') { x.style.visibility = 'visible'; } 
	else { x.style.visibility = 'hidden'; }
}
</script>
