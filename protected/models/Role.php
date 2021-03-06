<?php
/**
 * This is the model class for table "role".
 *
 * The followings are the available columns in table 'role':
 * @property string $rid
 * @property string $name
 * @property integer $weight
 */
class Role extends CActiveRecord
{
	public $oldAttributes;
	public $permissions;   //variable for associating role with permissions
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, weight, description', 'required'),
			array('weight', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rid, name, weight', 'safe', 'on'=>'search'),
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
		  'organisation'=>array(self::BELONGS_TO,'Organisation','orgId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rid' => 'Rid',
			'name' => 'Name',
			'weight' => 'Weight',
			'description' => 'Description',
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
		$orgId = Yii::app()->user->getId();
		$criteria->compare('rid',$this->rid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('description',$this->description);
		$criteria->compare('orgId',$orgId);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		'sort'=>array(
				'defaultOrder'=>'weight ASC',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Role the static model class
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
	 	$Log->info($uid."\t".Yii::app()->user->name."\t".$this->getModelName()."\t".$action."\t".$this->rid);	
	  
		if($this->name != $this->oldAttributes['name'])
	 		{$Log->info("name ".$this->oldAttributes['name']." ".$this->name);}
	 	if($this->weight != $this->oldAttributes['weight'])
	 		{$Log->info("weight ".$this->oldAttributes['weight']." ".$this->weight);}
	 	if($this->orgId != $this->oldAttributes['orgId'])
	 		{$Log->info("orgId ".$this->oldAttributes['orgId']." ".$this->orgId);}
	 	if($this->description != $this->oldAttributes['description'])
	 		{$Log->info("description ".$this->oldAttributes['description']." ".$this->description);}
	 	
	 		
	 	return parent::afterSave();	
	}

	/**
	 * Get related permissions
	 * @return role object with related perimssions(the action of the permisssion)
	 */
	public function getRolePerms($rid){

		$role = Role::model()->find('rid=:rid',array('rid'=>$rid));
		$id = $rid;
		
		//select the action names of the permissions related the role
		$sql  = "SELECT t2.action FROM role_has_permissions as t1
				JOIN permissions as t2 ON t1.pid = t2.pid
				WHERE t1.rid =:id";
		
		//database connection and query
		$connection=Yii::app()->db;
		$command = $connection->createCommand($sql);
	    $command->bindParam(":id",$id,PDO::PARAM_INT);
		$role->permissions = $command->queryAll();
		return $role->permissions;	
	}
	
	/**
	 * check if a permission is set
	 */
	public function hasPerm($permission,$rid)
	{ 
		
		$role = Role::model()->find('rid=:rid',array('rid'=>$rid));
		$id = $rid;
		
		//select the action names of the permissions related the role
		$sql  = "SELECT t2.action FROM role_has_permissions as t1
				JOIN permissions as t2 ON t1.pid = t2.pid
				WHERE t1.rid =:id";
		
		//database connection and query
		$connection=Yii::app()->db;
		$command = $connection->createCommand($sql);
	    $command->bindParam(":id",$id,PDO::PARAM_INT);
		$dataReader = $command->query();
		while(($row=$dataReader->read())!==false) {
			if($row['action']==$permission)
			{
				return true;
			}
		}
		$count = count($dataReader); 
		return false;
		
	}
	
}
