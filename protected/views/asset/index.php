<?php
/* @var $this AssetController */
/* @var $model Asset */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#asset-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'asset-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	
	'columns'=>array(
		'assetId',
		'assetName',
		'file',
		'createDate',
		array('name'=>'status', 'header'=>'status', 'value'=>'$data->getStatus()'),
		array('name'=>'publication', 'header'=>'publication','value'=>'$data->getPublication()'),
		array('name'=>'onlineEditable', 'header'=>'online editable','value'=>'$data->getOnlineEditable()'),
		'size',	
		array('name'=>'owner_name','value'=>'$data->users->name'),
		'type',
		//'reviewer',
		//array('name'=>'view','type'=>'raw','value'=>$this->renderPartial('viewer', true, true)),
		array('name'=>'view_online','type'=>'raw','value'=>'CHtml::link("view", array("asset/","viewer"=>$data->assetId))'),
		
	),
)); ?>