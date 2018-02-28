<?php
if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['login_status'])){
    header("Location: index.php");
}

if(isset($_POST['btnUpload'])){
    require "system.php";
    $cms = new LILCA_CMS();
    if(isset($_FILES['my_files'])){
        $count = 0;
        $files = $_FILES['my_files'];
        $folder = $_POST['folder'];
        if($files["error"][0] == 0){ //no error then proceed image upload
            $count_files = count($files['name']);
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='close'>
            <span aria-hidden='true'>&times;</span></button>
            <p>Upload ".$count_files." files success!</p><br>";
            for ($i=0; $i < $count_files; $i++) {
                //upload files
                $count++;
                move_uploaded_file($files['tmp_name'][$i], $cms->domain."".$folder.'/'.$files['name'][$i]);
                $img_path = $folder."/".$files['name'][$i];
                echo "LINK: <strong>".$i.": ".$img_path."</strong><br>";
            }
            echo "</div>";

        }else{
            echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='close'>&times;</button>Please browse to files upload</div>";
        }
    }else{
            echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='close'>&times;</button>Please browse to files upload</div>";
        }
}
?>
