<?php
/* @var $this PermissionsController */
/* @var $model Permissions */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'permissions-form',
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

			
            
		
			
		<?php 
            $orgId= Yii::app()->user->getId();
            
			$criteria=new CDbCriteria();
			$criteria->compare('orgId', $orgId, true);
            echo $form->dropDownListControlGroup($model, 'module_mid',
			CHtml::listData(Module::model()->findAll($criteria), 'mid', 'name'), 
			array('span'=>3,'label'=>'Modules'), array('label'=>'child')); ?>
		 
		    <?php 
            $orgId= Yii::app()->user->getId();
            
			$criteria=new CDbCriteria();
			$criteria->compare('orgId', $orgId, true);
            echo $form->dropDownListControlGroup($model, 'role_rid',
			CHtml::listData(Role::model()->findAll($criteria), 'rid', 'name'), 
			array('span'=>3,'label'=>'Roles'), array('label'=>'child')); ?>
		     
		     <div class="" style="margin-left:-2em">
		<?php 
		// $orgId= Yii::app()->user->getId();
			//$criteria=new CDbCriteria();
			//$criteria->compare('orgId', $orgId, true);
		echo TbHtml::inlinecheckBoxListControlGroup('Permissions','',CHtml::listData(Basicpermissions::model()->findAll(), 'id', 'vpermission'), array('span'=>3,'label'=>'Permissions')); 
		?>	 
	 </div>	 
	
			
            <?php echo $form->textAreaControlGroup($model,'description',array('rows'=>6,'span'=>8)); ?>

            

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?>
		<?php echo TbHtml::submitButton(Yii::t('Yii','Cancel'),array(
 			'name'=>'buttonCancel',
			'color'=>TbHtml::BUTTON_COLOR_DANGER,
		    ));?>
		    
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->