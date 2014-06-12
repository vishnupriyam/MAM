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
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
	
	<div class="span12" style="margin-left:0;">
	<div class="span5" style="margin-left:0;">
			<?php echo $form->fileFieldControlGroup($model,'file'); ?>
			
		    <?php echo $form->textFieldControlGroup($model,'assetName',array('span'=>3,'maxlength'=>70,'label'=>'File Name')); ?>

            <?php
			$orgId=Yii::app()->user->getId();
            echo $form->dropDownListControlGroup($model,'ownerId',CHtml::listData(Users::model()->findAll('orgId=:orgId',array(':orgId'=>$orgId)), 'uid', 'name')); ?>
            
            <?php 
            
            $root = Ou_structure::model()->find('orgId=:orgId',array(':orgId'=>$orgId));
            $root = $root->id;
            echo $form->dropDownListControlGroup($model,'departmentId',CHtml::listData(Ou_structure::model()->findAll('root=:root',array(':root'=>$root)), 'id', 'name'),array('label'=>'Deprtment')); ?>
            
         	<?php
			echo $form->dropDownListControlGroup($model,'categoryId',CHtml::listData(Category::model()->findAll('orgId=:orgId',array(':orgId'=>$orgId)), 'cat_id', 'name'),array('label'=>'Category')); ?>
            
			<?php // echo TbHtml::inlinecheckBoxListControlGroup('tags','',CHtml::listData(Tags::model()->findAll(), 'tagId', 'tagName'), array('span'=>3,'label'=>'Tags','help' => '<strong>Note:</strong> Add multiple tags with commas.')); ?>	 
	 
         	<?php //echo $form->textFieldControlGroup($model,'tagsUser',array('span'=>3,'maxlength'=>70,'label'=>'Add Tags')); ?>
         	

		</div><!-- end of span 7 -->

			<div class="span5" style="margin-top:3.5em;">
				<?php echo TbHtml::inlinecheckBoxListControlGroup('tags','',
					CHtml::listData(Tags::model()->findAll('orgId=:orgId',array(':orgId'=>$orgId)), 'tagId', 'tagName'), 
					array('span'=>3,'label'=>'Tags')); ?>	 
	 			<?php echo $form->textFieldControlGroup($model,'tagsUser',array('span'=>3,'maxlength'=>70,'label'=>'Add Tags')); ?>
         	
	 		
	 		</div>

		</div><!-- end of span12 -->
			
			
		<?php /*                                 
  			echo CHtml::dropDownList('dept_id','', 
  			//array(535=>'New England',541=>'Middle Atlantic',536=>'East North Central'),
 			array(CHtml::listData(Ou_structure::model()->findAll('root=:root',array(':root'=>$root)), 'id', 'name')),
  			
  			
 			 array(
    			'prompt'=>'Select Region',
    			'ajax' => array(
    			'type'=>'POST', 
    			'url'=>Yii::app()->createUrl('Asset/loadcities'), //or $this->createUrl('loadcities') if '$this' extends CController
    			'update'=>'#city_name', //or 'success' => 'function(data){...handle the data in the way you want...}',
  				'data'=>array('dept_id'=>'js:this.value'),
  			))); 
 
 
 
			echo CHtml::dropDownList('city_name','', array(), array('prompt'=>'Select City','multiple'=>true));
			
			?>
			
			
			<?php echo CHtml::ajaxSubmitButton('Form Ajax Submit Button',
                CHtml::normalizeUrl(array('Asset/getuserstable')), 
                
				array('success'=>'funcztion(){$("#mydialog").dialog("close");}',
                      'update'=>'#myDiv'                            ),
                array('name' => 'run', 'class' => 'btn btn-success')
          ); */ ?>
			
			
			<?php /* echo CHtml::ajaxLink('clickMe', CController::createUrl('asset/getuserstable'), array('update'=>'#mydiv'));*/ ?>
			
			
			<?php /*
 			$model1 = new Users;	
			$this->widget('ext.combobox.EJuiComboBox', array(
    		'model' => $model1,
    		'attribute' => 'name',
   			 // data to populate the select. Must be an array.
    		'data' => CHtml::listData(Users::model()->findAll(),'uid','name'),
    		// options passed to plugin
    		'options' => array(
        	// JS code to execute on 'select' event, the selected item is
        	// available through the 'item' variable.
        	'onSelect' => 'alert("selected value : " + item.value);',
			//'onSelect'=>"function(){document.getElementById('checkboxes').style.display=block;}",
	    	// JS code to be executed on 'change' event, the input is available
        	// through the '$(this)' variable.
        	'onChange' => 'alert("changed value : " + $(this).val());',
        	// If false, field value must be present in the select.
        	// Defaults to true.
        	'allowText' => false,
  		  ),
    	// Options passed to the text input
    	'htmlOptions' => array('size' => 10),
    
		));*/
	?>
			
	
			<?php echo $form->radioButtonListControlGroup($model, 'publication', array(
        		'yes',
        		'no',
 			   )); ?>
 			<?php echo $form->radioButtonListControlGroup($model, 'onlineEditable', array(
        		'yes',
        		'no',
 		   )); ?>
 
			
            <?php echo $form->textAreaControlGroup($model,'description',array('rows'=>4,'span'=>8)); ?>

            <?php echo $form->textAreaControlGroup($model,'comment',array('rows'=>1,'span'=>8)); ?>

		

		        <div class="span9 offset1">
		<?php
			
			$dataProvider = new CActiveDataProvider('Ou_structure',array('criteria'=>array(
                        'condition'=>'root=:root',
                        'params'=>array(':root'=>$root),
    
                    ),    ));
			
			//$dataProvider = Ou_structure::model()->findAll('orgId=:orgId',array('orgId'=>$orgId));
			$number = 0;
				$this->widget('bootstrap.widgets.TbGridView', array(
				
				'id'=>'gview',
				'dataProvider'=>$dataProvider,
				'rowHtmlOptionsExpression' => 'array("id"=>$data->id)',
				'columns'=>array(
    			array('name'=>'name','header'=>'Departments'),    /*in header give the role name while passing*/
	 			array('header'=>'Read','value'=>'','id'=>'headerA'),
	    		array(
	    		    
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'read',
	        		'selectableRows'=>2,
	    			'header'=>'Read',
	    		
	    		),    	
	    		array('header'=>'Write','value'=>'','id'=>'headerA'),
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
	
	
	<?php 
	
	/*	echo TbHtml::dropDownList('department','',CHtml::listData(Ou_structure::model()->findAll(),'id','name'),array(
		  'onKeyUp'=>CHtml::ajax(
		      array(
		      'type'=>'POST',
		      'dataType'=>'html',
		      'data'=>array(
		        'id'=>'js:department.value' 
		      ),
		      'update'=>'#user_select',
		      'url'=>Yii::app()->createUrl('create/searchajax'),
		      
		      )
		
		))
		);
	*/
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