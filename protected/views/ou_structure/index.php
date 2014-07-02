<?php
/* @var $this CategoryController */
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
	 'name',
	 'dept_code',
	 'description',
	 array('name'=>'Add reviewer','type'=>'raw','value'=>'CHtml::link("Add reviewer", array("ou_structure/reviewerFind","id"=>$data->id))'),
  ),
)); ?>	

