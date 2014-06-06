<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'permission-chnge',
	'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	//'enableClientValidation'=>true,
	//'clientOptions'=>array(
	//	'validateOnSubmit'=>true,
	//),
)); ?>


<?php
$model1 = Module::model()->findAll();
$number = 0;
 foreach ($model1 as $model2)
 {
 	$string = $model2->name;
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'gview',
	'selectableRows'=>2,
	'dataProvider'=>$dataProvider,

	'columns'=>array(
    	array('name'=>'name','header'=>$model2->name),    /*in header give the role name while passing*/
	    array(
	        'class'=>'CCheckBoxColumn',
	        'id'=>'CB'.$number,
	        //'id'=>'CB'.$model2->name,
	        'selectableRows'=>2,
	 
	        )    	
	      ),
   )
);
 $number++;
 }
?>

   <div class="row buttons" id="">
		<?php echo TbHtml::submitButton('Submit',array(
 			'name'=>'buttonUpdate',
			'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    ));?>
		<?php //echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('id'=>'B1')); ?>
		<?php echo TbHtml::submitButton(Yii::t('Yii','Cancel'),array(
 			'name'=>'buttonCancel',
			'color'=>TbHtml::BUTTON_COLOR_DANGER,
		    ));?>
		    
	
	
	</div>
         
		    
    <?php $this->endWidget(); ?>
    </div>
