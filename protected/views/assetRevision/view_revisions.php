<?php 
?>
<?php
 
 //if ($model->revision) {
 $a = $model->assetId;
 $connection = Yii::app()->db;
 $sql3 = "select * from asset where assetId=:assetId";
 
 $command = $connection->createCommand($sql3);
 $command->bindParam(":assetId",$a,PDO::PARAM_INT);
 $dataReader = $command->query();
        $row = $dataReader->read();
        $dataReader->close();
        $categoryId = $row['categoryId'];
 $assetid = $row['assetId'];
 $file = $row['file'];
 $version = $model->revision;
 $file1 = $assetid.'_'.$version;
 //$file1 = $file1.'.dat';
 //$b = "http://localhost/final/Viewer.js/#../upload/".Yii::app()->user->getId()."/".$categoryId."/".$assetid.'/'.$file1;;
 	//print_r($b);
 	//die();

  if(($pos=strrpos($file,'.'))!==false)
  $ext=substr($file,$pos+1);
 ?> 
 <?php 
  $a = "http://localhost/final/upload/".$orgId.'/'.$categoryId.'/'.$assetid.'/'.$file1;
  
  if(($pos=strrpos($file,'.'))!==false)
  $ext=substr($file,$pos+1);
 ?>
 <?php 	
  if ($ext == 'jpg' || $ext == 'gif' || $ext == 'png' || $ext == 'bmp'): 
 ?>  
 <?php 
  
  $a = "http://localhost/final/upload/".$orgId.'/'.$categoryId.'/'.$assetid.'/'.$file1.'.'.$ext;
  
  ?>
  <img id = "image" src = "<?php echo $a;?>"> 
  
  <?php elseif ($ext == 'mp4' || $ext == 'flv' || $ext == 'ogg' || $ext == 'webm' || $ext == 'mp3' || $ext == 'wav'):
  ?>
  
  <?php 
  $a = "http://localhost/final/upload/".$orgId.'/'.$categoryId.'/'.$assetid.'/'.$file1.'.'.$ext;
  //print_r($a);
  //die();
  if(($pos=strrpos($file,'.'))!==false)
  	$ext=substr($file,$pos+1);
  ?>
  <?php   
  if ($ext == mp4) {
  $a = video;
  $b = mp4;
  $this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $a,   
    
     'mimeType' =>'video/mp4',
    ));
  } else if ($ext == flv) {
  	//print_r("here".$a);
   // die();
  $this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $a,   
     'mimeType' =>'video/flv',
    ));
  } else if ($ext == ogg) {
  	//print_r("here".$a);
   // die();
  $this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $a,   
     'mimeType' =>'video/ogg',
    ));
  }else if ($ext == webm) {
  	//print_r("here".$a);
   // die();
  $this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $a,   
     'mimeType' =>'video/webm',
    ));
  }else if ($ext == mp3) {
  	//print_r("here".$a);
   // die();
  $this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $a,   
     'mimeType' =>'audio/mp3',
    ));
  }else if ($ext == mp3) {
  	//print_r("here".$a);
   // die();
  $this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $a,   
     'mimeType' =>'audio/wav',
    ));
  }else if ($ext == wav) {
  	//print_r("here".$a);
   // die();
  $this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $a,   
     'mimeType' =>'audio/mp3',
    ));
  }
  ?>
  <?php 
   elseif ($ext == 'pdf' || $ext == 'odt' || $ext == 'odp'): 
   $b = "http://localhost/final/Viewer.js/#../upload/".$orgId.'/'.$categoryId.'/'.$assetid.'/'.$file1.'.'.$ext;
  ?>
  
  <iframe id="viewer" src = "<?php echo $b;?>"
  width='800' height='500' allowfullscreen webkitallowfullscreen></iframe>
  
  <?php else:?>
  
  <?php endif;?>