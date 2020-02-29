<?php
require_once "pdo.php";
require_once "helpers.php";
session_start();

echo(make_head());

echo("<div id='myDiv' style='height: 95vh; width: 100%'></div>");

echo("<script>
    make_plot(
      ['2020-01-01', '2020-02-27', '2020-08-03', '2020-11-04', '2020-04-25'],
      ['event a', 'something special', 'more speciality!', 'lunch', 'ww']
      )</script>");

echo(make_tail());
?>
