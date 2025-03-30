<?php
function deleteElem($cwd, $file) {
	return "
                <form style='margin: 0; display: inline-block;' hx-post='/tasks/z5/api/delete_ent.php' hx-target='closest li' hx-swap='outerHTML' 
                        hx-confirm='Are you sure you wish to delete $file'>
                        <input type='hidden' name='to-delete' value='$file'>
                        <input type='hidden' name='dir' value='$cwd'>
                        <input type='submit' value='delete'>
                </form>
	";
}

function fileElem($user, $cwd, $file) {
        return "<li><a href='/tasks/z5/uploads/$user/$cwd/$file' download>$file</a> " . deleteElem($cwd, $file) . "</li>";
}

function dirElem($name) {
        echo "<li>
                <form style='margin: 0; display: inline-block;' hx-get='/tasks/z5/api/get_ents.php' hx-target='main' hx-swap='innerHTML'>
                        <input type='hidden' name='dir' value='$name'>
                        <input style='
                          background: none!important;
                          border: none;
                          padding: 0!important;
                          font-family: arial, sans-serif;
                          color: #069;
                          text-decoration: underline;
                          cursor: pointer;
                        ' type='submit' value='$name/'>
                </form>
                " . deleteElem('', $name) . "
        </li>";
}
?>
