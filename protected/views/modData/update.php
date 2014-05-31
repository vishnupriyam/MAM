<?php
/* @var $this ModDataController */
/* @var $model ModData */

$this->breadcrumbs=array(
	'Mod Datas'=>array('index'),
	$model->mod_id=>array('view','id'=>$model->mod_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ModData', 'url'=>array('index')),
	array('label'=>'Create ModData', 'url'=>array('create')),
	array('label'=>'View ModData', 'url'=>array('view', 'id'=>$model->mod_id)),
	array('label'=>'Manage ModData', 'url'=>array('admin')),
);
?>

<h1>Update ModData <?php echo $model->mod_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>