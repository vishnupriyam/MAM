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
	      //  'selectableRows'=>2,
	  //  'selectableRows' => null,
	        /*'checkBoxHtmlOptions'=>array(
	            'uncheckValue'=>$data->reference, ),*/
	
	    )
	   // foreach ($options as $i=>$dataProvider)
        //{
       // echo CHtml::activeCheckBox($option,"[$i]optionid",array('checked'=>false,'value'=>$option->optionid)); 
        //}
    	),
   )
);

?>


        
        <?php 
        
     //   echo TbHtml::submitButton(Yii::t('Yii','submit'),array(
 		//	'name'=>'buttonSubmit',
			//'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    //));
		    ?>
		 <?php		 
	 	//echo TbHtml::activeCheckBox('a',"read",array('checked'=>false,'value'=>1)); 
         //echo TbHtml::activeCheckBox('b',"update",array('checked'=>false,'value'=>2)); 
         // echo TbHtml::activeCheckBox('c',"delete",array('checked'=>false,'value'=>3)); 
		 ?>
          
          <?php 
      //      echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array(
		//    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		//)); 
		?>
		<?php //echo TbHtml::submitButton(Yii::t('Yii','Cancel'),array(
 			//'name'=>'buttonCancel',
			//'color'=>TbHtml::BUTTON_COLOR_DANGER,
		 //   ));?>
         
		    
    
    <div>
<?php 
	//$a = Yii::app()->createUrl('/final/organisation/view');
	echo CHtml::ajaxLink('Update now',Yii::app()->createUrl('Organisation/regdone'),
	array('type'=>'POST',
	'dataType'=>'json',
	'data'=>'js:{theIds : $.fn.yiiGridView.getChecked("gview","CB").toString()}'
	),
	array('href'=>Yii::app()->createUrl( 'Organisation/regdone')),
	 array('http://localhost/final/index.php/users/regdone'));
	?>

</div>
