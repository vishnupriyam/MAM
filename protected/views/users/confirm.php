<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php

$this->menu=array(
	array('label'=>'Create Users','url'=>array('create')),
	array('label'=>'Manage Users','url'=>array('admin')),
);
?>

<h1>Users</h1>

<?php $this->widget('zii.widgets.grid.CGridView',array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'name',
		array('name'=>'Status','value'=>'$data->getStatus()'),
		//array('name'=>'','type'=>'raw','value'=>'CHtml::link("view", array("asset/","viewer"=>$data->uId))'),

		array
		(
	    'class'=>'CButtonColumn',
	    'template'=>'{confirm}',
	    'buttons'=>array
	    (
	        'confirm' => array
        		(
            		'label' => '<i class="icon-ok"></i>',
            		'url'=>'array("users/confirmUser","id"=>$data->uid)',
            		'click'=>'function(){alert("User confirmed!");}',
        		),
    	),
	),
    ),
)); ?>