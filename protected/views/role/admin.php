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
	'model'=>$parent_model,
)); ?>
</div><!-- search-form -->


<div id="ParentView">

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'role-grid',
	'dataProvider'=>$parent_model->search(),
	'filter'=>$parent_model,
	'columns'=>array(
		'rid',
		'name',
		'weight',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
	
	'ajaxUpdate'=>'childView',
)); ?>


</div>

<!-- Use this paragraph to display the loading.gif icon above the Child Gridview,
while waiting for the ajax response -->
<p id="loadingPic"></br></p>


<!-- The childView <div>, renders the _child form, which contains the Child Gridview.
The ajax response will replace/update the whole <div> and not just the gridview. -->
<div id="childView">
    <?php
        $this->renderPartial('_child', array(
        'child_model' => $child_model, 
        'parentID' => $parentID, 
        ))
    ?>
</div>

<?php
    /*Load the javascript file that contains our own ajax function*/
    $path = Yii::app()->baseUrl.'/js/customFunctions.js';
    Yii::app()->clientScript->registerScriptFile($path,
    CClientScript::POS_END);
?>




