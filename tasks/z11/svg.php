<link rel="stylesheet" type="text/css" href="/tasks/z11/face.css">

background-image<br/><br/>
<div> <p>img src</p> <img src="/tasks/z11/face.svg"/> </div>
<div> <p>php1</p> <?php echo file_get_contents(__DIR__ ."/face.svg"); ?> </div>
<div> <p>php2</p> <?php readfile(__DIR__. "/face.svg"); ?> </div>
<div> <p>object</p> <object type="image/svg+xml" data="/tasks/z11/face.svg"></object> </div>
<div>
<p>iframe</p>
<iframe src="/tasks/z11/face.svg" scrolling="no" style="border:1px solid black;overflow:hidden;height:63;width:42;"></iframe>
</div>
