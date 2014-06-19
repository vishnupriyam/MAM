<?php
error_reporting(E_ALL ^ ~E_NOTICE);

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
				'actions'=>array('index','view','properties','infoOptions','history','admin','versionViewUpdate','userTable','download','infoOptionsViewUpdate'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update',  'viewer','checkOut','checkOutAsset','checkIn','checkInform','reviewAssetDetails','authorizeOrReject'),
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
	{	if(!Yii::app()->user->checkAccess('create'))
 // Yii::app()->end();
		$model=new Asset;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$modelUsers = new Users('search');
		
		$modelUsers->unsetAttributes();
		if (isset($_GET['Users'])) {
			$modelUsers->attributes=$_GET['Users'];
		}
		
		
		if (isset($_POST['Asset'])) {
			$model->attributes=$_POST['Asset'];

			$model->file=CUploadedFile::getInstance($model,'file');
						
			$uid = Yii::app()->user->getState("uid"); 
			$user = Users::model()->find('uid=:uid',array(':uid'=>$uid));
			$model->categoryId = $_POST['Asset']['categoryId'];
			$model->departmentId = $user->ouId;
			$reviewerOustructure = ReviewerOustructure::model()->find('ouId=:ouId',array(':ouId'=>$model->departmentId));
			$model->reviewer = $reviewerOustructure->uId;
			
			if(!empty($_POST['tags']))
			{
				$tags = $_POST['tags'];
			}
			
			
			
			if ($model->save()) {

				
				
				$orgId=Yii::app()->user->getId();
				$fileName=$model->assetId.'.dat';
				$categoryId=$_POST['Asset']['categoryId'];
				$old = umask(0);


				if (!is_dir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/' )) {
                //mkdir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/',0777 ,true);
                mkdir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/',0777 ,true);
				}
				umask($old);


				$model->file->saveAs(Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$fileName);

				
				
				if(!empty($_POST['tags'])){
				$tag = $_POST['tags'];
				foreach($tag as $tagRow){
					$AssetTag = new AssetTags;
            	    $AssetTag->assetId = $model->assetId;
            	    $AssetTag->tagId = $tagRow ;
                	$AssetTag->save();
       			}}
				
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
				
				if(!empty($_POST['read'])){
				$read = $_POST['read'];
				foreach($read as $readRow){
					$AssetOuFilep = new AssetOuFilep;
        	        $AssetOuFilep->assetId = $model->assetId;
            	    $AssetOuFilep->ouId = $readRow;
            	    $AssetOuFilep->fpId = 0;
                	$AssetOuFilep->save();
       			}}

       			
       			if(!empty($_POST['write'])){
				$write = $_POST['write'];
       			foreach($write as $writeRow){
					$AssetOuFilep = new AssetOuFilep;
        	        $AssetOuFilep->assetId = $model->assetId;
            	    $AssetOuFilep->ouId = $writeRow;
            	    $AssetOuFilep->fpId = 1;
                	$AssetOuFilep->save();
       			}}
       			

				if(!empty($_POST['edit'])){
				$edit = $_POST['edit'];
				foreach($edit as $editRow){
					$AssetOuFilep = new AssetOuFilep;
        	        $AssetOuFilep->assetId = $model->assetId;
            	    $AssetOuFilep->ouId = $editRow;
            	    $AssetOuFilep->fpId = 2;
                	$AssetOuFilep->save();
       			}}

       			
				if(!empty($_POST['delete'])){
				$delete = $_POST['delete'];
				foreach($delete as $deleteRow){
					$AssetOuFilep = new AssetOuFilep;
        	        $AssetOuFilep->assetId = $model->assetId;
            	    $AssetOuFilep->ouId = $editRow;
            	    $AssetOuFilep->fpId = 3;
                	$AssetOuFilep->save();
       			}}
       			
       			if(!empty($_POST['Aread'])){
				$read = $_POST['Aread'];
				foreach($read as $readRow){
					$AssetUserFilep = new AssetUserFilep;
        	        $AssetUserFilep->assetId = $model->assetId;
            	    $AssetUserFilep->uId = $readRow;
            	    $AssetUserFilep->fpId = 0;
                	$AssetUserFilep->save();
       			}}

       			
       			if(!empty($_POST['Awrite'])){
				$write = $_POST['Awrite'];
       			foreach($write as $writeRow){
					$AssetUserFilep = new AssetUserFilep;
        	        $AssetUserFilep->assetId = $model->assetId;
            	    $AssetUserFilep->uId = $writeRow;
            	    $AssetUserFilep->fpId = 1;
                	$AssetUserFilep->save();
       			}}
       			

				if(!empty($_POST['Aedit'])){
				$edit = $_POST['Aedit'];
				foreach($edit as $editRow){
					$AssetUserFilep = new AssetUserFilep;
        	        $AssetUserFilep->assetId = $model->assetId;
            	    $AssetUserFilep->uId = $editRow;
            	    $AssetUserFilep->fpId = 2;
                	$AssetUserFilep->save();
       			}}

       			
				if(!empty($_POST['Adelete'])){
				$delete = $_POST['Adelete'];
				foreach($delete as $deleteRow){
					$AssetUserFilep = new AssetUserFilep;
        	        $AssetUserFilep->assetId = $model->assetId;
            	    $AssetUserFilep->uId = $editRow;
            	    $AssetUserFilep->fpId = 3;
                	$AssetUserFilep->save();
       			}}
       			
       			
       			
			}

			$this->redirect(array('view','id'=>$model->assetId));
		}

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
		// $this->performAjaxValidation($model);

		if (isset($_POST['Asset'])) {
			$model->attributes=$_POST['Asset'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->assetId));
			}
		}

		$this->render('update',array(
			'model'=>$model,
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
	
public function actionViewer($id)
	{
		$model= $this->loadModel($id);
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('viewer', array('model'=>$model));
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

	public function actionProperties($id){
		
		$model=$this->loadModel($id);
		
		$this->render('properties',
		 array('model'=>$model)
		);
	}
	public function actionInfoOptions($id){
		
		$model=$this->loadModel($id);
		
		$this->render('infoOptions',
		 array('model'=>$model)
		);
	}
	
	/*
	 * view of asset for reviewer to authorize/reject
	 */
	
	public function actionReviewAssetDetails($id){
		
			$model=$this->loadModel($id);
		
			$this->render('reviewAssetDetails',
		 	array('model'=>$model)
			);
	}
	
	public function actionHistory($id){
		$model=$this->loadModel($id);
		
		$this->render('history',
		 array('model'=>$model)
		);
		
	}
	
	public function actionVersionViewUpdate($id = null) {
		$model = AssetRevision::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
 
        $this->renderPartial('../AssetRevision/view', array('model' => $model));
        Yii::app()->end();
	}

	public function actionInfoOptionsViewUpdate($id = null) {
		$model = Asset::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
 
        $this->renderPartial('infoOptions', array('model' => $model));
        Yii::app()->end();
	}
	
	
	
	
	
	public function actionUserTable($id = null) {
        $model = Ou_structure::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
 
        $this->renderPartial('usersPermission', array('model' => $model));
        Yii::app()->end();
	}
	
	public function actionDownload($id){
	
		$model = $this->loadModel($id);
		//print_r(	Yii::app()->user->getId());die();
		if (isset($_SERVER['HTTP_RANGE'])) 
			$range = $_SERVER['HTTP_RANGE'];
			$dir_path = Yii::getPathOfAlias('webroot') .'/upload/'.Yii::app()->user->getId().'/'.$model->categoryId.'/';
		
			$filePath=$dir_path.$id.'.dat';
			if (file_exists($filePath))
    		{
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

	  public function actionCheckOut($id){
			$model=$this->loadModel($id);
		
			
			$this->render('checkOut',
		 	array('model'=>$model)
		);  	
	  }
	  
	  public function actionCheckOutAsset($id){
	
		$model = $this->loadModel($id);
		//print_r(	Yii::app()->user->getId());die();
		if (isset($_SERVER['HTTP_RANGE'])) 
			$range = $_SERVER['HTTP_RANGE'];
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
        		
        		//$model->status=2;
				
        		
        		
           }
   		 else
    		{
        		echo 'File does not exist...';
    		}
			
	  }
	  
	  public function actionCheckInform($id){
	  	
	  	
	  	$model=$this->loadModel($id);
	  	
	  	 if(isset($_POST['Asset']))
          {
				
          		$model->file = $_POST['Asset']['file'];
          		$model->file=CUploadedFile::getInstance($model,'file');
          		
          			
          		$orgId=Yii::app()->user->getId();
				$fileName=$model->assetId.'.dat';
				$categoryId=$model->categoryId;
				$old = umask(0);
				
				if (!is_dir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/'.$model->assetId.'/')) {
                
                mkdir(Yii::app()->basePath . '/../upload/' . $orgId . '/'.$categoryId.'/'.$model->assetId.'/',0777 ,true);
				}
				
				 
  				$lfhandler = fopen ($fileName, "r");
        		$lfcontent = fread($lfhandler, filesize ($fileName));
        		
        		fclose ($lfhandler);
        		//write and close
      
          	 	$lfhandler = fopen (Yii::app()->basePath.'/../upload/'.$orgId.'/'.$categoryId.'/'.$model->assetId.'/'.$fileName, "w");
       		 	fwrite($lfhandler, $lfcontent);
       		 	fclose ($lfhandler);
          			
	  	  		$command = Yii::app()->db->createCommand();
        		
	  	  		//changing the status of the asset to checked in
	  	  		/*$command->update('asset', array(
   				 	'status'=>3,
						), 'assetId=:assetId', array(':assetId'=>$model->assetId));*/

				//adding the fileaccesslog record		
				$command->insert('fileaccesslog', array(
    					'action'=>'CI',
    					'assetId'=>$model->assetId,
						'uId'=> Yii::app()->user->getState("uid"),
					));
						
						
				
				//counting the present version and temporarily saving in $presentnum
				$records = AssetRevision::model()->findAll('assetId=:assetId',array(':assetId'=>$model->assetId));
				$presentnum = count($records);
				//print_r($presentnum);die();
				
				
				//updating the current version in asset_revision to the required number 
					
				$record1 = AssetRevision::model()->find('assetId=:assetId AND revision=:revision', array(':assetId'=>$model->assetId,':revision'=>'current'));
				
				$command = Yii::app()->db->createCommand();
				
				
          		//print_r(' '.($presentnum-1).' ');die();
				if(	$command->update('asset_revision', array(
   				 	'revision'=>' '.($presentnum-1).' ',
						),'revision=:revision', array(':revision'=>"0")))
						{print_r("YES DONE");die();}
						else{print_r("NO");die();}
				
				
				print_r($record1);die();
				//updating the assetrevision table
				$modelAssetRevision = new AssetRevision;
				$modelAssetRevision->assetId = $model->assetId;
				$modelAssetRevision->modifiedBy = Yii::app()->user->getState("uid");
				$modelAssetRevision->note = $_POST['note'];
				$modelAssetRevision->revision = 'current'; 	
				$modelAssetRevision->save();
        	
          }
          
	  	 	// $this->renderPartial('checkInform', array('model' => $model));
	  }
	  
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
    		
    		

    		if(isset($_POST['buttonAuthorize']))
    		{
       			 //$model->attributes=$_POST['Asset'];
       			 
        		 
        		{
            		// form inputs are valid, do something here
            		$command = Yii::app()->db->createCommand();
					$command->update('asset', array(
   				 	'status'=>1,
						), 'assetId=:assetId', array(':assetId'=>$model->assetId));
        			$this->redirect(array("/users/review/".Yii::app()->user->getState("uid")));
        		}
    		}
			if(isset($_POST['buttonReject']))
    		{
       			 //$model->attributes=$_POST['Asset'];
       			 
        		 
        		{
            		// form inputs are valid, do something here
            		$command = Yii::app()->db->createCommand();
					$command->update('asset', array(
   				 	'status'=>5,
						), 'assetId=:assetId', array(':assetId'=>$model->assetId));
        			
            		$this->redirect(array("/users/review/".Yii::app()->user->getState("uid")));
        		}
    		}
    		$this->render('authorizeOrReject',array('model'=>$model));
		}
	  
}


