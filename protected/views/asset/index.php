<?php
/* @var $this AssetController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	'Assets',
);

$this->menu=array(
	array('label'=>'Create Asset','url'=>array('create')),
	array('label'=>'Manage Asset','url'=>array('admin')),
);
?>

<h1 style="margin-top:3em;">Assets</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'dataProvider'=>$dataProvider,
	//'itemView'=>'_view',
	'columns'=>array(
		'assetName',
		'file',
		'createDate',
		'status',
		//array('name'=>'Category','value'=>'$data->category->name'),
		'publication',
		'onlineEditable',
		'size',
		'type',
		'reviewer',
		//'ownerId',
		array('name'=>'Owner Name','value'=>'$data->users->name'),
		//array('name'=>'view','type'=>'raw','onclick'=>function(){},),
	),
)); ?>