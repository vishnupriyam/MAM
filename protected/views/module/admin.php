<?php 
$this->widget('zii.widgets.grid.CGridView', array(
'id'=>'gview',
'selectableRows'=>2,
'dataProvider'=>$model->search(),
'columns'=>array(
    array('name'=>'name','header'=>'MODULE'),    /*in header give the role name while passing*/
    array(
        'class'=>'CCheckBoxColumn',
        'id'=>'CB',
        //'selectableRows'=>2,
        /*'checkBoxHtmlOptions'=>array(
            'uncheckValue'=>$data->reference, ),*/

    )),));
    ?>
    <?php 
	//$a = Yii::app()->createUrl('/final/organisation/view');
	echo CHtml::ajaxLink('Update now',Yii::app()->createUrl('Organisation/regdone'),
	array('type'=>'POST',
	'dataType'=>'json',
	'data'=>'js:{theIds : $.fn.yiiGridView.getChecked("gview","CB").toString()}'
	),
	array('href'=>Yii::app()->createUrl( 'Organisation/regdone')),
	 array('http://localhost/final/index.php/Organisation/regdone'));
	?>

</div>


