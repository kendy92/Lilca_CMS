<?
  if(!isset($_SESSION)){
          session_start();
      }
      if(!isset($_SESSION['login_status'])){
      header("Location: index.php");
  }
  if(isset($_GET['table_name'])){
    $id = 0;
    if(isset($_GET['id'])){
      $id = $_GET['id'];
    }else if(isset($_POST['search_val']) && !empty($_POST['search_val'])){
      $id = $_POST['search_val'];
    }else{
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Please enter ID to reference the search<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span></button></div>";
    }
    $query = "SELECT * FROM ".$cms->protectField($_GET['table_name'])." WHERE id=".$cms->protectField($id);
    $posts = $cms->getRows($query);
    $cols = $cms->getColumns($cms->protectField($_GET['table_name']));
    for($i = 0 ; $i < count($cols); $i++){
      echo "<div>
            <p style='text-align:justify;'><span style='font-weight:bold;text-transform:uppercase; padding-right:.2em;'>".$cols[$i].":</span> ".$posts[$i]."</p>
           </div>";
    }
    echo "
        <div>
          <a href='?page=update&id=".$id."&table_name=".$_GET['table_name']."' class='btn btn-secondary'>Edit</a>
          <a href='?page=delete&id=".$id."&table_name=".$_GET['table_name']."' class='btn btn-danger'>Delete</a>
          <a class='btn btn-info' href='?page=action&table=".$_GET['table_name']."&token=".md5($_GET['table_name'])."'>Go Back</a>
        </div>
    ";
  }
?>
