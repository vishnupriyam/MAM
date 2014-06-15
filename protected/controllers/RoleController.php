<?php

class RoleController extends Controller
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
				'actions'=>array('index','view','permission_change','permission','admin'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','permission_change2','permission_change','rfu'),
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
	
	public function actionRfu($id)
	{
		$this->render('rfu');
	}
	
	/*public function actionPermission_change($id)
	{
		$this->render('permission_change',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Role;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['buttonCancel']))
        {
         $this->redirect(Yii::app()->user->returnUrl);
        }
		
		
		if (isset($_POST['Role'])) {
			$model->attributes=$_POST['Role'];
			
			$connection = Yii::app()->db;
			$id = Yii::app()->user->getId();
			$name = $model->name;
			$weight = $model->weight;
			
			$sql = "insert into role (name, weight) values (:name, :weight)";
			$command = $connection->createCommand($sql);
			$command->bindParam(":name",$name,PDO::PARAM_STR);
			
			$command->bindParam(":weight",$weight,PDO::PARAM_STR);
			$command->execute(); 
			
			$this->redirect(array('view','id'=>$model->rid));
			
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
		$model=	$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Role'])) {
			$model->attributes=$_POST['Role'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->rid));
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
		$orgId = Yii::app()->user->getId();
		//$dataProvider=new CActiveDataProvider('Role', array('criteria'=>array('condition'=>  'orgId = :orgId', 'params'=>array(':orgId'=>$orgId),
		$dataProvider = new CActiveDataProvider('Role');
		//),));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionPermission()
	{
		$model = new Role;
		//$orgId = Yii::app()->user->getId();
		//$dataProvider=new CActiveDataProvider('Role', array('criteria'=>array('condition'=>  'orgId = :orgId', 'params'=>array(':orgId'=>$orgId),
		//$dataProvider = new CActiveDataProvider('Role');
		//),));
		$this->render('permission',array(
			'model'=>$model,
		));
	}
	
	
	
	
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$parent_model=new Role('search');
		$parent_model->unsetAttributes();  // clear any default values
		
		if (isset($_GET['Role'])) {
			$parent_model->attributes=$_GET['Role'];
		}

		if(!isset($_GET['parentID'])){
		
			/* The event using this action now, is from Group A:*/
            $group = "A";

            
            $criteria=new CDbCriteria;
 
            $criteria->compare('rid',$parent_model->rid,true);
            $criteria->compare('name',
            $parent_model->name,true);
 
            $dataProvider = new CActiveDataProvider('Role', 
                array(
                    'criteria'=>$criteria,
                ));
 
                
		 	If (count($dataProvider->getData()) > 0) {
                /* Extract the first model from the dataprovider */
                $first_model=$dataProvider->getData();
 
                /* Extract the record's PK, to be used to generate 
                the child-gridview's data records.*/
                $parentID = $first_model[0]->rid;
            }
            else{
                /* Set $parentID to 0, to return an empty child-
                grid.*/
                $parentID = 0;
            }
        }

		else{
            /* The event using this action, is from Group B: */
            $group = "B";
 
            /* Get the parentID, which the event passed to this 
            action.*/
            $parentID = $_GET['parentID'];
        }
        
		/* Process1:
        Create another filtering-model instance which will hold the
        child-grid's filtering parameters entered by the user.
        Put this model in the searchIncludingPermissions scenario. */
        $child_model = new 
            RoleHasPermissions("searchIncludingPermissions");
 
        /* Empty the newly created filtering-model to clear all 
        default parameters.*/
        $child_model->unsetAttributes();
 
        /*If you later need to change this model's scenario for whatever
        reason, you can do it like this. (More details on scenarios in the
        RolePermission model.) */
        $child_model->scenario = 'anotherScenario';
 
        /* Process2:
        Test if the event that is currently calling this action, passed 
        any filtering parameters that the user might have entered in the 
        child-grid.
        If true, store these parameters in the newly created 
        filtering-model instance. */
        if(isset($_GET['RoleHasPermissions']))
            $child_model->attributes=$_GET['RoleHasPermissions'];
 
        /* Process3:
        Test if the event that is currently using this action, is from 
        Group A or B */
        if($group == "A"){
            /* GROUP A:     
            Render the 'admin' form while passing it $parentID and
            both filtering-model instances (containing the user's
            and our own additional filtering parameters - if any).
            (Remember, the form's gridviews use the Role->search() and
            RolePermission->searchIncludingPermissions(parentID) 
            functions to create their own dataproviders.
            These functions will incorporate $parentID and any 
            received filtering parameters contained in the two
            filtering-models.
 
            Note that the whole admin view is rendered (default gii
            way of doing it), even if the event currently using this
            action might be one of the Yii ajax functions (GROUP A, 
            1.2 - 2.3), which would normally only require a section of 
            the view. See the role-grid in the admin.php view for more 
            information on why the whole admin view is rendered. */
            $this->render('admin',array(
                'parent_model'=>$parent_model,
                'child_model'=>$child_model,
                'parentID' => $parentID,
            ));
        }
        else{
            /* GROUP B: 
            Render only the '_child' form while passing it $parentID 
            and the single filtering-model (child-model) instance.
 
            The form's gridview will use the
            RolePermission->searchIncludingPermissions($parentID)
            function to create it's own dataprovider.
            This function will also incorporate $parentID and any 
            received filtering parameters contained in the single 
            child-model instance.*/
            $this->renderPartial('_child', array(
                'child_model'=>$child_model,
                'parentID' => $parentID,
            ));
        }
   
			
			
		/*$this->render('admin',array(
			'model'=>$model,
		));*/
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function actionPermission_change($id)
	{
		//$dataProvider=new CActiveDataProvider('Permissions');
		
		$model= $this->loadModel($id);
		
		if(isset($_POST['buttonCancel']))
        {
         $this->redirect(Yii::app()->homeUrl);
        }
       

        if (isset($_POST['buttonUpdate'])) {
        	
        	$module=ModuleOrganisation::model()->findAll('orgId=:orgId',array(':orgId'=>Yii::app()->user->getId()));
        	$data = count($module);
        	RoleHasPermissions::model()->deleteAll('rid=:rid',array(':rid'=>$model->rid));
        	//print_r($data);die();
        	$number = 0;
        	while($number<$data){
        		if(!empty($_POST['CB'.$number])){
        		foreach($_POST['CB'.$number] as $rec)
        		{
        		  $RoleHasPermissions = new RoleHasPermissions;
        		  $RoleHasPermissions->rid = $model->rid;
        		  $RoleHasPermissions->pid = $rec;
        		  $RoleHasPermissions->save();
        		}}
        		$number++;
        	}
        	$this->redirect(array('/role'));
        }
        
        
		$this->render('permission_change',array(
			'model'=>$model,
		));
	}
	
	
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Role the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Role::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Role $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='role-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}