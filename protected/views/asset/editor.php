
<?php
/* @var $this PermissionsController */
/* @var $model Permissions */
/* @var $form TbActiveForm */
?>

<style type="text/css">
	input[type=text], input[type=password] {
    width: 6em;
}
	
    select{
    	width:6em;
    }	
    

</style>

<div style="width: 1100px;" >

<div class="form" style="float:left;border-right:1px dotted black;" class="span6">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'editor-form',
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    		'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php

echo "Edit your image online"
?>

    
<br/>
<br/>

<?php 
	  //  echo $form->textFieldControlGroup($model, 'size',array('label'=>'X co-ordinate','Placeholder'=>'X co-ordinate')); 
	  //  echo CHtml::textField('Attribute[flip]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'angle')); 
	    echo CHtml::dropDownlist('side', 'side', array(1=>'anticlockwise',2=>'clockwise'),array('selected'=>true));
		echo "<br/>";
	    echo TbHtml::submitButton('Flip',array(
			'name'=>'flip',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?><br/><?php 
		echo CHtml::textField('Attribute[crop_x]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'x co-ordinate')); 
		echo CHtml::textField('Attribute[crop_y]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'y co-ordinate')); 
		echo "<br/>";
		echo TbHtml::submitButton('Crop',array(
			'name'=>'crop',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?><br/><?php 
		echo CHtml::textField('Attribute[resize_x]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'x co-ordinate')); 
		echo CHtml::textField('Attribute[resize_y]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'y co-ordinate'));
		echo "<br/>";
		echo TbHtml::submitButton('Resize',array(
			'name'=>'resize',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?><br/><?php 
		echo CHtml::textField('Attribute[rotate]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'angle')); 
		echo "<br/>";
		echo TbHtml::submitButton('Rotate',array(
			'name'=>'rotate',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?><br/><?php 
		echo CHtml::textField('Attribute[quality]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'angle')); 
		echo "<br/>";
		echo TbHtml::submitButton('Quality',array(
			'name'=>'quality',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?><br/><?php 
		echo CHtml::dropDownlist('format', 'format', array(1=>'png',2=>'gif',3=>'jpg',4=>'bmp'),array('selected'=>true));
		echo "<br/>";
		echo TbHtml::submitButton('Convert',array(
			'name'=>'convert',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		));  ?><br/><?php 
		echo CHtml::textField('Attribute[brightness]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'brightness')); 
		echo "<br/>";
		echo TbHtml::submitButton('Brightness',array(
			'name'=>'brightness',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?><br/><?php 
		echo CHtml::textField('Attribute[contrast]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'contrast')); 
		echo "<br/>";
		echo TbHtml::submitButton('Contrast',array(
			'name'=>'contrast',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?><br/><?php 
		echo CHtml::textField('Attribute[text]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'text')); 
		echo CHtml::textField('Attribute[text_color]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'text color')); 
		echo "<br/>";
		echo CHtml::textField('Attribute[text_x]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'text x position')); 
		echo CHtml::textField('Attribute[text_y]', '', array('size'=>60,'maxlength'=>128, 'placeholder'=>'text y position')); 
		echo "<br/>";
		echo TbHtml::submitButton('Add Text to image',array(
			'name'=>'text',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); 
		?><br/>
		
		
		<?php 
		echo TbHtml::submitButton('Negative',array(
			'name'=>'negative',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		));	
	
	
		?>
</div>
<?php 
$orgId = Yii::app()->user->getId();
$catid = $model->categoryId;
$file = $model->assetId;
if(($pos=strrpos($model->file,'.'))!==false)
  		$ext=substr($model->file,$pos+1);
$path = "http://localhost/final/upload/".$orgId.'/'.$catid.'/'.$file.'_1.'.$ext;

?>
<div class="span6" style="float: right;">
<div style="padding-top:7em;">
<?php ?>
<div class="thumbnail">
<img id = "image" src = "<?php echo $path;?>">
</div> 
</div>
<div>
<?php
echo TbHtml::submitButton('Save',array(
			'name'=>'save',
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?>
	
	<?php 

?>
		<?php  echo TbHtml::submitButton(Yii::t('Yii','Cancel'),array(
 			'name'=>'buttonCancel',
			'color'=>TbHtml::BUTTON_COLOR_DANGER,
		    ));
		    ?>
	</div>	     
</div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">

var c=document.getElementById("canvas");
var ctx=c.getContext("2d");
var img=document.getElementById("image");
ctx.drawImage(img,0,0);

</script>

