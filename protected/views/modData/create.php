<?php
/* @var $this ModDataController */
/* @var $model ModData */

$this->breadcrumbs=array(
	'Mod Datas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ModData', 'url'=>array('index')),
	array('label'=>'Manage ModData', 'url'=>array('admin')),
);
?>

<h1>Create ModData</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>