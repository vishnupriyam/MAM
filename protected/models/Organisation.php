<?php

/**
 * This is the model class for table "organisation".
 *
 * The followings are the available columns in table 'organisation':
 * @property string $orgName
 * @property integer $noEmp
 * @property integer $phone
 * @property string $email
 * @property string $addr1
 * @property string $addr2
 * @property string $state
 * @property string $country
 * @property string $orgType
 * @property string $description
 * @property integer $fax
 * @property string $orgId
 * @property integer $validity
 */
class Organisation extends CActiveRecord
{
	public $verifyCode;
	public $oldAttributes;
	
	public function behaviors(){
          return array( 'CAdvancedArBehavior' => array(
            'class' => 'application.extensions.CAdvancedArBehavior'));
          }
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'organisation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orgName, phone,email,addr1', 'required'),
			array('noEmp,phone, fax, validity', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>26),
			array('addr1, addr2', 'length', 'max'=>255),
			array('state', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>10,'min'=>10),
			array('country, orgType', 'length', 'max'=>30),
			array('description', 'safe'),
			
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			
			array('orgName', 'unique' ,'className' => 'Organisation'),array('orgName', 'length', 'max'=>20, 'min' => 3),//name must be unique
			array('email','unique', 'className' => 'Organisation','attributeName'=>'email'),//email must be unique
			array('email','length','min'=>3,'max'=>32),//email length must be between 3 and 32
			array('noEmp', 'numerical'),//name must contain only the specified characters
			array('fax', 'numerical'),//fax must contain only the specified numbers
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orgName, noEmp, phone, email, addr1, addr2, state, country, orgType, description, fax, orgId, validity', 'safe', 'on'=>'search'),
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
		 //one to many relationship	
		 'category'=>array(self::HAS_MANY,'Category','orgId'),
		 'tags'=>array(self::HAS_MANY,'tags','orgId'),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'orgName' => 'Org Name',
			'noEmp' => 'No Emp',
			'phone' => 'Phone',
			'email' => 'Email',
			'addr1' => 'Addr1',
			'addr2' => 'Addr2',
			'state' => 'State',
			'country' => 'Country',
			'orgType' => 'Org Type',
			'description' => 'Description',
			'fax' => 'Fax',
			'orgId' => 'Org',
			'validity' => 'Validity',
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

		$criteria->compare('orgName',$this->orgName,true);
		$criteria->compare('noEmp',$this->noEmp);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('addr1',$this->addr1,true);
		$criteria->compare('addr2',$this->addr2,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('orgType',$this->orgType,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('fax',$this->fax);
		$criteria->compare('orgId',$this->orgId,true);
		$criteria->compare('validity',$this->validity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Organisation the static model class
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
	 	$Log->info($uid."\t".Yii::app()->user->name."\t".$this->getModelName()."\t".$action."\t".$this->orgId);	
	  
	 	if($this->orgName != $this->oldAttributes['orgName'])
	 		{$Log->info("orgName ".$this->oldAttributes['orgName']." ".$this->orgName);}
	 	if($this->noEmp != $this->oldAttributes['noEmp'])
	 		{$Log->info("noEmp ".$this->oldAttributes['noEmp']." ".$this->noEmp);}
		if($this->phone != $this->oldAttributes['phone'])
	 		{$Log->info("phone ".$this->oldAttributes['phone']." ".$this->phone);}
		if($this->email != $this->oldAttributes['email'])
	 		{$Log->info("email ".$this->oldAttributes['email']." ".$this->email);}
		if($this->addr1 != $this->oldAttributes['addr1'])
	 		{$Log->info("addr1 ".$this->oldAttributes['addr1']." ".$this->addr1);}
		if($this->addr2 != $this->oldAttributes['addr2'])
	 		{$Log->info("addr2 ".$this->oldAttributes['addr2']." ".$this->addr2);}
		if($this->state != $this->oldAttributes['state'])
	 		{$Log->info("state ".$this->oldAttributes['state']." ".$this->state);}
		if($this->country != $this->oldAttributes['country'])
	 		{$Log->info("country ".$this->oldAttributes['country']." ".$this->country);}
		if($this->orgType != $this->oldAttributes['orgType'])
	 		{$Log->info("orgType ".$this->oldAttributes['orgType']." ".$this->orgType);}
		if($this->description != $this->oldAttributes['description'])
	 		{$Log->info("description ".$this->oldAttributes['description']." ".$this->description);}
		if($this->fax != $this->oldAttributes['fax'])
	 		{$Log->info("fax ".$this->oldAttributes['fax']." ".$this->fax);}
		if($this->validity != $this->oldAttributes['validity'])
	 		{$Log->info("validity ".$this->oldAttributes['validity']." ".$this->validity);}								
	return parent::afterSave();	
	}
	
	
	
}
