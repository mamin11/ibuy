<?php 
class User{
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedin;

    public function __construct($user = null){
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$user){ //if the user has not been defined
            //check if the user exists and get their session name
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);
                // echo $user;
                
                //check if user exists and get their data and set logged in to true
                if($this->find($user)){
                    $this->_isLoggedin = true;
                } else {
                    //process the logout
                }
            }
        } else { // if the user been defined
            $this->find($user); 
        }
    }

    public function update($col, $field = array(), $id=null){
        
        if(!$id && $this->isLoggedin()){
            $id = $this->data()->user_id;
        }

        if(!$this->_db->update('webass1.users', $col, $id, $field)){
            throw new Execption('There was a problem updating.');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('webass1.users', $fields)){
            throw new Execption('There was a problem creating the account');
        }
    }

    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'user_id' : 'username';
            $data = $this->_db->getAll('webass1.users', array($field, '=', $user));

            if($data->count()){
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($username = null, $user_password = null, $remember = false){

        if(!$username && !$user_password && $this->exists()){
            //if no username and password have been defined and the user exists, log the user in by starting a session
            Session::put($this->_sessionName, $this->data()->user_id);

        } else {

        $user = $this->find($username);
        $userpassedPword = $this->data()->user_password;
        $userpInDB = $this->_db->get('user_password', 'webass1.users', array('username', '=',$username));
        

        if($user){
            if($userpassedPword === ($user_password)){
                //,  Hash::make$this->data()->salt
                //$this->_db->get('webass1.users', array($user_password, '=', 'user_password')
                Session::put($this->_sessionName, $this->data()->user_id);

                if($remember){
                    //if remember me is checked store user data in cookie
                    $hash = Hash::unique(); //create a unique hash for the cookie
                    $hashCheck = $this->_db->getAll('webass1.users_session', array('user_id', '=', $this->data()->user_id));
                    //check if the hash already exists in the db

                    if(!$hashCheck->count()){
                    //if the hash check returns insert the data 
                    $this->_db->insert('webass1.users_session',array(
                        'user_id' => $this->data()->user_id,
                        'hash' => $hash
                    ));
                    } else {
                        $hash = $hashCheck->first()->hash;
                    }

                    Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

                }
                echo 'OK';
                return true;   
            }else {
                echo 'Soryy';
            }
        }
    }
        return false;

    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function logout(){
        //delete the cookie hash from the database for the user
        $this->_db->delete('webass1.users_session', array('user_id', '=', $this->data()->user_id));
        //delete the session and remember me cookie of that user
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data(){
        return $this->_data;
    }

    public function isLoggedin(){
        //any other thing needed to be returned can also be put here
        return $this->_isLoggedin;
    }

    public function hasPermission($key){
        $group = $this->_db->getAll('webass1.groups', array('id', '=', $this->data()->user_group));
        // print_r($group->first());
        if($group->count()){
            $permissions = json_decode($group->first()->permissions, true);

            if($permissions[$key] == true){
                return true;
            }
        }
        return false;
    }
}