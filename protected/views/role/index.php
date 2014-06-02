<?php
/* @var $this RoleController */
/* @var $dataProvider CActiveDataProvider */
?>

<style type="text/css">

 .summary{
 display:none;}
 
  .table{
  margin-bottom:0px;}

</style>

<?php
$this->breadcrumbs=array(
	'Roles',
);


$this->menu=array(
	array('label'=>'Create Role','url'=>array('create')),
	array('label'=>'Manage Role','url'=>array('admin')),
);
?>

<h1>Roles</h1>

<?php $gridColumns = array(
			/*array('name'=>'rid', 'header'=>'Role_id'),*/
			array('name'=>'name', 'header'=>'ROLE'),
			array('name'=>'weight','header'=>'PERMISSIONS','type'=>'raw', 
			'value'=>'CHtml::link("Edit permissions", array("role/permission_change"))'),
			array('name'=>'weight','header'=>'PERMISSIONS','type'=>'raw', 
			'value'=>'CHtml::link("Edit Role", array("role/", "update"=>$data->rid))'),
);?>


<?php $this->widget('bootstrap.widgets.TbGridView1',array(
	'type'=>TbHtml::GRID_TYPE_HOVER,
	'dataProvider'=>$dataProvider,
	/*'itemView'=>'_view',*/
	'columns'=>$gridColumns,
)); ?>



<?php echo TbHtml::beginFormTb(TbHtml::FORM_LAYOUT_INLINE); ?>
    <?php echo TbHtml::textfield('name','',array('span'=>2)); ?>
    <?php echo CHtml::link("Add Role",array("role/create")); ?>
<?php echo TbHtml::endForm(); ?>
