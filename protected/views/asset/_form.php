<?php
/* @var $this AssetController */
/* @var $model Asset */
/* @var $form TbActiveForm */

?>

<style type="text/css">
	#headerA{
	width:10%;
	padding-left:4em;}

</style>
<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'asset-form',
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

			<?php echo $form->fileFieldControlGroup($model,'file'); ?>
			
		    <?php echo $form->textFieldControlGroup($model,'assetName',array('span'=>3,'maxlength'=>70,'label'=>'File Name')); ?>

            <?php echo $form->dropDownListControlGroup($model,'ownerId',CHtml::listData(Users::model()->findAll(), 'uid', 'name')); ?>
            
            <?php echo $form->dropDownListControlGroup($model,'departmentId',CHtml::listData(Ou_structure::model()->findAll(), 'id', 'name'),array('label'=>'Deprtment')); ?>
            
         	<?php echo $form->dropDownListControlGroup($model,'categoryId',CHtml::listData(Category::model()->findAll(), 'cat_id', 'name'),array('label'=>'Category')); ?>
            
			<?php  echo TbHtml::inlinecheckBoxListControlGroup('tags','',CHtml::listData(Tags::model()->findAll(), 'tagId', 'tagName'), array('span'=>3,'label'=>'Tags','help' => '<strong>Note:</strong> Add multiple tags with commas.')); ?>	 
	 
         	<?php echo $form->textFieldControlGroup($model,'tagsUser',array('span'=>3,'maxlength'=>70,'label'=>'Add Tags')); ?>
         	

            <?php echo $form->textAreaControlGroup($model,'description',array('rows'=>4,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'comment',array('rows'=>1,'span'=>8)); ?>

        <div class="span9 offset1">
		<?php
			$dataProvider = new CActiveDataProvider('Users');
			$model1 = Users::model()->findAll();
			$number = 0;
				$this->widget('bootstrap.widgets.TbGridView', array(
				
				'id'=>'gview',
				'dataProvider'=>$dataProvider,
				'columns'=>array(
    			array('name'=>'name','header'=>'Permissions'),    /*in header give the role name while passing*/
	 			array('header'=>'Read','value'=>'','id'=>'headerA'),
	    		array(
	    		    
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'read',
	        		'selectableRows'=>2,
	    			'header'=>'Read',
	    		
	    		),    	
	    		array('header'=>'write','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'write',
	        		'selectableRows'=>2,
	    			'header'=>'Write',
	    		),
	    		array('header'=>'Edit','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'edit',
	        		'header'=>'Edit',
	    			'selectableRows'=>2,
	    		),
	    		array('header'=>'Delete','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'delete',
	        		'selectableRows'=>2,
	    			'header'=>'Delete',
	    		)    	
	      ),
   		)
		);

 		
	?>
		</div>
		
		<div class="">
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