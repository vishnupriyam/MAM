<?php 
?>
<?php
 
$orgId = $model->orgId;
$categoryId = $model->categoryId;
$file = $model->file;
$assetid=$model->assetId;

// here we are getting an extention of file so that we can categorise  file for dispay.

if(($pos=strrpos($file,'.'))!==false)
	$ext=substr($file,$pos+1);
 $b = "http://localhost/final/Viewer.js/#../upload/".$orgId."/".$model->categoryId."/".$assetid.".".$ext;
?> 

<?php  
 //echo $a;
?>

<?php 
  $a = "http://localhost/final/upload/".$orgId.'/'.$categoryId.'/'.$assetid.'.'.$ext;
  
  // here we are getting an extention of file for inspecting image formate
  if(($pos=strrpos($file,'.'))!==false)
  $ext=substr($file,$pos+1);
 ?>
 <?php 	
  if ($ext == 'jpg' || $ext == 'gif' || $ext == 'png' || $ext == 'bmp'): 
 ?>  
 <?php 
  $a = "http://localhost/final/upload/".$orgId.'/'.$categoryId.'/'.$assetid.'.'.$ext;
   
  
  ?>
  <img id = "image" src = "<?php echo $a;?>"> 
  
  <?php elseif ($ext == 'mp4' || $ext == 'flv' || $ext == 'ogg' || $ext == 'webm' || $ext == 'mp3' || $ext == 'wav'):
	?>
   <?php 
  //$a = "http://localhost/final/upload/".$orgId.'/'.$categoryId.'/'.$file;
  
  ?><?php   
 
   $this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $a,   
     'mimeType' =>'video/mp4',
    ));
    ?><?php 
   elseif ($ext == 'pdf' || $ext == 'odt' || $ext == 'odp'): ?>
  <iframe id="viewer" src = "<?php echo $b;?>"
  width='800' height='500' allowfullscreen webkitallowfullscreen></iframe>
  
  <?php else:?>
  
  <?php endif;?>
 
 
 
 
 
<?php  
  ?>