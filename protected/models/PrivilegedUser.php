<?php
class PrivilegedUser extends Users
{
	public $roles;

	/**
	 * override the method if required
	 */
	
	public static function getByUsername($uid){
	 
	 //$uid = Yii::app()->user->getState("uid");
	 $user = Users::model()->find('uid=:uid',array('uid'=>$uid));
	 $privUser = new PrivilegedUser;
	 $privUser->initRoles($uid); 
	 $privUser = $user;	
	 return $privUser;	
	}
	
	/*
	 
		public static function getByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":username" => $username));
        $result = $sth->fetchAll();
 
        if (!empty($result)) {
            $privUser = new PrivilegedUser();
            $privUser->user_id = $result[0]["user_id"];
            $privUser->username = $username;
            $privUser->password = $result[0]["password"];
            $privUser->email_addr = $result[0]["email_addr"];
            $privUser->initRoles();
            return $privUser;
        } else {
            return false;
        }
    }
 
	  
	 */
	
	
	/**
	 * init function to load roles
	 * populate roles with associated permissions
	 */
	public function initRoles($uid){
		$this->roles = array();
		$sql = "select t1.role_rid,t2.name from users_has_role as t1
				join role as t2 on t1.role_rid = t2.rid
				where t1.users_uid = :uid";
		$connection=Yii::app()->db;
		$command = $connection->createCommand($sql);
	    $command->bindParam(":uid",$uid,PDO::PARAM_INT);
		$this->roles = $command->queryAll();
		$roles = $this->roles;
		//print_r($this->roles);die();
		foreach($this->roles as $role){
			$this->roles[$role["name"]] = Role::getRolePerms($role["role_rid"]);
		}
	}
	
	/**
	 * check whether a user has a special permission
	 */
	public function hasPrivilege($permission){
		foreach($this->roles as $role){
		 if($role->hasPerm($permission)){
		  	
		 	return true;}
		}
		return false;
	}
}

