<?php
require_once "pdo.php";
require_once "helpers.php";
session_start();

# alerts
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
//~ if ( isset($_SESSION['success']) ) {
    //~ echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    //~ unset($_SESSION['success']);
//~ }
# logout
if (isset($_POST['X'])){
    session_destroy();
    header( 'Location: index.php' ) ;
    return;
}
# login
if ( isset($_POST["account"]) && isset($_POST["pw"]) ) {
    unset($_SESSION["account"]);  // Logout current user
    $l = file_get_contents("/etc/php_pw.json");
    $l = json_decode($l, true);
    if ( $_POST['account'] == $l['USER_NAME'] && 
    (password_verify($_POST['pw'], $l['USER_PW']))){
        $_SESSION["account"] = $_POST["account"];
        $_SESSION["success"] = "Logged in.";
        header( 'Location: index.php' ) ;
        return;
    } else {
        $_SESSION["error"] = "Incorrect password.";
        header( 'Location: index.php' ) ;
        return;
    }
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
# delete event
if ( isset($_POST['delEvent']) ) {
    $sql = "DELETE FROM lt WHERE id = :delEvent";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':delEvent' => $_POST['delEvent']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

echo(make_head());
?>

<div class='container-fluid'>

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
      
      <div class="modal-footer">
        <form method='post'>
            <input id='delEvent' type='hidden' name='delEvent'>
            <input type="submit" class="btn btn-danger" value='Delete event'>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<?php
if ( ! isset($_SESSION["account"]) ) { ?>
<!-- need to login -->
    <form method="post">
    <p>Account: <input type="text" name="account" value=""></p>
    <p>Password: <input type="password" name="pw" value=""></p>
    <p><input type="submit" value="Log In">
    </form>
<?php } else { ?>
<!-- normal view -->
    <div style='position: fixed; top:0px; right: 0px'>
        <form method='post'>
            <input type='submit' class='btn btn-warning' value='X' name='X'>
            </form>
    </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEventModal">
      Add Event
    </button>
    <span style='padding-right: 50px;'></span>
    <label class="radio-inline"><input type="radio" name="optradio" checked>W</label>
    <label class="radio-inline"><input type="radio" name="optradio">M</label>
    <label class="radio-inline"><input type="radio" name="optradio">A</label>

    <script>
    $('input[type=radio][name=optradio]').change(function() {
        make_plot();
    });
    </script>
    <!-- make plot -->
    <div id='myDiv' style='height: 85vh; width: 100%'></div>
    <script>
    $(document).ready(function(){
        make_plot();
    });
    </script>
<?php } ?>

<?php
echo(make_tail());
?>
