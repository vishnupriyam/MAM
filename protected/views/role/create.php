<?php
/* @var $this RoleController */
/* @var $model Role */
?>

<?php
$this->breadcrumbs=array(
	'Roles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Role', 'url'=>array('index')),
	array('label'=>'Manage Role', 'url'=>array('admin')),
	array('label'=>'Assign role to users', 'url'=>array('rfu')),
);
?>

<h1>Create Role</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>