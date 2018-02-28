<?php
if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['login_status'])){
    header("Location: index.php");
}
    if(isset($_GET['table']) && isset($_GET['token'])){
        if($_GET['token'] == md5($_GET['table'])){
            $table_name = $_GET['table'];

        }else{
            header("Location: index.php");
        }
    }

?>
<h2><i class="fa fa-table" aria-hidden="true"></i> <?php echo $table_name; ?></h2>
    <div class="err_msg">

    </div>
    <div class="row" style="margin:1em 0;">
      <div class="col-lg-6 col-md-6">
        <a href="?page=create&table_name=<?php echo $table_name; ?>" class="btn btn-success">Create New <i class="fas fa-plus"></i></a>
      </div>

      <div class="col-lg-6 col-md-6">
        <form id="ActionFrm" class="form-inline" method="post" action="?page=view&table_name=<?php echo $cms->protectField($_GET['table']); ?>">
          <input class="form-control mr-sm-2" name="search_val" id="search_val" type="search" placeholder="Enter ID to search" aria-label="Search" value=""/>
          <input class="btn btn-dark my-2 my-sm-0" id="btnSearch" type="submit" value="Find"/>
        </form>

      </div>
    </div>


    <table class="table details table-striped table-dark table-hover">
      <thead>
        <tr>
          <?php
            $count_title = 0;
            $cols_name = $cms->getColumns($table_name);
            foreach($cols_name as $col_name) {
              $count_title++;
              echo "<td>".$col_name."</td>";
              if($count_title >= 2) break;
            }
          ?>
          <td>ACTION</td>
        </tr>
      </thead>
      <tbody>
        <?php
          $count_data = 0;
          $query = "SELECT * FROM ".$table_name." ORDER BY id DESC";
          $cms->connectDB();
          mysqli_query($cms->conn, "SET NAMES utf8");
          $cmd = mysqli_query($cms->conn,$query);
          while($row = mysqli_fetch_row($cmd)){
            echo "<tr>
            <td>".$row[0]."</td>
            <td>".$row[1]."</td>
            <td>
            <a href='?page=view&id=".$row[0]."&table_name=".$table_name."' class='btn btn-info' id='btnView'>View</a>
            <a href='?page=update&id=".$row[0]."&table_name=".$table_name."' class='btn btn-secondary' id='btnEdit'>Edit</a>
            <a href='?page=delete&id=".$row[0]."&table_name=".$table_name."' class='btn btn-danger' id='btnDelete'>Delete</a>
            </td>
            </tr>";
          }
          $cms->closeDB();
         ?>
      </tbody>
    </table>

<script type="text/javascript">


  document.querySelector("#btnSearch").onclick = function() {
    var search_val = document.getElementById("search_val").value;
    if(search_val.length <= 0){
        alert('Please enter ID to search!');
        return false;
    }else{
      return true;
    }
  }
    document.getElementById("btnDelete").onclick = function(){
    var opt = confirm("Are you sure to delete it?");
    return opt === false ? false : true;
  }
</script>
