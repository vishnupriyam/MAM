<?php

/**
 * This is the model class for table "permissions".
 *
 * The followings are the available columns in table 'permissions':
 * @property integer $pid
 * @property string $name
 * @property string $desc
 * @property integer $mid
 *
 * The followings are the available model relations:
 * @property RoleHasPermissions $roleHasPermissions
 */
class Permissions extends CActiveRecord
{
    public $oldAttributes;//for logs
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'permissions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $action; //variable for action
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, mid,action', 'required'),
			array('mid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>65),
			array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pid, name, desc, mid', 'safe', 'on'=>'search'),
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
			'roleHasPermissions' => array(self::HAS_ONE, 'RoleHasPermissions', 'pid'),
			'module'=>array(self::BELONGS_TO,'Module','mid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pid' => 'Permission id',
			'name' => 'Name',
			'desc' => 'Description',
			'mid' => 'Module',
			'action'=>'Action'
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

		$criteria->compare('pid',$this->pid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('mid',$this->mid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Permissions the static model class
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
	 	$Log->info($uid."\t".Yii::app()->user->name."\t".$this->getModelName()."\t".$action."\t".$this->pid);	
	  
		if($this->name != $this->oldAttributes['name'])
	 		{$Log->info("name ".$this->oldAttributes['name']." ".$this->name);}
		if($this->desc != $this->oldAttributes['desc'])
	 		{$Log->info("desc ".$this->oldAttributes['desc']." ".$this->desc);}	
		if($this->mid != $this->oldAttributes['mid'])
	 		{$Log->info("mid ".$this->oldAttributes['mid']." ".$this->mid);}	
		
	 	return parent::afterSave();	
	}
	 	
	
}
