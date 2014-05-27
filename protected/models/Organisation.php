<?php

/**
 * This is the model class for table "organisation".
 *
 * The followings are the available columns in table 'organisation':
 * @property string $orgName
 * @property integer $empNo
 * @property integer $phone
 * @property string $email
 * @property string $addr1
 * @property string $addr2
 * @property string $state
 * @property string $country
 * @property string $orgType
 * @property string $note
 * @property integer $fax
 * @property string $password
 * @property integer $orgId
 */
class Organisation extends CActiveRecord
{
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
			array('orgName, orgId', 'required'),
			array('empNo, phone, fax, orgId', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>26),
			array('addr1, addr2', 'length', 'max'=>20),
			array('note', 'length', 'max'=>150),
			array('password', 'length', 'max'=>10),
			array('state, country, orgType', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orgName, empNo, phone, email, addr1, addr2, state, country, orgType, note, fax, password, orgId', 'safe', 'on'=>'search'),
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
			'orgName' => 'Org Name',
			'empNo' => 'Emp No',
			'phone' => 'Phone',
			'email' => 'Email',
			'addr1' => 'Addr1',
			'addr2' => 'Addr2',
			'state' => 'State',
			'country' => 'Country',
			'orgType' => 'Org Type',
			'note' => 'Note',
			'fax' => 'Fax',
			'password' => 'Password',
			'orgId' => 'Org',
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
		$criteria->compare('empNo',$this->empNo);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('addr1',$this->addr1,true);
		$criteria->compare('addr2',$this->addr2,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('orgType',$this->orgType,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('fax',$this->fax);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('orgId',$this->orgId);

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
}
