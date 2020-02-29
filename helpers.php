<?php
function make_head() {
    return "
<!DOCTYPE html>
<html>
<head>
	<script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
    <script src='www/js.js'></script>
</head>
<body>
";
}
function make_tail() {
    return "
</body>
</html>
";
}
?>
