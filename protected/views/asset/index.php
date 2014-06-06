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

<h1>Assets</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>