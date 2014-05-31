<?php
/* @var $this RoleController */
/* @var $model Role */


$this->breadcrumbs=array(
	'Roles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Role', 'url'=>array('index')),
	array('label'=>'Create Role', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#role-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Roles</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'role-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rid',
		'name',
		'weight',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

	<?php 
          /*  $orgId= Yii::app()->user->getId();
			$criteria=new CDbCriteria();
			$criteria->compare('orgId', $orgId, true);
            echo $form->dropDownListControlGroup($model, 'module_mid',
			CHtml::listData(Role::model()->findAll($criteria), 'rid', 'name'), 
			array('span'=>3,'label'=>'Roles','help' => '<strong>Note:</strong> Labels surround all the options for much larger click areas.'), array('label'=>'Role')); ?>
*/
//<?php 
    /*        $orgId= Yii::app()->user->getId();
			$criteria=new CDbCriteria();
			$criteria->compare('orgId', $orgId, true);
            echo $form->dropDownListControlGroup($model, 'module_mid',
			CHtml::listData(Users::model()->findAll($criteria), 'uid', 'name'), 
			array('span'=>3,'label'=>'Roles','help' => '<strong>Note:</strong> Labels surround all the options for much larger click areas.'), array('label'=>'Role')); ?>
*/
