<?php

class OrganisationController extends Controller
{
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the organisation register page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
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
	 * Confirm page when the registration form of the organisation is submitted successfully
	 * 
	 */
	public function actionRegdone()
	{
		$this->render('regdone');
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
				'actions'=>array('index','view','register1','regdone','captcha'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','view','adddept','index','create','register1','regdone'),
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
		$model=new Organisation;

		$this->performAjaxValidation($model);
		
		if(isset($_POST['buttonCancel']))
        {
         $this->redirect(Yii::app()->homeUrl);
        }
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		
        if(isset($_POST['Organisation']))
		{
			//send maiil on successful submission of the registration
			$to="mvpno1994@gmail.com";
			$from="selvarani@iitb.ac.in";
			$subject="registration submitted";
			$message="Your registration is succesfull, click the following 
					  link to confirm your registration by clicking the following link";
			$model->attributes=$_POST['Organisation'];
			if($model->save()){
			$this->mailsend($to,$from,$subject,$message);
				$this->redirect(array('view','id'=>$model->orgId));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
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
		 $this->performAjaxValidation($model);

		if(isset($_POST['Organisation']))
		{
			$model->attributes=$_POST['Organisation'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->orgId));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//obtain the organisation ID
		$orgId = Yii::app()->user->getId();
		
		//view only the details of organisation logged in 
		$dataProvider=new CActiveDataProvider('Organisation', array(
			'criteria'=>array(
				'condition'=>  'orgId = :orgId',
				 'params'=>array(':orgId'=>$orgId),
			),
		));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Register the organisation 
	 * 
	 */
	public function actionRegister1()
	{
		$model=new Organisation;
		
		//For addition of captcha
		$model->scenario = 'captchaRequired';
		$connection = Yii::app()->db;
		
		//ajax validation of form
		$this->performAjaxValidation($model);
		
		//redirect to home page on cancel of registration
		if(isset($_POST['buttonCancel']))
        {
         $this->redirect(Yii::app()->homeUrl);
        }
		
        //on submission of form register the organisation
		if(isset($_POST['Organisation'])) {
			$model->attributes=$_POST['Organisation'];
			
			//default organisation is validated and validity is set as 1
			$model->validity = 1;
			
			if($model->save()) {

				//get the maximum of the id of the ou_structure
				//insertion of record to ou_structure table
				$sql3 = "select max(id) from ou_structure";
			    $command = $connection->createCommand($sql3);
			    $dataReader = $command->query();
        		$row = $dataReader->read();
        		$dataReader->close();
        		$orgId = $model->orgId;
        		$ans = $row['max(id)'];
			    $ans = $ans + 1;
			    $orgName = $model->orgName;
			    $desc = "hello";
				$sql = "insert into ou_structure(root,lft,rgt,level,name,description,orgId) values(:root, 1, 2, 1, :orgName,:desc,:orgId)";
				
				//binding of the parameters of organisation
				$command = $connection->createCommand($sql);
				$command->bindParam(":root",$ans,PDO::PARAM_INT);
				$command->bindParam(":desc",$desc,PDO::PARAM_STR);
				$command->bindParam(":orgName",$orgName,PDO::PARAM_STR);
				$command->bindParam(":orgId",$orgId,PDO::PARAM_STR);
        		$command->execute(); 
        	
        		
        		$sq = "select orgId from organisation where orgName = :orgName";
        		$command = Yii::app()->db->createCommand($sq);
        		$command->bindParam(":orgName",$orgName,PDO::PARAM_INT);
			    $dataReader = $command->query();
        		$row = $dataReader->read();
        		$ans2 = $row['orgId'];
        		$dataReader->close();
        		
        		//insertion of record to users table for organisation to login
        		$desc = $model->description;
				$email = $model->email;
				$ouId = Ou_structure::model()->find('orgId=:orgId',array(':orgId'=>$model->orgId))->id;
				$pwd = crypt("hello", 'salt');
				$sql2 = "insert into users(name,password,email,orgId,ouId) values(:username, :pwd, :email, :id,:ouId)";
        		$username = $model->orgName;
				$command2 = $connection->createCommand($sql2);
				$command2->bindParam(":username",$username,PDO::PARAM_STR);
				$command2->bindParam(":pwd",$pwd,PDO::PARAM_STR);
				$command2->bindParam(":email",$email,PDO::PARAM_STR);
				$command2->bindParam(":id",$ans2,PDO::PARAM_INT);
				$command2->bindParam(":ouId",$ouId,PDO::PARAM_INT);
				
				$command2->execute();
				
				$connection = Yii::app()->db;
				
				//default assignment of global modules 
				//addition of default modules 
				//update module_organisation table
				$sqlcom = "insert into module_organisation(mid, orgId) values(54, :orgId)";
			    $command2 = $connection->createCommand($sqlcom);
			    $command2->bindParam(":orgId",$ans2,PDO::PARAM_INT);
			    $command2->execute();
			    
			    $sqlcom = "insert into module_organisation(mid, orgId) values(55, :orgId)";
			    $command2 = $connection->createCommand($sqlcom);
			    $command2->bindParam(":orgId",$ans2,PDO::PARAM_INT);
			    $command2->execute();
			    
			    $sqlcom = "insert into module_organisation(mid, orgId) values(56, :orgId)";
			    $command2 = $connection->createCommand($sqlcom);
			    $command2->bindParam(":orgId",$ans2,PDO::PARAM_INT);
			    $command2->execute();
			    
			    $sqlcom = "insert into module_organisation(mid, orgId) values(57, :orgId)";
			    $command2 = $connection->createCommand($sqlcom);
			    $command2->bindParam(":orgId",$ans2,PDO::PARAM_INT);
			    $command2->execute();
			    
			    
			    //send maiil on successful submission of the registration
				$to="mvpnov1994@gmail.com";
				$from="selvarani@iitb.ac.in";
				$subject="registration submitted";
				$message="Your registration is succesfull, click the following 
					  link to confirm your registration by clicking the following link";
				$this->mailsend($to,$from,$subject,$message);
			    
				$this->redirect('regdone');
			}
		}
		$this->render('register1',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$url = "/final/ou_structure/tree";
		$this->redirect($url);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Organisation the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Organisation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Organisation $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='organisation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
