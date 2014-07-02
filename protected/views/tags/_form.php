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
	'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
            
        <!-- display the categories related to logged in users department -->    
    	<?php 
			 $orgId= Yii::app()->user->getId();
			 $userId = Yii::app()->user->getState("uid");
			 $userRecord = Users::model()->find('uid=:uid',array(':uid'=>$userId));
			 $ouId = $userRecord->ouId;
			 
			 $connection=Yii::app()->db;
			 $sql="SELECT category.cat_id, name
				FROM category
				JOIN category_has_ou_structure ON category.cat_id = category_has_ou_structure.cat_id
				WHERE category_has_ou_structure.id =:ouId;";
			 $command = $connection->createCommand($sql);
			 $command->bindParam(":ouId",$ouId,PDO::PARAM_INT);
			 $dataReader = $command->queryAll();
			    		
			 echo  TbHtml::dropDownListControlGroup('cat_id','',
			 CHtml::listData($dataReader, 'cat_id', 'name'), 
			 array('span'=>3,'label'=>'Add tag for category','multiple'=>true), array('label'=>'child')); ?>
			
			<?php echo $form->textfieldControlGroup($model,'tagName',
			array('span'=>2,'rows'=>1,'label'=>'Tag Name','help'=>'Add multiple tags with commas(,)')); ?>
			
			 
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