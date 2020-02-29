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
# new event
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
# update event
if ( isset($_POST['editItem']) && isset($_POST['editDate']) && isset($_POST['eID']) ) {
    # delete old record
    $sql = "UPDATE lt SET item = :editItem, date = :editDate WHERE id = :eID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':editItem' => $_POST['editItem'],
        ':editDate' => $_POST['editDate'],
        ':eID' => $_POST['eID'])
    );
    
    $_SESSION['success'] = 'Event updated!';
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

<!-- Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalTitle">Edit an event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div style="padding: 20px">
        <form method='post'>
            <div class='form-group'>
                <p>Event name: <input class='form-control' id='eName' type='text' name='editItem' required></p>
            </div>
            <input id='eID' type="hidden" name='eID'>
            <div class='form-group'>
                <input class='form-control' id='eDate' type='date' name='editDate' required>
            </div>
           <input class='btn btn-primary' type='submit' value='Update'>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- make plot -->
<div id='myDiv' style='height: 95vh; width: 100%'></div>
<script>
$(document).ready(function(){
  $.getJSON('getjson.php', function(rows) {
    y = [];
    txt = [];
    id = [];
    for (var i = 0; i < rows.length; i++) {
      row = rows[i];
      y.push(row['date']);
      txt.push(row['item']);
      id.push(row['id']);
    }
    l = make_plot(y, txt, id);
    var myDiv = document.getElementById('myDiv');
    Plotly.newPlot('myDiv', l[0], l[1], l[2]);
    myDiv.on('plotly_click', function (data) {
        e = data.points[0];
        console.log(e.customdata);
        $('#editModalTitle').html('Update event: ' + e.text);
        $('#eName').val(e.text);
        $('#eDate').val(e.y);
        $('#eID').val(e.customdata);
        $('#editEventModal').modal('toggle');
    });
  });
});
</script>

<?php
echo(make_tail());
?>
