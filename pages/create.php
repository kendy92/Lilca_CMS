<?
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['login_status'])){
    header("Location: index.php");
    }

    if(isset($_POST['btnSubmit'])){
        $posts = $cms->getColumns($cms->protectField($_GET['table_name']));
        $v = "";
        $c = "";
        $post_data;
        for($i=1; $i< count($posts); $i++){
            $post_data = $cms->protectField($_POST[$posts[$i]]);
                if($i != 0){
                if($i != (count($posts)-1)){
                    $c .= "".$posts[$i].", ";
                    $v .= "'".$cms->protectField($_POST[$posts[$i]])."', ";
                }else{
                    $c .= "".$posts[$i]."";
                    $v .= "'".$cms->protectField($_POST[$posts[$i]])."'";
                }
            }
        }
        $query = "INSERT INTO ".$cms->protectField($_GET['table_name'])."(".$c.") VALUES(".$v.")";
        if(strlen($post_data) > 0){
                    $cms->exeQuery($query);
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>New Data created successfully!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
        }else{
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Please complete all fields to proceed<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
        }
    }


?>
<form id="ActionFrm" method="post">
  <div>
    <h1><?php echo  $_GET['table_name'];?></h1>
  </div>
<?php
        if(isset($_GET['table_name'])){
          $get_table_name = $cms->protectField($_GET['table_name']);

          $rows = $cms->getColumns($get_table_name);
          for($i = 1 ; $i < count($rows); $i++){
              $data_type = $cms->getDataTypeOfCol($get_table_name,$rows[$i]);
              if($data_type[0] == "text"){
                  echo "<div class='form-group'>
                  <label for='".$rows[$i]."'>".$rows[$i]."</label>
                  <textarea class='form-control summernote' name='".$rows[$i]."' id='".$rows[$i]."'>";
                  echo "</textarea></div>";
              } else if($data_type[0] == "date" || $data_type[0] == "datetime") {
                echo "<div class='form-group'>
                <label for='".$rows[$i]."'>".$rows[$i]."</label>
                <input type='text' class='form-control datepicker' name='".$rows[$i]."' id='".$rows[$i]."'/></div>";
              } else {
                  echo "<div class='form-group'>
                  <label for='".$rows[$i]."'>".$rows[$i]."</label>
                  <input type='text' class='form-control' name='".$rows[$i]."' id='".$rows[$i]."'/></div>";
              }
          }
        }
?>
      <input type="submit" class="btn btn-warning" name="btnSubmit" id="btnSubmit" value="CREATE"/>
      <a href="?page=action&table=<?php echo $get_table_name; ?>&token=<?php echo md5($get_table_name); ?>" class="btn btn-info">GO BACK</a>
</form>
