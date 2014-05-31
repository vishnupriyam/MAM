<?php
/* @var $this ModDataController */
/* @var $model ModData */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'mod_id'); ?>
		<?php echo $form->textField($model,'mod_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_name'); ?>
		<?php echo $form->textField($model,'mod_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_desc'); ?>
		<?php echo $form->textField($model,'mod_desc',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->