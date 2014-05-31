<?php
/* @var $this ModDataController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mod Datas',
);

$this->menu=array(
	array('label'=>'Create ModData', 'url'=>array('create')),
	array('label'=>'Manage ModData', 'url'=>array('admin')),
);
?>

<h1>Mod Datas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
