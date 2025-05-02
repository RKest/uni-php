<div class="rotate">1</div> <br/>
<div class="rotate">2</div> <br/>
<div class="donot_rotate">3</div> <br/>
<div class="rotate r4">4</div> <br/>
<div class="rotate r5">5</div> <br/>

<style>
.rotate
{
	width: 50px; 
	height: 50px; 
	background-color: red; 
	margin: 10px;
	float: left;
	transform: translate(-15px,90px) scale(2);
	transform-origin:0 100%;
	transition: all 2s ease;
}
.rotate:hover { 
	background-color: black; 
	transform: translate(-15px,0px) scale(1) rotate(50deg); 
}
.donot_rotate{ 
	width: 50px;
	height: 50px;
	background-color: yellow; 
	margin: 10px;
	float: left;
}

.r4 {
	background-color: green;
}

.r5 {
	background-color: blue;
}

.r4:hover { 
	transform: translate(-15px,0px) scale(1) rotate(360deg); 
}

.r5:hover { 
	transform: translate(-15px,0px) scale(1) rotate(720deg); 
}
</style>
