<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<style type="text/css">
 	 .checkbox.inline + .checkbox.inline{
 	 margin-left:0px;
 	 padding-right:10px !important;}
 	 .checkbox{
 	 padding-right: 10px !important;
 	 width: 35%;}
</style>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'users-form',
	'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<?php echo $form->textFieldControlGroup($model, 'name',array('label'=>'Username','Placeholder'=>'Username')); ?>
	
	<?php echo $form->emailFieldControlGroup($model, 'email',array('label'=>'Email','Placeholder'=>'Valid email id',
		'help'=>'Please enter a freuently used email id')); ?>
	
	<?php echo $form->passwordFieldControlGroup($model, 'password',array('label'=>'Password','Placeholder'=>'Password',
		'help'=>'minimum 2 alphabets,2 numbers,a special character')); ?>
	
	<?php echo TbHtml::passwordFieldControlGroup('cpassword','',array('label'=>'Confirm Password','Placeholder'=>'Password')); ?>
	
	<script type="text/javascript">
	
   		if($('#Users_password').val()!=$('#cpassword').val()){
       	alert('Password not matches');
       	return false;
   		}
   	return true;
	</script>
	
	
	
	<?php echo $form->textFieldControlGroup($model,'mobile',array('label'=>'Phone','Placeholder'=>'Phone Number')); ?>
	
	<?php echo TbHtml::fileFieldControlGroup('picture','',array('label'=>'Photo'));?>
	
	<div class="span12">
	<div class="" style="margin-left:-2em">
		<?php echo TbHtml::inlinecheckBoxListControlGroup('roles','',array(
	  	 '1'=> 'Permission 1',
	  	  '2'=>'Permission 2',
	  	  '3'=>'Permission 3',
	  	  '4'=>'Permission 4',
	  	  '5'=>'Permission 5',
	  	  '6'=>'Permission 6',
	  	  
	  	  ), array('span'=>3,'label'=>'Roles','help' => '<strong>Note:</strong> Labels surround all the options for much larger click areas.')); ?>	 
	 </div>	 
	 </div>
	  <?php echo $form->radioButtonListControlGroup($model, 'status', array(
	  	  'Blocked',
	  	  'Active',
	  	  )); ?>

	
	    <?php
	    /*$this->widget(
	    	    'yiiwheels.widgets.fileupload.WhFileUpload',
	    	    array(
	    	    	    'name' => 'photo',
	    	    	    'url' => $this->createUrl('site/upload', array('type' => 'file')),
	    	    	    'multiple' => true,
	    	    	    )
	    	    );*/
	    ?>
	    <b></b><?php /*echo "Photo"?></b>
	    <?php
	        $this->widget('yiiwheels.widgets.fineuploader.WhFineUploader', array(
	        	'name' => 'fineuploadtest',
	        	'uploadAction' => $this->createUrl('site/upload', array()),
	        	'pluginOptions' => array(
	        		'validation'=>array(
	        			'allowedExtensions' => array('jpeg', 'jpg')
	        			)
	        		)
	        	));
	       */ ?>
	      
	
	
	<div class="row buttons" id="">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('id'=>'B1')); ?>
	</div>

	
	

	<?php $this->endWidget(); ?>

	</div><!-- form -->
	
	</fieldset>
	<script type="text/javascript">
	/*$(input['B1']).on('submit',function(){
   		if($('#Users_password').val()!=$('#cpassword').val()){
       	alert('Password not matches');
       	return false;
   		}
   	return true;
		});*/
	<script>
