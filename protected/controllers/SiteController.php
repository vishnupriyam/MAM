<?php

class SiteController extends Controller
{
	private $filemanagerLog;
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$filemanagerLog = Logger::getLogger("user1log");
		$filemanagerLog->info("user1Log.log");
		$this->render('index');
	}

public function actionAsset()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('asset');
	}	
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
				
		if(isset($_POST['ContactForm']))
		{
			
			$model->attributes=$_POST['ContactForm'];

		if(isset($_POST['buttonCancel']))
        		{
         		$this->redirect(Yii::app()->homeUrl);
        		}
			if($model->validate())
			{
				
				
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		
		
		$this->render('contact',array('model'=>$model));
	
	}

	/**
	 * Displays the login page
	 *//*
	public function actionLogin()
	{
		$model=new LoginForm;
		
		if(isset($_POST['buttonCancel']))
        {
         $this->redirect(Yii::app()->homeUrl);
        }
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			if(isset($_POST['buttonCancel']))
	        {
	         $this->redirect(Yii::app()->homeUrl);
	        }
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			$name = $model->username;
			$password = $model->password;
			$user = Users::model()->findByAttributes(array('name'=>$name, 'password'=>$password));
			if ($user===null) { 
			$this->redirect("/final/Site/login");
			} else if ($user->password !== $password ) {
			$this->redirect("/final/Site/login");
			} else {
			$model->validate();
			$model->login();
			$this->redirect("/final/site/asset");
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
*/
public function actionLogin()
	{
		$model=new LoginForm;

		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			if($model->validate() && $model->login()) {
				//$session=new CDbHttpSession;
				//$session->open();
				//$orgId = "hello";
				//$session['orgId'] = $orgId;
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		$this->render('login',array('model'=>$model));
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
	//	$session->close();
		//$session->destroy();
		$this->redirect(Yii::app()->homeUrl);
	}
}