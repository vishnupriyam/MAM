<?php
/* @var $this Category1Controller */
/* @var $model Category1 */
?>

<?php
$this->breadcrumbs=array(
	'Category1s'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List Category1', 'url'=>array('index')),
	array('label'=>'Create Category1', 'url'=>array('create')),
	array('label'=>'Update Category1', 'url'=>array('update', 'id'=>$model->cat_id)),
	array('label'=>'Delete Category1', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cat_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Category1', 'url'=>array('admin')),
);
?>

<h1>View Category1 #<?php echo $model->cat_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'cat_id',
		'Name',
		'orgId',
		'unitCode',
	),
)); ?>