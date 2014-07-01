<?php
/* @var $this Category1Controller */
/* @var $model Category1 */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php /*echo $form->textFieldControlGroup($model,'cat_id',array('span'=>5));*/ ?>

                    <?php echo $form->textAreaControlGroup($model,'name',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'orgId',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'DName',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->