<?php
/* @var $this Category1Controller */
/* @var $model Category1 */
?>

<?php

$this->menu=array(
	array('label'=>'List Category1', 'url'=>array('index')),
	array('label'=>'Manage Category1', 'url'=>array('admin')),
);
?>

<h1>Create Category1</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>