<br/>
<?php

	
  $dept_id=$model->id;
   
   	   $dataProvider = new CActiveDataProvider('Users', array(
                                'criteria'=>array(
                        'condition'=>'ouId=:ouId',
                        'params'=>array(':ouId'=>$dept_id),
    
                    ),
	
                                'pagination'=>array(
                                                'pageSize'=>15,
                                )));
			
			//$dataProvider = Ou_structure::model()->findAll('orgId=:orgId',array('orgId'=>$orgId));
			$number = 0;
				$this->widget('bootstrap.widgets.TbGridView', array(
				//'selectionChanged' => 'updateUsersTable',
				'selectableRows' => 1,
				'id'=>'gview',
				'dataProvider'=>$dataProvider,
				'rowHtmlOptionsExpression' => 'array("uid"=>$data->uid)',
				'columns'=>array(
    			array('name'=>'name','header'=>'Users'),    //in header give the role name while passing
	 			array('header'=>'Read1','value'=>'','id'=>'headerA'),
	    		array(
	    		    
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'read',
	        		'selectableRows'=>2,
	    			'header'=>'Read',
	    		
	    		),    	
	    		array('header'=>'Write1','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'write',
	        		'selectableRows'=>2,
	    			'header'=>'Write',
	    		),
	    		array('header'=>'Edit1','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'edit',
	        		'header'=>'Edit',
	    			'selectableRows'=>2,
	    		),
	    		array('header'=>'Delete1','value'=>'','id'=>'headerA'),
	    		array(
	        		'class'=>'CCheckBoxColumn',
	        		'id'=>'delete',
	        		'selectableRows'=>2,
	    			'header'=>'Delete',
	    		)    	
	      ),
   		)
		);
   
 ?>
   
   
   

 
 