<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	
	<link rel="stylesheet" type="text/css" href="/extensions/bootstrap/assets/css/bootstrap.min.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<style type="text/css">
	
		.nav-tabs .open .dropdown-toggle, .nav-pills .open .dropdown-toggle, 
	.nav > li.dropdown.open.active > a:hover, .nav > li.dropdown.open.active > a:focus{
	background-color:#fff;}

	.nav-tabs .open .dropdown-toggle, .nav-pills .open .dropdown-toggle, 
	.nav > li.dropdown.open.active > a:hover, .nav > li.dropdown.open.active > a:focus
	{
		color:#000 !important;
	}
	@media (min-width: 1200px)
	{
	.container{
	/* width :1100px;*/
	}
		
	};
	
	</style>
	
	
</head>


<body class="container" >

<?php Yii::app()->bootstrap->register(); ?>


<div class="container" id="page">

	<?php 
	$orgId = Yii::app()->user->getId();
	$record = Yii::app()->db->createCommand()
    ->select('orgName')
    ->from('organisation')    
    ->where('orgId=:orgId', array(':orgId'=>$orgId))
    ->queryRow();
	?>
	
	 
       <?php $this->widget('bootstrap.widgets.TbNavbar', array(
        'brandLabel' => 'MAM',
        //'display' => null, // default is static to top
        'color' => TbHtml::NAVBAR_COLOR_INVERSE,
        //'htmlOptions'=>array('class'=>'container'),
        'collapse' => true,
        'items' => array(
        	array(
        		'class' => 'bootstrap.widgets.TbNav',
        		//'options' =>('class'='nav navbar-nav navbar-right'),
        		'items'=>array(
					array('label'=>'Home', 'url'=>array('site/index')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Register(organisation)', 'url'=>array('/organisation/register1'),'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Organisations','url'=>array('/organisation/index'),'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest,'id'=>'Logindetail','htmlOptions'=>array('class'=>'pull-right')),
					
			),
        		
        		),
        	),
        )); ?>

<div class="span3 pull-right" style="margin-top:3em;text-transform:uppercase;font-weight:900;font-size:2em;color:maroon;">
	<?php echo $record['orgName'];?>
</div>

	<br/>
	<br/>
	<?php
      	$this->widget('SearchBlock', array(
      	)); ?>
	

<?php /*if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php 
	endif*/
	?>
 
<div style="margin-top:5em;">
	<?php

	
	//maintainence of the tabs according to roles and permissions
	
	if(!Yii::app()->user->isGuest){
	$id =  Yii::app()->user->getId();
	
	$uid = Yii::app()->user->getState("uid");
	$user = Users::model()->find('uid=:uid',array('uid'=>$uid));
	$roles=$user->Roles($uid);
	
	 
	echo TbHtml::tabs(array(
	array('label' => 'Home', 'url' => array('/asset/index')),
	array('label' => 'Add Asset', 'url' => '/final/asset/create'),
    array('label' => 'Check In', 'url' => array('/users/checkIn','id'=>Yii::app()->user->getState("uid"))),
    array('label' => 'Review', 'url' => array('/users/review','id'=>Yii::app()->user->getState("uid"))),
    array('label' => 'Advanced Search', 'url' => array('')),
    array('label' => 'Admin', 'items' => array(
        array('label'=>'Manage OU','items'=>array(	
    		array('label' => 'Manage Structure', 'url' => array('/ou_structure/tree'),'visible'=>$user->hasPrivilege("ou_structure/manage")),
    		array('label' => 'Reviewer', 'items'=>array(
    		    array('label'=>'Add Reviewer','url'=>array('/ou_structure/index'),'visible'=>$user->hasPrivilege("ou_structure/reviewerFind")),
    		)),
        )),
        array('label'=>'Parameters' , 'items'=>array(
	        array('label' => 'Category', 'items' => array(
	        	array('label' => 'Add Category', 'url' => array('/category/create'),'visible'=>$user->hasPrivilege("category/create")),
	        	array('label' => 'Manage Category', 'url' => array('/category/admin'),'visible'=>$user->hasPrivilege("category/admin")),
	        	array('label' => 'View Category', 'url' => array('/category/index'),'visible'=>$user->hasPrivilege("category/index")),
	       	)),
	        array('label' => 'Tags', 'items' => array(
	        	array('label' => 'Add Tags', 'url' => array('/tags/create'),'visible'=>$user->hasPrivilege("tags/create")),
	        	array('label' => 'Manage Tags', 'url' => array('/tags/admin'),'visible'=>$user->hasPrivilege("tags/admin")),
	        	array('label' => 'View Tags', 'url' => array('/tags/index'),'visible'=>$user->hasPrivilege("tags/index")),
	       	)),
	    )),   	
       	array('label' => 'Role', 'items' => array(
        	array('label' => 'Add Role', 'url' => array('/role/create'),/*'visible'=>$user->hasPrivilege("role/create")*/),
        	array('label' => 'Manage Role', 'url' => array('/role/admin'),/*'visible'=>$user->hasPrivilege("role/admin")*/),
        	array('label' => 'View Role', 'url' => array('/role/index'),/*'visible'=>$user->hasPrivilege("role/index")*/),
       	)),
       	array('label' => 'Users', 'items' => array(
        	array('label' => 'Add Users', 'url' => array('/users/create'),'visible'=>$user->hasPrivilege("users/create")),
        	array('label' => 'Manage Users', 'url' => array('/users/admin'),'visible'=>$user->hasPrivilege("users/admin")),
        	array('label' => 'View Users', 'url' => array('/users/index'),'visible'=>$user->hasPrivilege("users/index")),
        	array('label' => 'Confirm Users', 'url' => array('/users/confirm'),'visible'=>$user->hasPrivilege("users/confirm")),
       	)),
       	array('label' => 'Module', 'items' => array(
        	array('label' => 'Add Modules', 'url' => array('/module/create')),
        	array('label' => 'Manage Modules', 'url' => array('/module/admin')),
        	array('label' => 'View Modules', 'url' => array('/module/index')),
       	)),
       	array('label' => 'Permissions', 'items' => array(
        	array('label' => 'Add Permissions', 'url' => array('/permissions/create')),
        	array('label' => 'Manage Permissions', 'url' => array('/permissions/admin')),
        	array('label' => 'View Permissions', 'url' => array('/permissions/index')),
       	)),
        
    )),
	));
}
?>
</div>

<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    //'type'=>'inverse', // null or 'inverse'
    //'brand'=>'Project name',
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>'#', 'active'=>true),
                array('label'=>'Link', 'url'=>'#'),
                array('label'=>'Dropdown', 'url'=>'#', 'items'=>array(
                    array('label'=>'Action', 'url'=>'#'),
                    array('label'=>'Another action', 'url'=>'#'),
                    array('label'=>'Something else here', 'url'=>'#'),
                    '---',
                    array('label'=>'NAV HEADER'),
                    array('label'=>'Separated link', 'url'=>'#'),
                    array('label'=>'One more separated link', 'url'=>'#'),
                )),
            ),
        ),
        '<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Link', 'url'=>'#'),
                array('label'=>'Dropdown', 'url'=>'#', 'items'=>array(
                    array('label'=>'Action', 'url'=>'#'),
                    array('label'=>'Another action', 'url'=>'#'),
                    array('label'=>'Something else here', 'url'=>'#'),
                    '---',
                    array('label'=>'Separated link', 'url'=>'#'),
                )),
            ),
        ),
    ),
)); ?>


<?php echo $content; ?>	    
</div><!-- page -->
</body>
</html>