<?php

/* @var $this AssetController */
/* @var $model Asset */
/* @var $form TbActiveForm */

?>

<style type="text/css">
	#headerA{
	width:10%;
	padding-left:4em;}
	.radio.inline, .checkbox.inline{width:34%; margin-left:20px !important;}
	
</style>
<div class="form" style="margin-top:3em;">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'asset-form',
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php $assetId=$model->assetId;?>
    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
	
	<div class="span12" style="margin-left:0;">
		
		<div class="span5" style="margin-left:0;">
		
			<?php echo $form->textFieldControlGroup($model,'assetName',array('span'=>3,'maxlength'=>70,'label'=>'File Name')); ?>

            <?php
			$orgId=Yii::app()->user->getId();
			$presentuid = Yii::app()->user->getState("uid");
			$modelA = Users::model()->find('uid=:uid',array(':uid'=>$presentuid));
			$departmentId1 = $modelA->ouId;
			
            echo $form->dropDownListControlGroup($model,'ownerId',CHtml::listData(Users::model()->findAll('ouId=:ouId',array(':ouId'=>$departmentId1)), 'uid', 'name'));
             ?>
            
            <?php 
            
            $root = Ou_structure::model()->find('orgId=:orgId',array(':orgId'=>$orgId));
            $root = $root->id;
            ?>
            
         	<?php
			echo $form->dropDownListControlGroup($model,'categoryId',
			CHtml::listData(Category::model()->findAll('orgId=:orgId',array(':orgId'=>$orgId)), 'cat_id', 'name'),
			array('label'=>'Category')); ?>
            
			
		</div><!-- end of span 7 -->

			<div class="span5" style="margin-top:3.5em;">
				<?php echo TbHtml::inlinecheckBoxListControlGroup('tags','',
					CHtml::listData(Tags::model()->findAll('orgId=:orgId',array(':orgId'=>$orgId)), 'tagId', 'tagName'), 
					array('span'=>3,'label'=>'Tags')); ?>	 
	 			<?php echo $form->textFieldControlGroup($model,'tagsUser',array('span'=>3,'maxlength'=>70,'label'=>'Add Tags')); ?>
         	
	 		
	 		</div>

		</div><!-- end of span12 -->
		
				
		<?php echo $form->radioButtonListControlGroup($model, 'publication', array('yes','no',)); ?>
 			
		<?php echo $form->radioButtonListControlGroup($model, 'onlineEditable', array('yes','no',)); ?>
 
        <?php echo $form->textAreaControlGroup($model,'description',array('rows'=>4,'span'=>8)); ?>

        <?php echo $form->textAreaControlGroup($model,'comment',array('rows'=>1,'span'=>8)); ?>

		

	<div class="span9 offset1">
	
		<?php
			$this->assetId = $model->assetId;
			//load the departments of the logged in organisation
			$dataProvider = new CActiveDataProvider('Ou_structure',array('criteria'=>array(
                        'condition'=>'root=:root',
                        'params'=>array(':root'=>$root),
    
                    ),
            ));

           $number = 0;
				$this->widget('bootstrap.widgets.TbGridView', array(
				'selectableRows' => 1,
				'id'=>'gview',
				'dataProvider'=>$dataProvider,
				'rowHtmlOptionsExpression' => 'array("id"=>$data->id)',
				'columns'=>array(
    			array('name'=>'name','header'=>'Departments'),   
	 			array('header'=>'Read','value'=>'','id'=>'headerA'),
	    		array(
	    		    
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'read',
	        		'selectableRows'=>2,
	    			'header'=>'Read',
	    			'checked'=> 'Yii::app()->controller->isChecked($data->id,$this->grid->controller->assetId,0)' ,
	    		
	    		),    	
	    		array('header'=>'Write','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'write',
	        		'selectableRows'=>2,
	    			'header'=>'Write',
	    			'checked'=> 'Yii::app()->controller->isChecked($data->id,$this->grid->controller->assetId,1)' ,
	    		),
	    		array('header'=>'Edit','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'edit',
	        		'header'=>'Edit',
	    			'selectableRows'=>2,
	    			'checked'=> 'Yii::app()->controller->isChecked($data->id,$this->grid->controller->assetId,2)' ,
	    		),
	    		array('header'=>'Delete','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'delete',
	        		'selectableRows'=>2,
	    			'header'=>'Delete',
	    			'checked'=> 'Yii::app()->controller->isChecked($data->id,$this->grid->controller->assetId,3)' ,
	    		)    	
	      ),
   		)
		);

 		
	?>
	
	
		</div>
		
		<br />
		<hr />
		<div id='Users_table'>
			
		<!-- register for search  -->	
		<?php
			Yii::app()->clientScript->registerScript('search2', "
				$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
			});
			$('.search-form form').submit(function(){
				$('#Agview').yiiGridView('update', {
				data: $(modelUsers).serialize()
			});
			return false;
		  });
			" );
		 ?>
			
			<!-- Users grid view -->
			<?php 
			
				$this->widget('bootstrap.widgets.TbGridView', array(
				'selectableRows' => 2,
				'id'=>'Agview',
				'dataProvider'=>$modelUsers->search2(),
				'filter'=>$modelUsers,
				'rowHtmlOptionsExpression' => 'array("uid"=>$data->uid)',
				'columns'=>array(
    			array('name'=>'name','header'=>'Users'),    /*in header give the role name while passing*/
	 			array('header'=>'Read','value'=>'','id'=>'headerA'),
	    		array(
	    		    
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'Aread',
	        		'selectableRows'=>2,
	    			'header'=>'Read',
	    			'checked'=> 'Yii::app()->controller->isCheckedUser($data->uid,$this->grid->controller->assetId,0)' ,
	    		),    	
	    		array('header'=>'Write','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'Awrite',
	        		'selectableRows'=>2,
	    			'header'=>'Write',
	    			'checked'=> 'Yii::app()->controller->isCheckedUser($data->uid,$this->grid->controller->assetId,1)' ,
	    		),
	    		array('header'=>'Edit','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'Aedit',
	        		'header'=>'Edit',
	    			'selectableRows'=>2,
	    			'checked'=> 'Yii::app()->controller->isCheckedUser($data->uid,$this->grid->controller->assetId,2)' ,
	    		),
	    		array('header'=>'Delete','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'Adelete',
	        		'selectableRows'=>2,
	    			'header'=>'Delete',
	    			'checked'=> 'Yii::app()->controller->isCheckedUser($data->uid,$this->grid->controller->assetId,3)' ,
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

	<?php 
	//print_r(Yii::app()->controller->isChecked(11,57,0));?>
    
	<?php $this->endWidget(); ?>

</div><!-- form -->