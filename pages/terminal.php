<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['login_status'])){
    header("Location: index.php");
    }
    $err_msg = "";
    if(isset($_POST['btnSubmit'])){
      if(isset($_POST['cmd']) && !empty($_POST['cmd'])){
        $query = $_POST['cmd'];
        $results = $cms->terminal($query);
        var_dump($results);
        if($results == false){
          $err_msg = "<span style='color:red; font-weight:bold;'>Failed to execute!</span>";
        }else{
          $err_msg = "<span style='color:green; font-weight:bold;'>Query Passed!</span>";
        }
      }else{
        $err_msg = "<span style='color:red; font-weight:bold;'>No Query Found!</span>";
      }
    }
?>

<form action="#" method="post">
  <fieldset>
    <legend><h1><i class="fas fa-terminal"></i></h1></legend>
    <div class="err_msg"><?php echo $err_msg; ?></div>
  <div class="form-control">
    <label for=""></label>
    <textarea style="width:100%;" id="cmd" name="cmd" rows="10" placeholder="You can perform CREATE, INSERT, DELETE, UPDATE to your DB by typing a SQL Query here..."></textarea>
  </div>
  <div style="margin-top:1em;">
    <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-success" value="EXECUTE"/>
  </div>
  </fieldset>
</form>
