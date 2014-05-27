<?php

/**
 * This is the model class for table "permissions".
 *
 * The followings are the available columns in table 'permissions':
 * @property integer $pid
 * @property string $name
 * @property string $description
 * @property integer $module_mid
 *
 * The followings are the available model relations:
 * @property Module $moduleM
 * @property Role[] $roles
 */
class Permissions extends CActiveRecord
{
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
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, module_mid', 'required'),
			array('module_mid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>65),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pid, name, description, module_mid', 'safe', 'on'=>'search'),
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
			'moduleM' => array(self::BELONGS_TO, 'Module', 'module_mid'),
			'roles' => array(self::MANY_MANY, 'Role', 'role_has_permissions(permissions_pid, role_rid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pid' => 'Pid',
			'name' => 'Name',
			'description' => 'Description',
			'module_mid' => 'Module Mid',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('module_mid',$this->module_mid);

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
}
