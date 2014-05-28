<?php
/* @var $this TagsController */
/* @var $model Tags */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'tags-form',
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textfieldControlGroup($model,'tagName',array('span'=>2,'rows'=>1,'label'=>'Tag Name')); ?>

            
            <?php echo $form->textfieldControlGroup($model, 'orgId',array('span'=>2,'disabled'=>true,'label'=>'Organisation Name','placeholder'=>'OrgId from database')); ?>

			 <?php echo $form->textfieldControlGroup($model, 'unitCode',array('span'=>2,'disabled'=>true,'label'=>'Department Name','placeholder'=>'UnitCode from database')); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->