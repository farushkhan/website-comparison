<!DOCTYPE html>
<html lang="en">
<head>
  <title>Website Comparison</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/style.css'); ?>">
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Website Comparison</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
      </ul>
      
    </div>
  </div>
</nav>
  
<div class="container">    
  <div class="row">
    <div class="col-sm-4"> 
      <h3>The file is in v1 but not in v2</h3>
      <hr>
      <?php 
      $s_no = 1;
  foreach($list_1 as $values){
    if($values['message'] == "New File"){
    ?>
  <p><span class="s_no"><?php echo $s_no++; ?>. </span> <?php echo str_replace('v2/', '', $values['file']); ?></p>
  
  <?php 
}
}
  ?>
    </div>
    <div class="col-sm-4"> 
      <h3>The file is in v2 but not in v1</h3>
      <hr>
    <?php 
    $s_no = 1;
  foreach($list_2 as $values){
    if($values['message'] == "New File"){
    ?>
  <p><span class="s_no"><?php echo $s_no++; ?>. </span><?php echo str_replace('v1/', '', $values['file']); ?></p>
  
  <?php 
}
}
  ?>
    </div>
    <div class="col-sm-4"> 
      <h3>The file is in v1 and v2, but the content is not the same</h3>
      <hr>
    <?php 
    $s_no = 1;
  foreach($list_2 as $values){
    if($values['message'] == "Mis-Match"){
    ?>
  <p><span class="s_no"><?php echo $s_no++; ?>. </span><?php echo str_replace('v1/', '', $values['file']); ?></p>
  
  <?php 
}

}
  ?>
    </div>
    <div class="col-md-12">
      <h3>Differences in the files which are modified</h3>
      <hr>
    <?php 
  foreach($list_2 as $values){
    if($values['message'] == "Mis-Match"){
      $file = str_replace('v1', '', $values['file']);
      echo '<span class="s_no">'.$file.'</span>';
      echo '<br><div class="scroll">';
     echo Diff::toTable(Diff::compareFiles(getcwd()."/websites/v1".$file, getcwd()."/websites/v2".$file));
   echo '</div><br><br>';
    ?>  
  <?php 
}
}
  ?>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Website Comparioson</p>
</footer>

</body>
</html>
