<?
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['login_status'])){
    header("Location: index.php");
    }

    if(isset($_POST['btnSubmit'])){
      $posts = $cms->getColumns($_GET['table_name']);
        $v = "";
        $post_data;
        for($i=0; $i< count($posts); $i++){
            $post_data = $cms->protectField($_POST[$posts[0]]);
            if($i != 0){
                if($i != count($posts)-1){
                $v .= "".$posts[$i]."= '".$_POST[$posts[$i]]."', ";
                }else{
                    $v .= "".$posts[$i]."= '".$_POST[$posts[$i]]."'";
                }
            }
        }

        $query = "UPDATE ".$cms->protectField($_GET['table_name'])." SET ".$v." WHERE id=".$cms->protectField($_GET['id']);

        if(strlen($post_data) > 0){
            $cms->exeQuery($query);
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>Data ID ".$_POST['id']." is updated successfully.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
        }else{
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Please enter ID to reference the update process.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
        }
    }

?>
<form id="ActionFrm" method="post">
  <div>
    <h1><?php echo  $_GET['table_name'];?></h1>
  </div>
<?php
        if(isset($_GET['table_name']) && ($_GET['id'])){
          $get_table_name = $cms->protectField($_GET['table_name']);
          $get_id = $cms->protectField($_GET['id']);

          if(strlen($get_id) <= 0){
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Please enter ID to reference the search<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
          }else{
            $query = "SELECT * FROM ".$get_table_name." WHERE id=".$get_id;
            $data = $cms->getRows($query);
          }



          $rows = $cms->getColumns($get_table_name);
          for($i = 0 ; $i < count($rows); $i++){
              $data_type = $cms->getDataTypeOfCol($get_table_name,$rows[$i]);
              if($data_type[0] == "text"){
                  echo "<div class='form-group'>
                  <label for='".$rows[$i]."'>".$rows[$i]."</label>
                  <textarea class='form-control summernote' name='".$rows[$i]."' id='".$rows[$i]."'>";
                  if(isset($data[$i])){
                      echo $data[$i];
                  }
                  echo "</textarea></div>";
              }else{
                  echo "<div class='form-group'>
                  <label for='".$rows[$i]."'>".$rows[$i]."</label>
                  <input type='text' class='form-control' name='".$rows[$i]."' id='".$rows[$i]."' value='";
                  if(isset($data[$i])){
                      echo $data[$i];
                  }
                  echo "'></div>";
              }
          }
        }
?>
      <input type="submit" class="btn btn-warning" name="btnSubmit" id="btnSubmit" value="UPDATE"/>
      <a href="?page=action&table=<?php echo $get_table_name; ?>&token=<?php echo md5($get_table_name); ?>" class="btn btn-info">GO BACK</a>
</form>
