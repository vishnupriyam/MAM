<h2>
<?php echo $model->file;?>
</h2>


<!-- variable defnitions for wigets to apply in grid view -->
<?php
	$properties =$this->widget('zii.widgets.CDetailView',array(
    		'htmlOptions' => array(
        		'class' => 'table table-striped table-condensed table-hover',
  			  ),
    		'data'=>$model,
    		'attributes'=>array(
				'assetId',
  			    'assetName',
  			    'file',
  			  	array('name'=>'Owner Name','value'=>$model->users->name),
    			array('name'=>'Category Name','value'=>$model->category->name),
				'createDate',
				'comment',
				array('name'=>'Status','value'=>$model->getStatus()),
				array('name'=>'Publication','value'=>$model->getPublication()),
				array('name'=>'Online Editable','value'=>$model->getOnlineEditable()),
				'size',
				'type',
				
	),
),true) ;
?>
<!--  file access log data -->
<?php 

 $accesslog = new CActiveDataProvider('Fileaccesslog',array('criteria'=>array(
                        'condition'=>'assetId=:assetId',
                        'params'=>array(':assetId'=>$model->assetId,),
    
                    ),
					 )) ;

 $accessLogView = $this->widget('bootstrap.widgets.TbGridView',array(
	'dataProvider'=>$accesslog,
	'columns'=>array(
 	 array('name'=>'filename','value'=>'$data->asset->file'),
 	 array('name'=>'Time','value'=>'$data->timeStamp'),
 	 array('name'=>'Username','value'=>'$data->users->name'),
 	 array('name'=>'Action','value'=>'$data->getAction()')
 	),
 
),true);

?>

<!-- grid view -->
<?php echo TbHtml::tabbableTabs(array(

    array('label' => 'Properties', 'active' => true, 'content' =>$properties),
    
    array('label' => 'Description', 'content' =>$model->description),
    
    array('label' => 'Notes', 'content' => TbHtml::textArea('Notes','',array('label'=>'Notes:','span'=>6,'rows'=>4))),
    
    array('label' => 'AccessLog', 'content' => $accessLogView),
    
    array('label' => 'Tags', 'content' => $model->getTags() ),
    
    
    array('label' => 'Email', 'content' => 'EMAIL UNDER CONSTRUCTION'),
    
), array('placement' => TbHtml::TABS_PLACEMENT_LEFT)); ?>

<style type="text/css">
 .btn {margin-left:.2em;}

</style>

<div class="" style="margin-left:7em;">

<?php 
	//userid and assetid
	$uid = Yii::app()->user->getState("uid");
	$assetId = $model->assetId;

	//view button
	if(($uid==$model->ownerId)||Users::hasAcessPermission($uid,$assetId,0) || Users::hasAcessPermission($uid,$assetId,1) ||Users::hasAcessPermission($uid,$assetId,2) ||Users::hasAcessPermission($uid,$assetId,3)||Users::hasAcessPermission($uid,$assetId,4)){
		echo CHtml::link('View', Yii::app()->createUrl('Asset/Viewer' , array('id' => $model->assetId)),
      	array('class'=>'btnPrint btn btn-primary','target'=>'_blank'));
	}    

	//check out button
	if(Users::hasAcessPermission($uid,$assetId,2)||($uid==$model->ownerId)){
		 echo CHtml::link(
	    'Check Out',
	     Yii::app()->createUrl('Asset/CheckOut' , array('id' => $model->assetId)),
	     array('class'=>'btnPrint btn btn-primary','target'=>'_blank'));
	}
	
	//history button
	if(($uid==$model->ownerId)||Users::hasAcessPermission($uid,$assetId,0) || Users::hasAcessPermission($uid,$assetId,1) ||Users::hasAcessPermission($uid,$assetId,2) ||Users::hasAcessPermission($uid,$assetId,3)){
	 echo CHtml::link(
    'History',
     Yii::app()->createUrl('Asset/history' , array('id' => $model->assetId)),
     array('class'=>'btnPrint btn btn-primary'));
    }
	
    //manage button
    if($uid==$model->ownerId){  
	 echo CHtml::link(
    'Manage',
     Yii::app()->createUrl('Asset/update' , array('id' => $model->assetId)),
     array('class'=>'btnPrint btn btn-primary')); 
	}
	
	//download button
	if(($uid==$model->ownerId)||Users::hasAcessPermission($uid,$assetId,4) || Users::hasAcessPermission($uid,$assetId,1) ||Users::hasAcessPermission($uid,$assetId,2) ||Users::hasAcessPermission($uid,$assetId,3)){ 
	 echo CHtml::link(
    'Download',
     Yii::app()->createUrl('Asset/update' , array('id' => $model->assetId)),
     array('class'=>'btnPrint btn btn-primary')); 
	}
	
?>

</div>
