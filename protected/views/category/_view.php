<?php
/* @var $this Category1Controller */
/* @var $data Category1 */
?>

<div class="view">

	
    
	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name),array('view','id'=>$data->cat_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Departments')); ?>:</b>
	<?php echo CHtml::encode($data->getDepartments()); ?>
	<br />

	

</div>