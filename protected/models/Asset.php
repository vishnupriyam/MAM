<?php

/**
 * This is the model class for table "asset".
 *
 * The followings are the available columns in table 'asset':
 * @property string $file
 * @property integer $assetId
 * @property string $assetName
 * @property string $createDate
 * @property string $description
 * @property string $comment
 * @property integer $status
 * @property integer $publication
 * @property integer $onlineEditable
 * @property integer $size
 * @property string $type
 * @property string $reviewer
 * @property string $reviewerComments
 * @property integer $ownerId
 */
class Asset extends CActiveRecord
{
	public $checkIn;    	 //variable for checkIn
	public $write;      
	public $file;		 	//for file upload
	public $categoryId;  	//for maintainence of category
	public $oldAttributes;  //to record logs
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

	public $owner_name;  //obtain owner name for ownerId
	public $view;        //for view
	public $view_online; //used for online view
	public $edit_online; //used for online edit
	public $tagsUser;    //asset create form - add tags by user
	public $gview;       //for gridview
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('file, assetId, assetName, publication, onlineEditable, ownerId', 'required'),
			//array('file,assetId,assetName,ownerId', 'required'),
			//array('file', 'required'),
			//array('file','file','types'=>'swf','flv','mp3','mp4'),
			//array('file', 'file', 'allowEmpty'=>true, 'types'=>'swf,flv,mp3,mp4'),
			//array('file', 'file', 'types' => 'jpg, gif, png, pdf, doc, docx, avi, mpg, flv, mov, mpeg, mp4, 3gp, wmv', 'maxSize' => 150 * 1024 * 1024, 'on' => 'create'),
			
			array('assetId, status, publication, onlineEditable, size, ownerId', 'numerical', 'integerOnly'=>true),
			array('assetName, reviewer', 'length', 'max'=>45),
			array('type', 'length', 'max'=>20),
			array('createDate, description, comment, reviewerComments', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('file, assetId, assetName, createDate, description, comment, status, publication, onlineEditable, size, type, reviewer, reviewerComments,orgId', 'safe', 'on'=>'search'),
			array('file', 'unique' ,'className' => 'asset'),//name must be unique
			//array('file', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u'),//name must contain only the specified characters
			
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
		
		//users - asset relation , owner of asset
		'users'=>array(self::BELONGS_TO,'Users','ownerId'),
		//category - asset relation , asset belong to a category
		'category'=>array(self::BELONGS_TO,'Category','categoryId'),
		//tags - asset asset is related to many tags
		'tags' => array(self::MANY_MANY, 'Tags', 'asset_tags(assetId,tagId)'),
		//asset - ouStructure , asset belong to a department
		'OwnerDept'=>array(self::BELONGS_TO,'Ou_structure','departmentId'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file' => 'File',
			'assetId' => 'Asset',
			'assetName' => 'Asset Name',
			'createDate' => 'Create Date',
			'description' => 'Description',
			'comment' => 'Comment',
			'status' => 'Status',
			'publication' => 'Publication',
			'onlineEditable' => 'Online Editable',
			'size' => 'Size',
			'type' => 'Type',
			'reviewer' => 'Reviewer',
			'reviewerComments' => 'Reviewer Comments',
			'ownerId' => 'Owner',
			'departmentId'=>'departmentId'
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

		$criteria->compare('assetName',$this->assetName,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('assetId',$this->assetId);
		$criteria->compare('orgId',Yii::app()->user->getId());
		$criteria->compare('createDate',$this->createDate,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('publication',$this->publication);
		$criteria->compare('onlineEditable',$this->onlineEditable);
		$criteria->compare('size',$this->size);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('reviewer',$this->reviewer);
		$criteria->compare('reviewerComments',$this->reviewerComments,true);
		$criteria->compare('ownerId',$this->ownerId);
		//$criteria->compare('ownerId',$this->users->name,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
            'pageSize' => 5
        ),
		));
	}

	//for checkIn form
	public function search1()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('assetName',$this->assetName,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('assetId',$this->assetId);
		
		$criteria->compare('createDate',$this->createDate,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',"2");
		$criteria->compare('publication',$this->publication);
		$criteria->compare('onlineEditable',$this->onlineEditable);
		$criteria->compare('size',$this->size);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('reviewer',$this->reviewer);
		$criteria->compare('reviewerComments',$this->reviewerComments,true);
		$criteria->compare('ownerId',Yii::app()->user->getState("uid"));
		//$criteria->compare('owner_name',$this->users->name,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
            'pageSize' => 5
        ),
		));
	}

	//for reviewer asset
	public function search2()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('assetName',$this->assetName,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('assetId',$this->assetId);
		
		$criteria->compare('createDate',$this->createDate,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',array(0,3));
		//$criteria->compare('status','3');
		$criteria->compare('publication',$this->publication);
		$criteria->compare('onlineEditable',$this->onlineEditable);
		$criteria->compare('size',$this->size);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('reviewer',Yii::app()->user->getState("uid"));
		$criteria->compare('reviewerComments',$this->reviewerComments,true);
		$criteria->compare('ownerId',$this->ownerId);
		//$criteria->compare('ownerId',$this->users->name,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
            'pageSize' => 5
        ),
		));
	}
	
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Asset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Before asset creation status of asset set to not reviewed
	 * obtain file type, file size, date created
	 * 
	 */
	public function beforeSave(){

		 $this->status=0;
		if(!($this->scenario=='update')){
		 $this->type=$this->file->getType();
         $this->size=$this->file->getSize();
         $this->createDate=new CDbExpression('NOW()');
		}
         return parent::beforeSave();
       }

       
    /**
     * get model name
     */
	public function getModelName(){
		return __CLASS__;
	}
	
	/**
	 * get oldAttributes
	 */
	public function afterFind(){
    	 $this->oldAttributes = $this->attributes;
    	 
   		 return parent::afterFind();
	}
	
       
    /**
     * adding details to log the asset save 
     */  
    public function afterSave()
    {
    	    	
    	$Log = Logger::getLogger("accessLog");
	  	
    	if($this->oldAttributes==NULL)
    		$action="create";
    	else 	
    		$action="update";
    	
    	$uid=Yii::app()->user->getState("uid");
	 	$Log->info($uid."\t".Yii::app()->user->name."\t".$this->getModelName()."\t".$action."\t".$this->assetId);	
	  
	 	
    	if($this->assetName != $this->oldAttributes['assetName'])
	 	{$Log->info("assetName ".$this->oldAttributes['assetName']." ".$this->assetName);}
    	if($this->file != $this->oldAttributes['file'])
	 	{$Log->info("file ".$this->oldAttributes['file']." ".$this->file);}
    	if($this->createDate != $this->oldAttributes['createDate'])
	 	{$Log->info("createDate ".$this->oldAttributes['createDate']." ".$this->createDate);}
	 	if($this->description != $this->oldAttributes['descriprion'])
	 	{$Log->info("description ".$this->oldAttributes['description']." ".$this->description);}
    	if($this->comment != $this->oldAttributes['comment'])
	 	{$Log->info("comment ".$this->oldAttributes['comment']." ".$this->comment);}
    	if($this->description != $this->oldAttributes['descriprion'])
	 	{$Log->info("description ".$this->oldAttributes['description']." ".$this->description);}
    	if($this->status != $this->oldAttributes['status'])
	 	{$Log->info("status ".$this->oldAttributes['status']." ".$this->status);}
	 	if($this->publication != $this->oldAttributes['publication'])
	 	{$Log->info("publication ".$this->oldAttributes['publication']." ".$this->publication);}
    	if($this->onlineEditable != $this->oldAttributes['onlineEditable'])
	 	{$Log->info("onlineEditable ".$this->oldAttributes['onlineEditable']." ".$this->onlineEditable);}
    	if($this->onlineEditable != $this->oldAttributes['onlineEditable'])
	 	{$Log->info("onlineEditable ".$this->oldAttributes['onlineEditable']." ".$this->onlineEditable);}
    	if($this->size != $this->oldAttributes['size'])
	 	{$Log->info("size ".$this->oldAttributes['size']." ".$this->size);}
    	if($this->type != $this->oldAttributes['type'])
	 	{$Log->info("type ".$this->oldAttributes['type']." ".$this->type);}
    	if($this->reviewer != $this->oldAttributes['reviewer'])
	 	{$Log->info("reviewer ".$this->oldAttributes['reviewer']." ".$this->reviewer);}
    	if($this->reviewerComments != $this->oldAttributes['reviewerComments'])
	 	{$Log->info("reviewerComments ".$this->oldAttributes['reviewerComments']." ".$this->reviewerComments);}
    	if($this->ownerId != $this->oldAttributes['ownerId'])
	 	{$Log->info("ownerId ".$this->oldAttributes['ownerId']." ".$this->ownerId);}
    	
    	
    	return parent::afterSave();
    }   

    /**
     * Status
     * @return
     * NOT REVIEWED - 0
     * REVIEWED     - 1
     * CHECK OUT    - 2
     * CHECKED IN   - 3
     * BLOCKED      - 4 
     * REJECTED     - 5
     */
	public function getStatus(){     
									
    	if($this->status==0)       
    	 return "NOT REVIEWED";
    	elseif($this->status==1)
    	 return "REVIEWED";
     	elseif($this->status==2)
    	 return "CHECKOUT";
    	elseif($this->status==3)
    	 return "CHECK IN"; 
    	elseif($this->status==4)
    	 return "BLOCKED";
    	elseif($this->status==5)
    	 return "REJECTED"; 
    	 
    	 
    }
    
    /**
     * returns the publication status
     * @return Yes - 0
     *         No  - 0
     * 
     */
    public function getPublication(){
     if($this->publication==0)
      return "Yes";
     if($this->publication==1)
      return "No";
    
    }
    
    /**
     * returns the online edit permission
     * @return Yes - 0
     * No - 1 
     */
	public function getOnlineEditable(){
     if($this->onlineEditable==0)
      return "Yes";
     if($this->onlineEditable==1)
      return "No";
    
    }
    
    /**
     * obtain tagsName related to asset
     * this model - assetId
     * related tagId from asset_tags model
     * tagName from Tags table
     * relation Name -  tags
     * @return list of asset related tags
     */
    public function getTags()
		{
    		$ret = "";
    		$first = true;
    		
    		foreach ($this->tags as $record) {

        	if ($first === true) {
            	$first = false;
        	} else {
            $ret .= ', ';
        	}

        $ret .= "<a href='#'>".$record->tagName."</a>";
    	}
		
	    return $ret;
		}
	
	/**
	 * getUrl function
	 * 
	 */
	public function getUrl()
		{
			return Yii::app()->createUrl('', array(
		
			));
		}
		
	/**
	 * Obtain array of tags as links
	 * 
	 */
	public function getTagLinks()
		{
			$links=array();
			foreach(Asset::string2array($this->file) as $tag)
				$links[]=CHtml::link(CHtml::encode($tag), array(''));
			return $links;
		}
		
               
}