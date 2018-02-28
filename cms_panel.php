<?
if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['login_status'])){
    header("Location: index.php");
}

  require "system.php";
  $cms = new LILCA_CMS();
?>
<!doctype html>
<html>
    <?php include("meta/header.php"); ?>
    <body>
        <div id="wrap-container">
            <header class="header">
                <div class="row">
                    <h1 class="col-lg-9">LILCASOFT CMS PANEL</h1>
                    <div class="col-lg-3">
                    <p>Welcome back <img class="profile-pic" src="images/user6.png"></p>
                    </div>
                </div>
            </header>
            <main class="container-fluid">
                <div class="row">
                    <aside id="dashboard" class="col-lg-3">
                    <h2><i class="fa fa-desktop" aria-hidden="true"></i> &nbsp;DASHBOARD</h2>
                    <ul class="dashboard-menu">
                        <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Home Page</a></li>
                        <li><a href="?page=terminal"><i class="fas fa-terminal"></i>&nbsp;Advance Terminal</a></li>
                        <li class="dropdown"><a href="#"><i class="fas fa-database"></i>&nbsp;Modules&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <ul>
                        <?php
                            $tables = $cms->getTables();
                            for($i =0; $i< count($tables); $i++){
                                if($tables[$i] != 'cms_table'){
                                    $token = md5($tables[$i]);
                                    echo "<li><a href='?page=action&table=".$tables[$i]."&token=".$token."'>".$tables[$i]."</a></li>";
                                }
                            }


                        ?>
                                </ul>
                        </li>
                        <li><a href="?page=upload"><i class="fas fa-cloud-upload-alt"></i>&nbsp;Upload Images</a></li>
                        <li><a href="?page=logout"><i class="fas fa-sign-out-alt"></i>&nbsp;Sign out</a></li>
                        </ul>
                </aside>
                <div class="content col-lg-9">
                    <?php $homepage = "pages/main.php";
                        if(!empty($_GET['page'])){
                            $page = $_GET['page'];
                            $dir = "pages/";
                            $target_page = $dir.$page.".php";
                            if(!file_exists($target_page)){
                                include($homepage);
                            }else{
                                include($target_page);
                            }
                        }else{
                            include($homepage);
                        }
                    ?>
                </div>
                </div>
            </main>
            <footer class="footer">
                <p>Powered By LilcaSoft <?php echo date("Y"); ?></p>
            </footer>
        </div>
    </body>
</html>
