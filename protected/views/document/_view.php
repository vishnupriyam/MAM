<?php
/* @var $this DocumentController */
/* @var $data Document */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('doc_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->doc_id),array('view','id'=>$data->doc_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doc_name')); ?>:</b>
	<?php echo CHtml::encode($data->doc_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />


</div>