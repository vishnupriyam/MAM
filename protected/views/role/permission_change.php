<?php 
$this->widget('zii.widgets.grid.CGridView', array(
'id'=>'gview',
'selectableRows'=>2,
'dataProvider'=>$dataProvider,
	'columns'=>array(
    	array('name'=>'name','header'=>'Change permissions for Role'),    /*in header give the role name while passing*/
	    array(
	        'class'=>'CCheckBoxColumn',
	        'id'=>'CB',
	        'selectableRows'=>2,
	 
	        )    	
	      ),
   )
);

?>


        
        <div class="row buttons" id="">
		<?php echo TbHtml::submitButton(Yii::t('Yii','Update'),array(
 			'name'=>'buttonUpdate',
			'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    ));?>
		<?php //echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('id'=>'B1')); ?>
		<?php echo TbHtml::submitButton(Yii::t('Yii','Cancel'),array(
 			'name'=>'buttonCancel',
			'color'=>TbHtml::BUTTON_COLOR_DANGER,
		    ));?>
		    
	
	
	</div>
         
		    
    
    <div>
