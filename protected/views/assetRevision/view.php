<?php
/* @var $this AssetRevisionController */
/* @var $model AssetRevision */
?>

<?php
$this->breadcrumbs=array(
	'Asset Revisions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AssetRevision', 'url'=>array('index')),
	array('label'=>'Create AssetRevision', 'url'=>array('create')),
	array('label'=>'Update AssetRevision', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssetRevision', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssetRevision', 'url'=>array('admin')),
);
?>

<h1>View AssetRevision #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(

		array('name'=>'filename','value'=>$model->asset->file),
		array('name'=>'Department','value'=>$model->asset->OwnerDept->name),
		array('name'=>'Category','value'=>$model->asset->category->name),
		array('name'=>'Size','value'=>$model->asset->size),
		array('name'=>'Date Created','value'=>$model->asset->createDate),
		array('name'=>'Description','value'=>$model->asset->description),
		array('name'=>'modified by','value'=>$model->users->name),
		'modifiedOn',
		array('name'=>'comment','value'=>$model->asset->comment),
    	'note',
		'revision',
		array('name'=>'tags','type'=>'raw','value'=>$model->asset->getTags()),
	),
)); ?>

		<?php  
		   $uid = Yii::app()->user->getState("uid");
		   $assetId = $model->assetId;
			if(($uid==$model->asset->ownerId)||Users::hasAcessPermission($uid,$assetId,0) || Users::hasAcessPermission($uid,$assetId,1) ||Users::hasAcessPermission($uid,$assetId,2) ||Users::hasAcessPermission($uid,$assetId,3)){ 
			echo TbHtml::button('view',array(
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
				'submit' => Yii::app()->baseUrl,
                'class'=>'submit'
                
            )); 
			}
            ?>
       <?php 
       		if(($uid==$model->asset->ownerId)||Users::hasAcessPermission($uid,$assetId,4) || Users::hasAcessPermission($uid,$assetId,1) ||Users::hasAcessPermission($uid,$assetId,2) ||Users::hasAcessPermission($uid,$assetId,3)){ 
			echo CHtml::link(
    		'Download',
    		 Yii::app()->createUrl('Asset/DownloadVersion' , array('id' => $model->assetId,'version'=>$model->revision)),
     		 array('class'=>'btnPrint btn btn-primary','target'=>'_blank'));
       		}
		?>
            
		
