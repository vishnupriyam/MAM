<?php

/**
 * This is the model class for table "category1".
 *
 * The followings are the available columns in table 'category1':
 * @property integer $cat_id
 * @property string $Name
 * @property integer $orgId
 * @property integer $unitCode
 */
class Category1 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $orgName;
	public $name;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name', 'required'),
			//array('Name, orgName', 'max'=>45),
			array('orgId, unitCode', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Name, orgName, name', 'safe', 'on'=>'search'),
			
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
		  // ou_stucture and category1 relationship
		  'ou_structure'=>array(self::BELONGS_TO,'Ou_structure','unitCode'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cat_id' => 'Category',
			'Name' => 'Category Name',
			'orgId' => 'Organisation',
			'unitCode' => 'Unit Code',
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
		//$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('orgId',$orgId, true);
		$criteria->compare('unitCode',$this->unitCode);
		//$criteria->compare(organisation.orgName,$this->orgName,true);
		//$criteria->compare(ou_structure.name,$this->name,true);
		    
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
