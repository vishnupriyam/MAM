<?php
/* @var $this DocumentController */
/* @var $model Document */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'document-form',
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->fileFieldControlGroup($model,'doc',array('span'=>5)); ?>
            <?php echo $form->dropDownListControlGroup($model, 'owner',
        	   CHtml::listData(Users::model()->findAll(),'uid','name')
	        ); ?>
	        <?php echo $form->dropDownListControlGroup($model, 'department',
        	   CHtml::listData(Ou_structure::model()->findAll(),'id','name')
	        ); ?>
	        <?php echo $form->dropDownListControlGroup($model, 'category',
        	   CHtml::listData(Category::model()->findAll(),'cat_id','name')
	        ); ?>
	        <?php echo $form->textfieldControlGroup($model,'tags',
	        array('label'=>'User Defined Tags','Placeholder'=>'Tags')); ?>
	        
	        <?php //echo CHtml::checkBox("status",$model->roles=='ACTIVE',array('checked'=>'checked')); 
    $criteria = new CDbCriteria();
    $orgId = Yii::app()->user->getId();
   $criteria->compare('orgId', $orgId, true);
    echo $form->labelEx($model,'tags_defined');
    $type_list=CHtml::listData(Tags::model()->findAll(),'tagId','name');
    echo $form->checkBoxList($model,'roles',$type_list,array('checked'=>'checked','value' => '1', 'uncheckValue'=>'0','template'=>'{input}{label}',
            'separator'=>'',
 
        'labelOptions'=>
           array(
           
            'style'=> ' padding-left:200px;
                    width: 60px;
                    float: left;
                '),
              'style'=>'float:left;',
              ) 
    ); 
    
	    ?>
	       
	      <?php echo $form->textfieldControlGroup($model,'description',
	        array('label'=>'Description','Placeholder'=>'description')); ?>
	       
	        <?php echo $form->textfieldControlGroup($model,'comment',
	        array('label'=>'comment','Placeholder'=>'comment')); ?>
	          
	

            

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->