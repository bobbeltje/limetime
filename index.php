<?php
require_once "pdo.php";
require_once "helpers.php";
session_start();

echo(make_head());

echo("<div id='myDiv' style='height: 95vh; width: 100%'></div>");
?>

<script>
$(document).ready(function(){
  $.getJSON('getjson.php', function(rows) {
    x = [];
    txt = [];
    for (var i = 0; i < rows.length; i++) {
      row = rows[i];
      x.push(row['item']);
      txt.push(row['date']);
    }
    make_plot(txt, x);
  });
});
</script>

<?php
echo(make_tail());
?>
