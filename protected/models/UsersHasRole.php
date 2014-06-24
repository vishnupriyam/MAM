<?php

/**
 * This is the model class for table "users_has_role".
 *
 * The followings are the available columns in table 'users_has_role':
 * @property integer $users_uid
 * @property string $role_rid
 */
class UsersHasRole extends CActiveRecord
{
	public $oldAttributes;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_has_role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_uid, role_rid', 'required'),
			array('users_uid', 'numerical', 'integerOnly'=>true),
			array('role_rid', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('users_uid, role_rid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'users_uid' => 'Users Uid',
			'role_rid' => 'Role Rid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('users_uid',$this->users_uid);
		$criteria->compare('role_rid',$this->role_rid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersHasRole the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
		//get model name
	public function getModelName(){
		return __CLASS__;
	}
	
	//get oldAttributes
	public function afterFind(){
    	 $this->oldAttributes = $this->attributes;
   		 return parent::afterFind();
	}
	
	//additional code to maintain the logs with log4php 
	public function afterSave(){
		$Log = Logger::getLogger("accessLog");

		if($this->oldAttributes==NULL)
    		$action="create";
    	else 	
    		$action="update";
    	
		$uid=Yii::app()->user->getState("uid");
	 	$Log->info($uid."\t".Yii::app()->user->name."\t".$this->getModelName()."\t".$action."\t");	
	  
		
		if($this->users_uid != $this->oldAttributes['users_uid'])
	 		{$Log->info("users_uid ".$this->oldAttributes['users_uid']." ".$this->users_uid);}
	 	if($this->role_rid != $this->oldAttributes['role_rid'])
	 		{$Log->info("role_rid ".$this->oldAttributes['role_rid']." ".$this->role_rid);}
	 	
	 	return parent::afterSave();	
	}
	 		
	
}
