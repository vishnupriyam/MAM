<?php

//for error reports of asset views
error_reporting(E_ALL ^ ~E_NOTICE  ^ ~E_WARNING);

class AssetController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','properties','infoOptions','history','admin','versionViewUpdate','userTable','download','infoOptionsViewUpdate','downloadVersion'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update',  'viewer','editor','checkOut','checkOutAsset','checkIn','checkInform','reviewAssetDetails','authorizeOrReject','checkInform2'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{	
		//RBAC - check whether the logged in user has access rights to create asset
		if(!Yii::app()->user->checkAccess('create'))
 
		$model=new Asset;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		$modelUsers = new Users('search');
		
		//get the attributes of Users model for access permissions read, write etc
		//unsetting modelUsers attributes 
		$modelUsers->unsetAttributes();
		
		//get attributes from the asset form
		if (isset($_GET['Users'])) {
			$modelUsers->attributes=$_GET['Users'];
		}
		
		//get the asset attributes from asset create form
		if (isset($_POST['Asset'])) {
			
			$model->attributes=$_POST['Asset'];  //setting the attributes

			$model->file=CUploadedFile::getInstance($model,'file'); //getting the uploaded file instance 
						
			//variables defnitions to place the file at the path baseUrl/upload/orgId/categoryId/assetId.dat
			$uid = Yii::app()->user->getState("uid"); 
			$user = Users::model()->find('uid=:uid',array(':uid'=>$uid));
			$model->categoryId = $_POST['Asset']['categoryId'];
			$model->departmentId = $user->ouId;
			
			//reviewer assignment for the asset from table ReviewerOuStructure
			$reviewerOustructure = ReviewerOustructure::model()->find('ouId=:ouId',array(':ouId'=>$model->departmentId));
			$model->reviewer = $reviewerOustructure->uId;
			
			$model->orgId = Yii::app()->user->getId();  //asset organisation Id assignment
			
			if(!empty($_POST['tags']))
			{
				$tags = $_POST['tags'];  //assigning tags checked by user to variable "$tags" 
			}
			
			if ($model->save()) {
				
			
				$orgId=Yii::app()->user->getId();
				$fileName=$model->assetId.'.dat';    //naming the entered file as assetId.dat 
				$categoryId=$_POST['Asset']['categoryId'];
				$old = umask(0);
				
				$file = $model->file;
				if(($pos=strrpos($file,'.'))!==false)
  					$ext=substr($file,$pos+1);
				
				
				$fileName1=$model->assetId.'_0'.'.dat'; //fileName for version maintenance 

				//make directory at required path if not exists for current version save (Directory - baseUrl/upload/organisationId/categoryId)
				if (!is_dir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/' )) {
                	mkdir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/',0777 ,true);
				}
				umask($old);

				//make directory at required path if not exists for saving various versions (Direcory - baseUrl/upload/organisationId/categoryId/assetId)
				if (!is_dir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/'.$model->assetId.'/')) {
                	mkdir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/'.$model->assetId.'/',0777 ,true);
				}
				
				//file saveAs at current position, 
				$model->file->saveAs(Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$fileName);
				
				//maintenece of original file for versioning
				copy($folder .Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'.dat' ,
      				Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'/'.$model->assetId.'_0'.'.dat'  );
				
				//maintenece of original file for search and viewer
				/*copy($folder .Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'.dat' ,
				Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->file);
				*/
      				
      			copy($folder .Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'.dat' ,
				Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'.'.$ext);
				
				copy($folder .Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'.dat' ,
				Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'/'.$model->assetId.'_0'.'.'.$ext);	
				
				
				//updates the fileaccesslog
				$command = Yii::app()->db->createCommand();
				$command->insert('fileaccesslog', array(
    					'action'=>'I',
    					'assetId'=>$model->assetId,
						'uId'=> Yii::app()->user->getState("uid"),
					));
					
				//update the asset_revision	
				$command->insert('asset_revision', array(
    					'assetId'=>$model->assetId,
						'modifiedBy'=> Yii::app()->user->getState("uid"),
						'note'=>'intial commit',
						'revision'=>0,
						
					));
				
				//update assetTags table
				if(!empty($_POST['tags'])){
				$tag = $_POST['tags'];
				foreach($tag as $tagRow){
					$AssetTag = new AssetTags;
            	    $AssetTag->assetId = $model->assetId;
            	    $AssetTag->tagId = $tagRow ;
                	$AssetTag->save();
       			}}
				
       			//Addition of the users defined tags in tags table
       			if(!empty($_POST['Asset']['tagsUser'])){
       			$tagsUser=explode(",",$_POST['Asset']['tagsUser']);
       			foreach($tagsUser as $tagsRow){
					$Tags = new Tags;
            	    $Tags->tagName = $tagsRow;
            	    $Tags->orgId  = Yii::app()->user->getId();
                	$Tags->save();
                	$AssetTag1 = new AssetTags;
                	$AssetTag1->assetId = $model->assetId;
                	$AssetTag1->tagId = $Tags->tagId;
                	$AssetTag1->save();
                	
       			}
       			}
				
       			//applying the read permissions to all checked departments from asset form,AssetOuFilep table
				if(!empty($_POST['read'])){
				$read = $_POST['read'];
				foreach($read as $readRow){
					$AssetOuFilep = new AssetOuFilep;
        	        $AssetOuFilep->assetId = $model->assetId;
            	    $AssetOuFilep->ouId = $readRow;
            	    $AssetOuFilep->fpId = 0;
                	$AssetOuFilep->save();
       			}}

       			//applying the write permissions to all checked departments from asset form
       			if(!empty($_POST['write'])){
				$write = $_POST['write'];
       			foreach($write as $writeRow){
					$AssetOuFilep = new AssetOuFilep;
        	        $AssetOuFilep->assetId = $model->assetId;
            	    $AssetOuFilep->ouId = $writeRow;
            	    $AssetOuFilep->fpId = 1;
                	$AssetOuFilep->save();
       			}}
       			
				//applying the edit permissions to all checked departments from asset form
				if(!empty($_POST['edit'])){
				$edit = $_POST['edit'];
				foreach($edit as $editRow){
					$AssetOuFilep = new AssetOuFilep;
        	        $AssetOuFilep->assetId = $model->assetId;
            	    $AssetOuFilep->ouId = $editRow;
            	    $AssetOuFilep->fpId = 2;
                	$AssetOuFilep->save();
       			}}

       			//applying the edit permissions to all checked departments from asset form,Data:AssetOuFilep
				if(!empty($_POST['delete'])){
				$delete = $_POST['delete'];
				foreach($delete as $deleteRow){
					$AssetOuFilep = new AssetOuFilep;
        	        $AssetOuFilep->assetId = $model->assetId;
            	    $AssetOuFilep->ouId = $editRow;
            	    $AssetOuFilep->fpId = 3;
                	$AssetOuFilep->save();
       			}}
       			
       			
       			
       			//applying the read permissions to all checked users from asset form,Data:AssetUserfilep
				if(!empty($_POST['Aread'])){
				$read = $_POST['Aread'];
				foreach($read as $readRow){
					$command = Yii::app()->db->createCommand();
					$command->insert('asset_user_filep', array(
    					'assetId'=>$model->assetId,
						'uId'=>$readRow,
						'fpId'=>0,
					));
				}}

       			//applying the write permissions to all checked users from asset form,Data:AssetUserfilep
       			if(!empty($_POST['Awrite'])){
				$write = $_POST['Awrite'];
       			foreach($write as $writeRow){
					$command = Yii::app()->db->createCommand();
					$command->insert('asset_user_filep', array(
    					'assetId'=>$model->assetId,
						'uId'=>$writeRow,
						'fpId'=>1,
					));
       			}}
       			
				//applying the edit permissions to all checked users from asset form,Data:AssetUserfilep
				if(!empty($_POST['Aedit'])){
				$edit = $_POST['Aedit'];
				foreach($edit as $editRow){
					$command = Yii::app()->db->createCommand();
					$command->insert('asset_user_filep', array(
    					'assetId'=>$model->assetId,
						'uId'=>$editRow,
						'fpId'=>2,
					));
       			}}

       			//applying the delete permissions to all checked users from asset form,Data:AssetUserfilep
				if(!empty($_POST['Adelete'])){
				$delete = $_POST['Adelete'];
				foreach($delete as $deleteRow){
					$command = Yii::app()->db->createCommand();
					$command->insert('asset_user_filep', array(
    					'assetId'=>$model->assetId,
						'uId'=>$editRow,
						'fpId'=>3,
					));
       			}}
       			
       			
			}

			//redirect to users to view asset after asset submission form
			$this->redirect(array('view','id'=>$model->assetId));
		}
		
		//renders create form
		$this->render('create',array(
			'model'=>$model,'modelUsers'=>$modelUsers,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		 $modelUsers = new Users('search');
		
		//get the attributes of Users model for access permissions read, write etc
		//unsetting modelUsers attributes 
		$modelUsers->unsetAttributes();
		
		//get attributes from the asset form
		if (isset($_GET['Users'])) {
			$modelUsers->attributes=$_GET['Users'];
		}
		 
		 
		if (isset($_POST['Asset'])) {
			$model->attributes=$_POST['Asset'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->assetId));
			}
		}

		$this->render('update',array(
			'model'=>$model,'modelUsers'=>$modelUsers,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$model=new Asset('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Asset'])) {
			$model->attributes=$_GET['Asset'];
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Asset('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Asset'])) {
			$model->attributes=$_GET['Asset'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Asset the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Asset::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
	
	/**
	 * view the asset on online viewer 
	 */
	public function actionViewer($id)
	{
		$model= $this->loadModel($id);
		
		 $this->render('viewer', array('model'=>$model));
		//$this->render('viewer', array('a'=>$id));
	}

	/** 
	 * actioneditor is for image manipulation
	 * crop,resize,rotate,convert format,quality,brightness,contreast,add text on image  
	 * Using imagemagick software 
	 * Image magick path defined in main.php
	 */

	public function actionEditor($id)
	{
		$model= $this->loadModel($id);
		$count = 0;
		$name = $model->file;
		$catid = $model->categoryId;
	
		$orgId = Yii::app()->user->getId();
 		$catid = $model->categoryId;
 		$file = $model->file;
		if(($pos=strrpos($file,'.'))!==false)
  			$ext=substr($file,$pos+1);
  			
  		$file=$model->assetId;
  		
  		if(!isset($_POST['save'])){
  		//maintenece of original file for versioning
  		copy($folder .Yii::app()->basePath.'/../upload/'.$orgId.'/'.$catid.'/'.$file.'.'.$ext,
  		Yii::app()->basePath.'/../upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
  		}
  		
  		$image=Yii::app()->image->load('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
		//$handle=new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'.'.$ext);

		//flip image horizontally or vertically
		if(isset($_POST['flip']))
        {
		  $a = $_POST['side'];
		  $handle=new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
		  if ($a == 1)
		  $handle->image_filp='h';
		  else if ($a == 2)
		  $handle->image_flip='v';
		  //save into category id folder
		  $handle->process('upload/'.$orgId.'/'.$catid.'/');
		 
		  $count = 1;
        }
      
		//convert the image format from one type to another
        if(isset($_POST['convert']))
        {
        	$handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
	 		if ($handle->uploaded) {
	 			$a = $_POST['format'];
	 			if ($a == 1)
	 			$handle->image_convert = 'png';
	 			else if ($a == 2)
	 			$handle->image_convert = 'jpg';
	 			else if ($a == 3)
	 			$handle->image_convert = 'gif';
	 			else if ($a == 4)
	 			$handle->image_convert = 'bmp';
	 			$handle->process('upload/'.$orgId.'/'.$catid.'/');
	 			//echo 'converted';
	 		}
        }
        
		//convert the image into negative
		if(isset($_POST['negative']))
        {
        	$handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
	 		if ($handle->uploaded) { 
	 			$handle->image_negative = true;
	 			$handle->process('upload/'.$orgId.'/'.$catid.'/');
	 		}
        }
        //set the image brightness
		if(isset($_POST['brightness']))
        {
        	$a = $_POST['Attribute']['brightness'];
		 	 $b = (int)$a;
        	$handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
	 		if ($handle->uploaded) {
	 			$handle->image_brightness = $a;
	 			$handle->process('upload/'.$orgId.'/'.$catid.'/');
	 		}
	 		
        }
        
		//set the image contrast
		if(isset($_POST['contrast']))
        {
        	$a = $_POST['Attribute']['contrast'];
		  	$b = (int)$a;
        	$handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
	 		if ($handle->uploaded) {
	 			$handle->image_brightness = $a;
	 			$handle->process('upload/'.$orgId.'/'.$catid.'/');
	 		}
        }
        
		//add text on image ,set text color,text position
        if(isset($_POST['text']))
        {
        	$a = $_POST['Attribute']['text'];
		   $b = $_POST['Attribute']['text_color'];
		   $c = $_POST['Attribute']['text_x'];
		   $d = $_POST['Attribute']['text_y'];
        	$handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
	 		if ($handle->uploaded) {
	 			$handle->image_text = $a;
	 		    $handle->image_text_color = $b;
	 			$handle->image_text_x = (int)$c;
	 			$handle->image_text_y = (int)$d; 
	 			$handle->process('upload/'.$orgId.'/'.$catid.'/');
	 		}
        }
       
       
		//crop image by giving the value of x and y axis
		if(isset($_POST['crop']))
        {
        	 $a = $_POST['Attribute']['crop_x'];
		  $b = (int)$a;
		  
		   $c = $_POST['Attribute']['crop_y'];
		  $d = (int)$c;
		  $handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
		  $handle->image_crop =true;
		  $hanle->image_x=$b;
		  $hanlde->image_y=$d;
     
		  $handle->process('upload/'.$orgId.'/'.$catid.'/');
          $count = 1;
        }
        
		//resize the image
        if(isset($_POST['resize']))
        {
        	$a = $_POST['Attribute']['resize_x'];
        	$b = (int)$a;
        
        	$c = $_POST['Attribute']['resize_y'];
        	$d = (int)$c;
        	$handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
        
        	$handle->image_resize         = true;
        	$handle->image_x              = $b;
        
        	$handle->image_y              = $d;
        	 
        	$handle->process('upload/'.$orgId.'/'.$catid.'/');
        
        	$count = 1;
        }
        
		//rotate image in clockwise or anticlockwise direction
        if(isset($_POST['rotate']))
        {
        	$a = $_POST['Attribute']['rotate'];
        	$b = (int)$a;
        	$handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
        	$handle->image_rotate = $b;
        	$handle->process('upload/'.$orgId.'/'.$catid.'/');
        	$count = 1;
        }
        
         
        //set the quality for image
        if(isset($_POST['quality']))
        {
        	$a = $_POST['Attribute']['quality'];
        	$b = (int)$a;
        	$handle = new upload('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
        	$handle->jpeg_quality = $b;
        	$handle->process('upload/'.$orgId.'/'.$catid.'/');
        	 
        
        	$count = 1;
        }
		
		//save all the changes and create version of the images and save it in assetid 
      	      	
	    if(isset($_POST['save']))
        {
      	
      		$count = 1;
        
			if ($count == 1){

        	$image->save('upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext);
        	
        	copy($folder .Yii::app()->basePath.'/../upload/'.$orgId.'/'.$catid.'/'.$file.'_1.'.$ext,
  				Yii::app()->basePath.'/../upload/'.$orgId.'/'.$catid.'/'.$file.'.'.$ext);
  		
        	
        	/*$image->save('upload/'.$orgId.'/'.$catid.'/'.$file.'.'.$ext);
        	$image->save('upload/'.$orgId.'/'.$catid.'/'.$file.'.dat');
        	*/
        	//versioning of the file
        	$records = AssetRevision::model()->findAll('assetId=:assetId',array('assetId'=>$file));
        	$presentNumber = count($records);
        	$image->save('upload/'.$orgId.'/'.$catid.'/'.$file.'/'.$file.'_'.$presentNumber.'.'.$ext);
        	$image->save('upload/'.$orgId.'/'.$catid.'/'.$file.'/'.$file.'_'.$presentNumber.'.dat');
        	
        	//changing the status of the asset to not reviewed
        	$command = Yii::app()->db->createCommand();
        		$command->update('asset', array(
   				 'status'=>0,
				), 'assetId=:assetId', array(':assetId'=>$file));
        		
        	
        	//inserting new record to asset revision
				$command->insert('asset_revision', array(
    					'assetId'=>$file,
						'modifiedBy'=> Yii::app()->user->getState("uid"),
						'note'=>'image editor',
						'revision'=>$presentNumber,
						
					));
				
        	//updates the fileaccesslog
				$command = Yii::app()->db->createCommand();
				$command->insert('fileaccesslog', array(
    					'action'=>'CO_IE',
    					'assetId'=>$file,
						'uId'=> Yii::app()->user->getState("uid"),
					));
				
			} 
		}		
		if(isset($_POST['buttonCancel']))
        {
         	unlink(Yii::app()->basePath.'/../upload/');
        	$this->redirect(Yii::app()->homeUrl);
        }
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('editor', array('a'=>$id, 'model'=>$model,));
	}
			
	
	/**
	 * Performs the AJAX validation.
	 * @param Asset $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='asset-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * 
	 * Renders the page with all properties of the asset
	 * @param integer $id the ID of the model to be loaded
	 */
	public function actionProperties($id){
		
		$model=$this->loadModel($id);
		
		$this->render('properties',
		 array('model'=>$model)
		);
	}
	
	/**
	 * 
	 * List all information about the model
	 * @param integer $id the ID of the model to be loaded
	 */
	public function actionInfoOptions($id){
		
		$model=$this->loadModel($id);
		
		$this->render('infoOptions',
		 array('model'=>$model)
		);
	}
	
	/**
	 * 
	 * Delivers the view with all information of the asset to be reviewed
	 * @param integer $id the Id of the model to be loaded
	 */
	
	public function actionReviewAssetDetails($id){
		
			$model=$this->loadModel($id);
		
			$this->render('reviewAssetDetails',
		 	array('model'=>$model)
			);
	}
	
	/**
	 * 
	 * History ie versions and its details of the asset
	 * @param integer $id the ID of the model to be loaded
	 */
	public function actionHistory($id){
		$model=$this->loadModel($id);
		
		$this->render('history',
		 array('model'=>$model)
		);
		
	}
	
	/**
	 * 
	 * Function to redirect to required view according to the ajax call from the history.php
	 * @param integer $id the ID of the model to be loaded here assetId
	 */
	public function actionVersionViewUpdate($id = null) {
		$model = AssetRevision::model()->findByPk($id); //load the model  
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
 
        //render the assetRevision view    
        $this->renderPartial('../AssetRevision/view', array('model' => $model));
        Yii::app()->end();
	}

	/**
	 * 
	 * Function called after the ajax call from asset index page to view information of that particular asset
	 * @param integer $id the Id of the model to be loaded
	 */
	public function actionInfoOptionsViewUpdate($id = null) {
		$model = Asset::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
 
        $this->renderPartial('infoOptions', array('model' => $model));
        Yii::app()->end();
	}
	
	
	/**
	 * 
	 * Download the required asset
	 * @param integer $id the ID of model to be loaded
	 */
	public function actionDownload($id){
	
		$model = $this->loadModel($id);
	
		
		if (isset($_SERVER['HTTP_RANGE'])) 
			$range = $_SERVER['HTTP_RANGE'];
			
			//get the directory path
			$dir_path = Yii::getPathOfAlias('webroot') .'/upload/'.Yii::app()->user->getId().'/'.$model->categoryId.'/';
		
			//set filePath
			$filePath=$dir_path.$id.'.dat';
			if (file_exists($filePath))
    		{
        		
    			//updates the fileaccesslog
				$command = Yii::app()->db->createCommand();
				$command->insert('fileaccesslog', array(
    					'action'=>'D',
    					'assetId'=>$model->assetId,
						'uId'=> Yii::app()->user->getState("uid"),
					));
				
    			
    			// send headers to browser to initiate file download
        		header ('Content-Type: application/octet-stream');
        		header("Content-Type: text/plain",false);
			    header("Content-Type: image/png",false);
			    header("Content-Type: image/jpg",false);
			    header("Content-Type: image/jpg",false);
			    header("Content-Type: application/pdf",false);
			    header("Content-Type: application/octet-stream",false);
			    header("Content-Type: application/zip",false);
			    header("Content-Type: application/msword",false);
			    header("Content-Type: application/vnd.ms-excel",false);
			    header("Content-Type: application/vnd.ms-powerpoint",false);
			    header("Content-Type: application/force-download",false);
			    header("Content-Type: video/mp4");
			    header("Content-Type: audio/mpeg");
			    header("Content-Type: video/x-msvideo");
			    header("Content-Type: video/3g2");
			    header("Content-Type: video/avi");
  				header("Content-Type: video/mp4");
  				header("Content-Type: video/asf");
			    header("Content-Type: video/quicktime");
                header("Content-Type: video/3gpp");
    		    header("Content-Type:text/html");
                header("Content-Type: video/asf");
                header("Content-Type: text/plain");
                header("Content-Type: image/pdf");
		        header("Content-Type: application/x-pdf");
		        header("Content-Type: application/msword");
		        header("Content-Type: image/pjpeg");
		        header("Content-Type: application/msexcel");
		        header("Content-Type: application/msaccess");
		        header("Content-Type: text/richtxt");
		        header("Content-Type: application/mspowerpoint");
		        header("Content-Type: application/x-zip-compressed");
		        header("Content-Type: application/zip");
		        header("Content-Type:  image/tiff");
		        header("Content-Type: image/tif");
		        header("Content-Type: application/vnd.ms-powerpoint");
		        header("Content-Type: application/vnd.ms-excel");
		        header("Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation");
		        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
		        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
				header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		        header("Content-Type: application/vnd.oasis.opendocument.chart");
		        header("Content-Type:  application/vnd.oasis.opendocument.chart-template");
		  		header("Content-Type: application/vnd.oasis.opendocument.formula");
		        header("Content-Type: application/vnd.oasis.opendocument.formula-template");
		        header("Content-Type: application/vnd.oasis.opendocument.graphics");
		        header("Content-Type: application/vnd.oasis.opendocument.graphics-template");
		        header("Content-Type: application/vnd.oasis.opendocument.image");
		        header("Content-Type: application/vnd.oasis.opendocument.image-template");
		        header("Content-Type: application/vnd.oasis.opendocument.presentation");
		        header("Content-Type: application/vnd.oasis.opendocument.presentation-template");
		        header("Content-Type: application/vnd.oasis.opendocument.spreadsheet");
		        header("Content-Type: application/vnd.oasis.opendocument.spreadsheet-template");
		        header("Content-Type: application/vnd.oasis.opendocument.text");
		        header("Content-Type: application/vnd.oasis.opendocument.text-master");
		        header("Content-Type: application/vnd.oasis.opendocument.text-template");
		        header("Content-Type: application/vnd.oasis.opendocument.text-web");
		        header("Content-Type: text/csv");
	            header("Content-Type: image/x-dwg");
	            header("Content-Type: image/x-dfx");
	            header("Content-Type: drawing/x-dwf");
	            header ('Content-Disposition: attachment; filename="' . $model->file . '"');
        		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        		header('Pragma: public');
        		readfile($filePath);
        		
           }
   		 else
    		{
        		echo 'File does not exist...'; //if file doesn't exist
    		}
			
	  }

	  /**
	   * 
	   * View for asset to be checked out
	   * @param integer $id the ID od model to be loaded
	   */
	  public function actionCheckOut($id){
			$model=$this->loadModel($id);
			
			$this->render('checkOut',
		 	array('model'=>$model)
		);  	
	  }
	  
	  /**
	   * 
	   * Download the file and changes the status of the file
	   * @param integer $id the ID of the model to be loaded
	   */
	  
	  public function actionCheckOutAsset($id){
	
		$model = $this->loadModel($id);
		if (isset($_SERVER['HTTP_RANGE'])) 
			$range = $_SERVER['HTTP_RANGE'];
			
			//get the directory path
			$dir_path = Yii::getPathOfAlias('webroot') .'/upload/'.Yii::app()->user->getId().'/'.$model->categoryId.'/';
		
			$filePath=$dir_path.$id.'.dat';
			if (file_exists($filePath))
    		{
    			
    			$command = Yii::app()->db->createCommand();
        		$command->update('asset', array(
   				 'status'=>2,
				), 'assetId=:assetId', array(':assetId'=>$model->assetId));
        		
        		// send headers to browser to initiate file download
        		header ('Content-Type: application/octet-stream');
        		header ('Content-Disposition: attachment; filename="' . $model->file . '"');
        		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        		header('Pragma: public');
        		readfile($filePath);
        		
        		//updates the fileaccesslog
				$command = Yii::app()->db->createCommand();
				$command->insert('fileaccesslog', array(
    					'action'=>'CO',
    					'assetId'=>$model->assetId,
						'uId'=> Yii::app()->user->getState("uid"),
					));
        		
				
           }
   		 else
    		{	//if file does not exist
        		echo 'File does not exist...';
    		}
			
	  }
	  
		/**
		 * 
		 * Authorize or reject the asset 
		 * @param integer $id the ID of the model to be loaded
		 */
	  public function actionAuthorizeOrReject($id)
		{
    		$model=$this->loadModel($id);

    		// uncomment the following code to enable ajax-based validation
    		/*
    		if(isset($_POST['ajax']) && $_POST['ajax']==='asset-authorizeOrReject-form')
    		{
        		echo CActiveForm::validate($model);
        		Yii::app()->end();
    		}
    		*/
    		
    		
			//change asset status to authorised on authorise 
    		if(isset($_POST['buttonAuthorize']))
    		{
   
    			//change status of the asset to reviewed
        		{
            		$command = Yii::app()->db->createCommand();
					$command->update('asset', array(
   				 	'status'=>1,
						), 'assetId=:assetId', array(':assetId'=>$model->assetId));
						
					//send maiil on successful authorization of the asset
					$to="mvpno1994@gmail.com";
					$from="selvarani@iitb.ac.in";
					$subject="Article authorized";
					$message="The article so and so has been authorized by the reviewer and its available for view and download";
					$this->mailsend($to,$from,$subject,$message);
			    	
        			$this->redirect(array("/users/review/".Yii::app()->user->getState("uid")));
        		}
        		 
        		
    		}
    		
    		//change asset status to rejected on reject 
    		if(isset($_POST['buttonReject']))
    		{
        		 
        		{
            		// form inputs are valid, do something here
            		$command = Yii::app()->db->createCommand();
					$command->update('asset', array(
   				 	'status'=>5,
						), 'assetId=:assetId', array(':assetId'=>$model->assetId));
        			
					//send maiil on successful authorization of the asset
					$to="mvpno1994@gmail.com";
					$from="selvarani@iitb.ac.in";
					$subject="Article rejected";
					$message="The article so and so has been rejected by the reviewer and its available for view and download";
					$this->mailsend($to,$from,$subject,$message);
			    	
            		$this->redirect(array("/users/review/".Yii::app()->user->getState("uid")));
        		}
    		}
    		$this->render('authorizeOrReject',array('model'=>$model));
		}
		
		
	/**
	 * renders the checkInform
	 * @param integer $id the ID to load the model
	 */	
	public function actionCheckInform2($id)
		{
			//loads the particular model
			$model = $this->loadModel($id);
		
 			//on submit button the file is saved
			if(isset($_POST['buttonSubmit'])){
				//if file errors are present
				if ($_FILES["file"]["error"] > 0) {
  					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}
				
				//get the file
				else {
  					echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  					echo "Type: " . $_FILES["file"]["type"] . "<br>";
  					echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  					echo "Stored in: " . $_FILES["file"]["tmp_name"];
  					
  					$command = Yii::app()->db->createCommand();
        		
	  	  			//changing the data of the asset checked in , in the database
	  	  			$command->update('asset', array(
   				 	'file'=>$_FILES["file"]["name"],
	  	  			'size'=>$_FILES["file"]["size"],
	  	  			'type'=>$_FILES["file"]["type"],
	  	  			'status'=>3,
						), 'assetId=:assetId', array(':assetId'=>$model->assetId));
  					
  				}
			
				$file = $_FILES["file"]["tmp_name"];
				
				//moves the file to required place
				$orgId = Yii::app()->user->getId();
				$categoryId = $model->categoryId;
				$assetId = $model->assetId;

				//counts the number of revisions alreaay present for the record and assign present number to new revision
			    $records = AssetRevision::model()->findAll('assetId=:assetId',array(':assetId'=>$model->assetId));
			    $presentNumber = count($records);
			    
				//file save and version maintenance
				if(move_uploaded_file($_FILES["file"]["tmp_name"],
      			Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'.dat'))
      			
      			{
      				copy($folder .Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'.dat' ,
      				Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$assetId.'/'.$model->assetId.'_'.$presentNumber.'.dat'  );
      				
      			}
      			
				//updates the fileaccesslog
				$command = Yii::app()->db->createCommand();
				$command->insert('fileaccesslog', array(
    					'action'=>'CI',
    					'assetId'=>$model->assetId,
						'uId'=> Yii::app()->user->getState("uid"),
					));

				//inserting new record to asset revision
				$command->insert('asset_revision', array(
    					'assetId'=>$model->assetId,
						'modifiedBy'=> Yii::app()->user->getState("uid"),
						'note'=>$_POST['note'],
						'revision'=>$presentNumber,
						
					));
					
      	//redirect back to the checkIn page of the user    
        $this->redirect(array("/users/checkIn/".Yii::app()->user->getState("uid")));
  	}

  	//renders the checkInform2 for the user
	$this->render('checkInform2',array('model'=>$model));				
					
	}

	/**
	 * 
	 * Download according to the version
	 * @param $id the ID of the model to be loaded
	 * @param $version the version ID of the model to be loaded
	 */
	
	public function actionDownloadVersion($id,$version){
	
		$model = $this->loadModel($id);
		if (isset($_SERVER['HTTP_RANGE'])) 
			$range = $_SERVER['HTTP_RANGE'];
			$dir_path = Yii::getPathOfAlias('webroot') .'/upload/'.$model->orgId.'/'.$model->categoryId.'/'.$model->assetId.'/';
		
			$filePath=$dir_path.$id.'_'.$version.'.dat';
			if (file_exists($filePath))
    		{
    			
    			//updates the fileaccesslog
				$command = Yii::app()->db->createCommand();
				$command->insert('fileaccesslog', array(
    					'action'=>'D',
    					'assetId'=>$model->assetId,
						'uId'=> Yii::app()->user->getState("uid"),
					));
				
    			// send headers to browser to initiate file download
        		header ('Content-Type: application/octet-stream');
        		header ('Content-Disposition: attachment; filename="' . $model->file . '"');
        		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        		header('Pragma: public');
        		readfile($filePath);
           }
   		 else
    		{
        		echo 'File does not exist...';
    		}
			
	  }
	  
	/**
	 * 
	 * Function to enable the mail send on successful registration of organisation
	 * @param email $to emailId of the addresee
	 * @param email $from emailId of the sender
	 * @param string $subject the subject of the email
	 * @param string $message the message/body/content the email 
	 */
	public function mailsend($to,$from,$subject,$message){
		
        $mail=Yii::app()->Smtpmail;
        $mail->SetFrom($from, 'From Vishnu');
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to, "");
        if(!$mail->Send()) {
             echo ("Mailer Error: " . $mail->ErrorInfo);
        }else {
             echo ("Message sent!");
        }
    }
	
}	
			
    			  



