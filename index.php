<?php
require_once "pdo.php";
require_once "helpers.php";
session_start();

# alerts
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
# post
if ( isset($_POST['item']) && isset($_POST['date']) ) {
    $sql = "INSERT INTO lt (item, date) VALUES (:item, :date)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':item' => $_POST['item'],
        ':date' => $_POST['date']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;
}

echo(make_head());
?>

<div class='container-fluid'>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEventModal">
  Add Event
</button>

<!-- Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add an event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div style="padding: 20px">
        <form method='post'>
            <div class='form-group'>
                <p>Event name: <input class='form-control' type='text' name='item' required></p>
            </div>
            <div class='form-group'>
                <input class='form-control' type='date' name='date' required>
            </div>
           <input class='btn btn-primary' type='submit' value='Add'>
        </form>
      </div>

    </div>
  </div>
</div>

<div id='myDiv' style='height: 95vh; width: 100%'></div>

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
