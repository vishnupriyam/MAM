<?php

/**
 * This is the model class for table "asset_ou_filep".
 *
 * The followings are the available columns in table 'asset_ou_filep':
 * @property integer $Id
 * @property integer $assetId
 * @property integer $ouId
 * @property integer $fpId
 */
class AssetOuFilep extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $oldAttributes;//for logs
	public function tableName()
	{
		return 'asset_ou_filep';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('assetId, ouId, fpId', 'required'),
			array('assetId, ouId, fpId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, assetId, ouId, fpId', 'safe', 'on'=>'search'),
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
			'Id' => 'ID',
			'assetId' => 'Asset',
			'ouId' => 'Ou',
			'fpId' => 'Fp',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('assetId',$this->assetId);
		$criteria->compare('ouId',$this->ouId);
		$criteria->compare('fpId',$this->fpId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssetOuFilep the static model class
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
	
       
    //adding details to log the asset save   
    public function afterSave()
    {
    	$Log = Logger::getLogger("accessLog");
  
    	if($this->oldAttributes==NULL)
    		$action="create";
    	else 	
    		$action="update";
    	
      	$uid=Yii::app()->user->getState("uid");
	 	$Log->info($uid."\t".Yii::app()->user->name."\t".$this->getModelName()."\t".$action."\t".$this->Id);	
	
    	if($this->assetId != $this->oldAttributes['assetId'])
	 		{$Log->info("assetId ".$this->oldAttributes['assetId']." ".$this->assetId);}
	 	if($this->ouId != $this->oldAttributes['ouId'])
	 		{$Log->info("ouId ".$this->oldAttributes['ouId']." ".$this->ouId);}
	 	if($this->fpId != $this->oldAttributes['fpId'])
	 		{$Log->info("fpId ".$this->oldAttributes['fpId']." ".$this->fpId);}
	 	
    	return parent::afterSave();
    }   
    	
	
}
