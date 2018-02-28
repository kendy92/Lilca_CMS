<?php
if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['login_status'])){
    header("Location: index.php");
}
?>

<div class="container">
   <h4 class="text-center">UPLOAD IMAGE TO HOSTING</h4>
   <p style="font-size:medium;">Please set your MOD folder images to 777 to avoid error</p>
   <p style="font-size:medium;">Please upload image file only: jpg,png,jpeg,gif</p>
   <div id="status"></div>

    <form method="post" action="upload-progress.php" name="upload_form" id="upload_form" enctype="multipart/form-data">
    <div class="form-group">
        <input type="file" class="form-control" name="my_files[]" multiple>
        </div>
        <div class="form-group">
        <label>Where to save:</label>
        <select name="folder" id="folder" class="form-control">
        <?php
            $folders = array();
            $folders = $cms->img_folders;
            for($i=0; $i< count($folders); $i++){
                echo "<option value='".$folders[$i]."'>".$folders[$i]."</option>";
            }
        ?>
        </select>
        </div>
        <input type="submit" onclick='upload_image();' class="btn btn-primary" name="btnUpload" value="Upload"/>
    </form>

    <!-- PROGRESS BAR -->
<div class="progress" style="display:none;width: 50%;margin: 0 auto;">
  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
     <div id='percent'></div>
  </div>
</div>
 <div id="status"></div>
 <!-- END -->

</div>
<!-- Latest compiled and minified JavaScript -->

<script>

 $(function() {
 $(document).ready(function(){
 var bar = $('.progress-bar')
 var percent = $('#percent');
 var status = $('#status');

 $('form').ajaxForm({
 beforeSend: function() {
 status.empty();
 var percentVal = '0%';
 bar.width(percentVal);
 percent.html(percentVal);
 },
 uploadProgress: function(event, position, total, percentComplete) {
  $('.progress').show();
 var percentVal = percentComplete + '%';
 percent.html(percentVal);
 bar.width(percentVal);
 },
 complete: function(data) {
  $('.progress').delay(1000).fadeOut('slow');
 status.html(data.responseText);
 }
 });
 });
 });
 </script>
