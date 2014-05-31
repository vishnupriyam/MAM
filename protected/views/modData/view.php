<?php
/* @var $this ModDataController */
/* @var $model ModData */

$this->breadcrumbs=array(
	'Mod Datas'=>array('index'),
	$model->mod_id,
);

$this->menu=array(
	array('label'=>'List ModData', 'url'=>array('index')),
	array('label'=>'Create ModData', 'url'=>array('create')),
	array('label'=>'Update ModData', 'url'=>array('update', 'id'=>$model->mod_id)),
	array('label'=>'Delete ModData', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->mod_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ModData', 'url'=>array('admin')),
);
?>

<h1>View ModData #<?php echo $model->mod_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'mod_id',
		'mod_name',
		'mod_desc',
	),
)); ?>
