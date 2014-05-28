<?php
/* @var $this Category1Controller */
/* @var $data Category1 */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('cat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cat_id),array('view','id'=>$data->cat_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orgId')); ?>:</b>
	<?php echo CHtml::encode($data->orgId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unitCode')); ?>:</b>
	<?php echo CHtml::encode($data->unitCode); ?>
	<br />


</div>