<?php

class TagsController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','view'),
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
		$model=new Tags;
		
		if(isset($_POST['buttonCancel']))
        {
         $this->redirect(Yii::app()->homeUrl);
        }
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Tags'])) {
			$model->attributes=$_POST['Tags'];
			//print_r($model->attributes=$_POST['Tags']);
            //die();
			$orgId = Yii::app()->user->getId();
			//$tagName = $model->tagName;
			//$dept_name = $model['dept_name']['child'];
			//$dept_id = $model->dept_name;
			$model->orgId = $orgId;
			/*$sql3 = "select id from org_ou where orgId = :orgId";
		    $command =  Yii::app()->db->createCommand($sql3);
		    $command->bindParam(":orgId",$orgId,PDO::PARAM_INT);
		    $dataReader = $command->query();
	        $row = $dataReader->read();
	        $dataReader->close();
	        $ans = $row['id'];
	        $dataReader->close();
	        
	        $criteria=new CDbCriteria();
			$criteria->compare('root', $ans, true);
			
			$categories = CActiveRecord::model('ou_structure')->findAll($criteria, array('order' => 'lft, root'));
        	
        	$idd = 0;
        	foreach ($categories as $n => $category) {
        		if ($category->id = $dept_id) {
        			//echo $dept_name;
        			$idd = $category->id;
        			break;
        		}
        	}
        	*/
        	//$model->dept_id = $idd;
        	
        	$model->save();
        	$this->redirect(array('view','id'=>$model->tagId));
        	//$this->redirect("/final/tags/view");
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

		
		if(isset($_POST['buttonCancel']))
        {
         $this->redirect(Yii::app()->homeUrl);
        }
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Tags'])) {
			$model->attributes=$_POST['Tags'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->tagId));
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
		//$dataProvider=new CActiveDataProvider('Tags');
		$orgId = Yii::app()->user->getId();
		$dataProvider=new CActiveDataProvider('Tags', array('criteria'=>array('condition'=>  'orgId = :orgId', 'params'=>array(':orgId'=>$orgId),
		),));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tags('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Tags'])) {
			$model->attributes=$_GET['Tags'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tags the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tags::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tags $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='tags-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}