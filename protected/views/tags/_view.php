<?php
/* @var $this TagsController */
/* @var $data Tags */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('tagId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tagId),array('view','id'=>$data->tagId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tagName')); ?>:</b>
	<?php echo CHtml::encode($data->tagName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orgId')); ?>:</b>
	<?php echo CHtml::encode($data->orgId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unitCode')); ?>:</b>
	<?php echo CHtml::encode($data->unitCode); ?>
	<br />


</div>