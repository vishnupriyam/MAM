
<?php
$this->pageTitle=Yii::app()->name . ' - Search results';
$this->breadcrumbs=array(
		'Search Results',
);
?>
 
<h3>Search Results for: "<?php echo CHtml::encode($term); ?>"</h3>
<div>
 <?php 
  
echo TbHtml::tabs(array(
        
				array('label'=>'Documents', 'url'=>array('search/search', 'q'=>$term)),
				array('label'=>'Images', 'url'=>array('/search/search1', 'param'=>$term)),
				array('label'=>'Videos', 'url'=>array('/search/search2', 'param'=>$term)),
				array('label'=>'Audio', 'url'=>array('/search/search3', 'param'=>$term)),
			
        		
        		
        )); 
 
   
  ?>
  
</div> 
<br>
<br>
<?php // LOADING PAGE FOR  IMAGE SEARCH RESULT ?>
<?php if ($flag=='1'): ?>
           
              <h4>Image:</h4>
          <?php if (!empty($results)): ?>
                <?php foreach($results as $result): 
                ?>  
           
                   
                    <?php
                    if(($pos=strrpos($result->title,'.'))!==false)
    			    $ext=substr($result->title,$pos+1);
                    ?>
                       <?php 
                       if($ext=='jpg' || $ext=='gif' || $ext=='png'):
                       ?>
    			         <p>Title: <?php echo $query->highlightMatches(CHtml::encode($result->title)); ?></p>
                        <p>Link: <?php echo CHtml::link("view", array("asset/","viewer"=>$result->name));
                        ?></p>
                           
                   <?php        
                     
                       $orgId = $result->link;
					  $categoryId = $result->content;
					  
					  $a = "http://localhost/final/upload/".$orgId.'/'.$categoryId.'/'.$result->name.'.'.$ext; 
					   
					  ?>
                       <img id = "image" src = "<?php echo $a;?>" height=100 width = 100 alt=""> 
                       <?php endif; ?>
                      <hr/>
                <?php endforeach; ?>
 
             <?php else: ?>
                <p class="error">No results matched your search terms.</p>
              <?php endif; ?>
            
        <?php // LOADING PAGE FOR  AUDIO SEARCH RESULT ?>
  <?php elseif ($flag=='3'):  ?>   
  <h4>AUDIO:</h4>
          <?php if (!empty($results)): ?>
                <?php foreach($results as $result): 
                ?>  
                  <?php
                    if(($pos=strrpos($result->title,'.'))!==false)
    			    $ext=substr($result->title,$pos+1);
                    ?>
                       <?php 
                       if($ext==='mp3'):
                       ?>
    			         <p>Title: <?php echo $query->highlightMatches(CHtml::encode($result->title)); ?></p>
                        <p>Link: <?php echo CHtml::link("view", array("asset/","viewer"=>$result->name));
                       ?></p>
                          <?php 
                       $ext1=substr($result->content,0,200);
                        ?>
                       <p>Content: <?php   echo $query->highlightMatches(CHtml::encode($ext1)); ?></p> 
                       <?php endif; ?>
                    <hr/>
                <?php endforeach; ?>
 
            <?php else: ?>
                <p class="error">No results matched your search terms.</p>
            <?php endif; ?>
    
 
 
                    <?php // ....................LOADING PAGE FOR  VIDEO SEARCH RESULT....................... ?>
 <?php elseif  ($flag=='2'):  ?> 
      <h4>VIDEO:</h4>
          <?php if (!empty($results)): ?>
                <?php foreach($results as $result): 
                ?>  
           
                   
                    <?php
                    if(($pos=strrpos($result->title,'.'))!==false)
    			    $ext=substr($result->title,$pos+1);
                    ?>
                       <?php 
                       if($ext==='mp4'||$ext==='3gp'||$ext==='avi'):
                       ?>
    			         <p>Title: <?php echo $query->highlightMatches(CHtml::encode($result->title)); ?></p>
                        <p>Link: <?php echo CHtml::link("view", array("asset/","viewer"=>$result->name));
                       ?></p>
                          <?php 
                       $ext1=substr($result->content,0,200);
                        ?>
                       <p>Content: <?php   echo $query->highlightMatches(CHtml::encode($ext1)); ?></p> 
                       <?php endif; ?>
                    <hr/>
                <?php endforeach; ?>
 
            <?php else: ?>
                <p class="error">No results matched your search terms.</p>
            <?php endif; ?>
    
  
   <?php // ....................LOADING PAGE FOR  DOCUMENT SEARCH RESULT......................... ?> 
  <?php else : ?>   
 
 <h4>DOCUMENT:</h4>
  <?php if (!empty($results)): ?>
                <?php foreach($results as $result): 
               // echo "hereee";
                ?>  
                    <?php
                    if(($pos=strrpos($result->title,'.'))!==false)
    			    $ext=substr($result->title,$pos+1);
                    ?>
                    
                    <?php // LOADING PAGE FOR  DOCUMENT SEARCH RESULT ?>
                       <?php
                       if($ext=='xlsx' || $ext=='docx' || $ext=='pptx' || $ext == 'doc' || $ext == 'odt'
                       || $ext == 'ppt'||$ext == 'pdf'):
                       ?>
    			         <p>Title: <?php echo $query->highlightMatches(CHtml::encode($result->title)); ?></p>
                        <p>Link: <?php  echo CHtml::link("view", array("asset/","viewer"=>$result->name));
                       ?></p>
                          <?php 
                        $ext1=substr($result->content,0,250);
                        ?>
                       <p>Content: <?php echo $query->highlightMatches(CHtml::encode($ext1)) ; ?></p>
                        
                       
                        <?php elseif ( $ext == 'odp'): ?>
                        <p>Title:  <?php echo $query->highlightMatches(CHtml::encode($result->title));?></p>
                           <p>Link: <?php  echo CHtml::link("view", array("asset/","viewer"=>$result->name)); ?></p>
                         <?php 
                         $ext1=substr($result->content,0,200);
                        ?>
                       <p>Content: <?php   echo $query->highlightMatches(CHtml::encode($ext1)); ?></p>
                       
                        <?php // ........................LOADING PAGE FOR  TAGS SEARCH RESULT....................... ?>
                       <?php else: ?>
                       <?php 
                       //here getting a database connection for accesing asset from tag
                       
                        $tagId = $result->name;
                      
                        $connection = Yii::app()->db;
                        $sql3 = "select assetId from asset_tags where tagId = :tagId";
					    $command = Yii::app()->db->createCommand($sql3);
			
					    $command->bindParam(":tagId",$tagId,PDO::PARAM_INT);
					    $dataReader = $command->query();
					    while (($model1 = $dataReader->read())!== false)
					    {
					    	$a = $model1['assetId'];
					    	$sql = "select file from asset where assetId = :assetId";
			    			$command = $connection->createCommand($sql);
			    			$command->bindParam(":assetId",$a,PDO::PARAM_INT);
			    			$dataReader2 = $command->query();
        					$row = $dataReader2->read();
        					$dataReader2->close();
                            $ans = $row['file'];
                       		?>
                       		
                           <p>Title: <?php echo $ans; ?></p>
                           <p>Link: <?php  echo CHtml::link("view", array("asset/","viewer"=>$a)); ?></p>
                           <p> <?php  // echo$query->highlightMatches(CHtml::encode($result->name)); ?></p> 
                           <?php  } ?>
                        <?php endif; ?>
                    
                <?php endforeach; ?>
            
            <?php else: ?>
                <p class="error">No results matched your search terms.</p>
            <?php endif; ?>
             
   <?php endif; ?>   
             
 