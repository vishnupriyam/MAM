<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $uid
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $login
 * @property string $logout
 * @property string $status
 * @property string $picture
 * @property string $mobile
 * @property integer $quota
 * @property string $DateCreated
 * @property string $LastUpdate
 *
 * The followings are the available model relations:
 * @property Role[] $roles
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, password, email, login, DateCreated', 'required'),
			array('quota', 'numerical', 'integerOnly'=>true),
			array('name, mobile', 'length', 'max'=>45),
			array('email, status', 'length', 'max'=>60),
			array('logout, picture, LastUpdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, name, password, email, login, logout, status, picture, mobile, quota, DateCreated, LastUpdate', 'safe', 'on'=>'search'),
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
			'roles' => array(self::MANY_MANY, 'Role', 'users_has_role(users_uid, role_rid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'name' => 'Name',
			'password' => 'Password',
			'email' => 'Email',
			'login' => 'Login',
			'logout' => 'Logout',
			'status' => 'Status',
			'picture' => 'Picture',
			'mobile' => 'Mobile',
			'quota' => 'Quota',
			'DateCreated' => 'Date Created',
			'LastUpdate' => 'Last Update',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('logout',$this->logout,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('quota',$this->quota);
		$criteria->compare('DateCreated',$this->DateCreated,true);
		$criteria->compare('LastUpdate',$this->LastUpdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
