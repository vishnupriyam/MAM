<?php
/* @var $this AssetController */
/* @var $model Asset */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'asset-checkInform2-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	
	   <?php echo CHtml::FileField('file', '');?>

       <?php echo CHtml::button('Submit', array('submit' => array('Asset/checkInform2','id'=>'submitButton')));?>
    
<?php $this->endWidget(); ?>

</div><!-- form -->
