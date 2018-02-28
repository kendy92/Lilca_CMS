<?
if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['login_status'])){
    header("Location: index.php");
}

  if(isset($_GET['table_name']) && ($_GET['id'])){
    $get_table_name = $cms->protectField($_GET['table_name']);
    $get_id = $cms->protectField($_GET['id']);
    $query = "DELETE FROM ".$get_table_name." WHERE id = ".$get_id;
    $cms->exeQuery($query);

    echo "<div class='alert alert-success' role='alert'>
          Data with ID ".$get_id." deleted!
          </div>";
    echo "<a class='btn btn-info' href='?page=action&table=".$get_table_name."&token=".md5($get_table_name)."'>Go Back</a>";
  }
?>
