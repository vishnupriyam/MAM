<?php

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
				'actions'=>array('index','view','properties','infoOptions','history','admin','partUpdate'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update',  'viewer'),
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

		if (isset($_POST['Asset'])) {
			$model->attributes=$_POST['Asset'];

			$model->file=CUploadedFile::getInstance($model,'file');
			//$model->type=$model->file->getType();
			//$model->type=$model->file->extensionName;
			//$model->createDate=
			
			
			/* getting the records from list of primary keys 
			//print_r($_POST['users']);die();
			$usersIds = $_POST['users'];
			$userRecords = Users::model()->findAllByPk($usersIds);
			//print_r($userRecords);die();

			foreach($userRecords as $record){
				print_r($record->name."\n");
			}
			die();
			
			*/
			
			$model->categoryId = $_POST['Asset']['categoryId'];
			
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

       			
       			if(!empty($_POST['edit'])){
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
			}

			$this->redirect(array('view','id'=>$model->assetId));
		}

		$this->render('create',array(
			'model'=>$model,
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
		$this->render('viewer', array('a'=>$id));
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
	
	public function actionHistory($id){
		$model=$this->loadModel($id);
		
		$this->render('history',
		 array('model'=>$model)
		);
		
	}
	
	public function actionPartUpdate($id = null) {
        $model = Asset::model()->findByPk("1");
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
 
        $this->renderPartial('view', array('model' => $model));
        Yii::app()->end();
	}
	
	
}

