
<h2><?php echo $model->file; ?></h2>



<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'assetId',
		'assetName',
    	array('name'=>'Category Name','value'=>$model->category->name),
		'createDate',
		'description',
		'comment',
		//'status',
		array('name'=>'Status','value'=>$model->getStatus()),
		//'publication',
		array('name'=>'Publication','value'=>$model->getPublication()),
		//'onlineEditable',
		array('name'=>'Online Editable','value'=>$model->getOnlineEditable()),
		'size',
		'type',
		'reviewer',
		'reviewerComments',
		//'ownerId',
		array('name'=>'Owner Name','value'=>$model->users->name),
		
	),
)); ?>


<style type="text/css">
 .btn {margin-left:.2em;}

</style>

<div class="" style="margin-left:7em;">
<?php

	//userid and assetid
	$uid = Yii::app()->user->getState("uid");
	$assetId = $model->assetId;

	//view button
	if(($uid==$model->ownerId)||Users::hasAcessPermission($uid,$assetId,0) || Users::hasAcessPermission($uid,$assetId,1) ||Users::hasAcessPermission($uid,$assetId,2) ||Users::hasAcessPermission($uid,$assetId,3)){
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
	if(($uid==$model->ownerId)||Users::hasAcessPermission($uid,$assetId,0) || Users::hasAcessPermission($uid,$assetId,1) ||Users::hasAcessPermission($uid,$assetId,2) ||Users::hasAcessPermission($uid,$assetId,3)){
	echo CHtml::link(
    'Download',
     Yii::app()->createUrl('Asset/Download' , array('id' => $model->assetId)),
     array('class'=>'btnPrint btn btn-primary','target'=>'_blank'));
	}

	//properties button
	if(($uid==$model->ownerId)||Users::hasAcessPermission($uid,$assetId,0) || Users::hasAcessPermission($uid,$assetId,1) ||Users::hasAcessPermission($uid,$assetId,2) ||Users::hasAcessPermission($uid,$assetId,3)){
	echo CHtml::link(
    'Properties',
     Yii::app()->createUrl('Asset/properties' , array('id' => $model->assetId)),
     array('class'=>'btnPrint btn btn-primary','target'=>'_blank'));
	}
?>

</div>
