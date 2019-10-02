<?php
class Db {
    private static $instance = null;
    private $_db;

    private function __construct()
    {
        try {
            $this->_db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.DB_NAME.';charset='.CHARSET, 'root', '');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        }
		catch (PDOException $e) {
		    die('Connection error to db : '.$e->getMessage());
        }
    }

	# Pattern Singleton to have one connection to the db
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    #------------DB Member--------------------
    public function insert_member($login,$password,$name,$first_name,$phone,$email,$bank_account,$address,$photo,$duty,$validate,$role_name) {
        $query = 'INSERT INTO members (login, password, name, first_name, phone, email, bank_account, address, photo, duty, validate, role_name)
        values (:login, :password, :name, :first_name, :phone, :email, :bank_account, :address, :photo, :duty, :validate, :role_name)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':password',$password);
        $ps->bindValue(':name',$name);
        $ps->bindValue(':first_name',$first_name);
        $ps->bindValue(':phone',$phone);
        $ps->bindValue(':email',$email);
        $ps->bindValue(':bank_account',$bank_account);
        $ps->bindValue(':address',$address);
        $ps->bindValue(':photo',$photo);
        $ps->bindValue(':duty',$duty);
        $ps->bindValue(':validate',$validate);
        $ps->bindValue(':role_name',$role_name);
        return $ps->execute();
	}

	public function validate_member($login,$password) {
		$query = 'SELECT password from members WHERE login=:login';
		$ps = $this->_db->prepare($query);
		$ps->bindValue(':login',$login);
		$ps->execute();
		if ($ps->rowcount() == 0)
			return false;
		$hash = $ps->fetch()->password;
		return password_verify($password, $hash);
	}

	public function login_exists($login) {
		$query = 'SELECT * from members WHERE login=:login';
		$ps = $this->_db->prepare($query);
		$ps->bindValue(':login',$login);
		$ps->execute();
		return ($ps->rowcount() != 0);
	}

  public function select_member($login){
    $query = 'SELECT * from members WHERE login=:login';
    $ps = $this->_db->prepare($query);
    $ps->bindValue(':login',$login);
    $ps->execute();
    $row = $ps->fetch();
    return new Member($row->login,$row->password,$row->name,$row->first_name,$row->phone,$row->email,$row->bank_account,$row->address,$row->photo,$row->duty,$row->validate,$row->role_name);
  }

  public function select_members(){
    $query = 'SELECT * from members WHERE validate=1 ORDER BY name' ;
    $ps = $this->_db->prepare($query);
    $ps->execute();
    $table = array();
		while ($row = $ps->fetch()) {
				$table[] = new Member($row->login,$row->password,$row->name,$row->first_name,$row->phone,$row->email,$row->bank_account,$row->address,$row->photo,$row->duty,$row->validate,$row->role_name);
      }
		return $table;
  }

  public function select_invalid_member(){
    $query = 'SELECT * from members WHERE validate=0 ORDER BY name';
    $ps = $this->_db->prepare($query);
    $ps->execute();
    $table = array();
		while ($row = $ps->fetch()) {
				$table[] = new Member($row->login,$row->password,$row->name,$row->first_name,$row->phone,$row->email,$row->bank_account,$row->address,$row->photo,$row->duty,$row->validate,$row->role_name);
      }
		return $table;
  }

  public function change_validate($login,$validate){
    $query = 'UPDATE members SET validate=:validate WHERE login=:login';
    $ps = $this->_db->prepare($query);
    $ps->bindValue(':login',$login);
    $ps->bindValue(':validate',$validate);
    $ps->execute();
  }

  public function change_duty($login,$change_duty){
    $query = 'UPDATE members SET duty=:change_duty WHERE login=:login';
    $ps = $this->_db->prepare($query);
    $ps->bindValue(':login',$login);
    $ps->bindValue(':change_duty',$change_duty);
    $ps->execute();
  }

  public function change_role_name($login,$role_name){
    $query = 'UPDATE members SET role_name=:role_name WHERE login=:login';
    $ps = $this->_db->prepare($query);
    $ps->bindValue(':login',$login);
    $ps->bindValue(':role_name',$role_name);
    $ps->execute();
  }

  public function number_of_responsible_member(){
    $query="SELECT * FROM members WHERE duty='r' OR duty='c'";
    $ps= $this->_db->prepare($query);
    $ps->execute();
    return $ps->rowcount();
  }

    public function select_passwd($login){
        $query = "SELECT password FROM members WHERE login =:login";
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login', $login);
        $ps->execute();
        $res = $ps->fetch()->password;
        return $res;
    }

    public function update_passwd($login,$passwd){
        $query = 'UPDATE members SET  password =:passwd WHERE login = :login';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':passwd',$passwd);
        $ps->bindValue(':login',$login);
        $ps->execute();

    }

    public function update_profile($login,$email,$phone,$address,$bank){
        $query = 'UPDATE members SET  email =:email,phone=:phone,address=:address,bank_account=:bank WHERE login = :login';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':email',$email);
        $ps->bindValue(':phone',$phone);
        $ps->bindValue(':address',$address);
        $ps->bindValue(':bank',$bank);
        $ps->execute();
    }

    public function update_profile_picture($login,$photo){
        $query = 'UPDATE members SET  photo =:photo WHERE login = :login';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':photo',$photo);
        $ps->bindValue(':login',$login);
        $ps->execute();
    }

    #--------------DB Events---------------------------------

    public function select_past_events(){
        $query = 'SELECT * from events WHERE  end_date<NOW() AND start_date<NOW()';
        $ps = $this->_db->prepare($query);
        $ps->execute();
        $array_event = array();
        while ($row = $ps->fetch()) {
            $array_event[] = new Event($row->event_id,$row->name,$row->address,$row->price,
            $row->start_date,$row->end_date,$row->url_photo,$row->descriptive,$row->latitude,$row->longitude);
        }
        return $array_event;
    }

    public function select_futur_events(){
        $query = 'SELECT * from events WHERE  start_date>=NOW() AND end_date>=NOW()';
        $ps = $this->_db->prepare($query);
        $ps->execute();
        $array_event = array();
        while ($row = $ps->fetch()) {
            $array_event[] = new Event($row->event_id,$row->name,$row->address,$row->price,
            $row->start_date,$row->end_date,$row->url_photo,$row->descriptive,$row->latitude,$row->longitude);
        }
        return $array_event;
    }

    public function select_event($event_id){
        $query = 'SELECT * from events WHERE event_id=:event_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':event_id',$event_id);
        $ps->execute();
        if ($ps->rowcount() == 0){
            return 1;
        }
        $row = $ps->fetch();
        return new Event($row->event_id,$row->name,$row->address,$row->price,
        $row->start_date,$row->end_date,$row->url_photo,$row->descriptive,$row->latitude,$row->longitude);
    }

    public function verify_event_id($event_id){
        #return true if the event id exist
        $query = 'SELECT * from events WHERE event_id=:event_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':event_id',$event_id);
        $ps->execute();
        if ($ps->rowcount() != 0 && !preg_match ("/[^0-9]/", $event_id)){
            return true;
        }
        else {
            return false;
        }
    }

    public function verify_interested($login,$event_id){
        #return true if the member is already interested
        $query = 'SELECT * from interested_members WHERE login = :login AND event_id=:event_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':event_id',$event_id);
        $ps->execute();
        if ($ps->rowcount() == 1){
            return true;
        }
        else {
            return false;
        }
    }

    public function verify_registered($login,$event_id){
        #return true if the member is already sub
        $query = 'SELECT * from registered_members WHERE login = :login AND event_id=:event_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':event_id',$event_id);
        $ps->execute();
        if ($ps->rowcount() == 1){
            return true;
        }
        else {
            return false;
        }
    }

    public function select_interested($event_id){
      #return an array of interested members to a event
      $query = 'SELECT * from interested_members WHERE event_id=:event_id';
      $ps = $this->_db->prepare($query);
      $ps->bindValue(':event_id',$event_id);
      $ps->execute();
      $array = array();
      while ($row = $ps->fetch()) {
          $array[]= new InterestedMembers($row->login,$row->event_id);
      }
      return $array;
    }

    public function select_registered($event_id){
      #return an array of interested members to a event
      $query = 'SELECT * from registered_members WHERE event_id=:event_id';
      $ps = $this->_db->prepare($query);
      $ps->bindValue(':event_id',$event_id);
      $ps->execute();
      $array = array();
      while ($row = $ps->fetch()) {
          $array[]= new RegisteredMembers($row->login,$row->event_id,$row->payed);
      }
      return $array;
    }

    public function payed_registered($login,$event_id){
      #return true if the member payed his registration to the event
      $query = 'SELECT * from registered_members WHERE login=:login AND event_id=:event_id AND payed=1';
      $ps = $this->_db->prepare($query);
      $ps->bindValue(':event_id',$event_id);
      $ps->bindValue(':login',$login);
      $ps->execute();
      return $ps->rowcount()!=0;

    }

    public function update_payed_registered($login,$event_id,$payed){
      $query='UPDATE registered_members SET payed=:payed';
      $ps = $this->_db->prepare($query);
      $ps->bindValue(':payed',$payed);
      $ps->execute();
    }

    public function delete_interested($login,$event_id){
        #delete an interested member for an event
        $query = 'DELETE FROM interested_members WHERE login=:login AND event_id = :event_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':event_id',$event_id);
        return $ps->execute();
    }

    public function delete_all_interested($event_id){
      $query = 'DELETE FROM interested_members WHERE  event_id = :event_id';
      $ps = $this->_db->prepare($query);
      $ps->bindValue(':event_id',$event_id);
      return $ps->execute();
    }

    public function delete_all_registered($event_id){
      $query = 'DELETE FROM registered_members WHERE event_id = :event_id';
      $ps = $this->_db->prepare($query);
      $ps->bindValue(':event_id',$event_id);
      return $ps->execute();
    }

    public function insert_interested($login,$event_id){
        #insert an interested member for an event
        if($this->verify_interested($login,$event_id)==false){
            $query = 'INSERT INTO interested_members(login, event_id)values (:login, :event_id)';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':login',$login);
            $ps->bindValue(':event_id',$event_id);
            return $ps->execute();
        }
    }

    public function select_button_interested($login,$event_id){
        #return an interested button or a not insterested button
        $query = 'SELECT * from interested_members WHERE login = :login AND event_id=:event_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':event_id',$event_id);
        $ps->execute();
        if ($ps->rowcount() == 0){
            return "<input class = 'btn btn-info' type='submit' name='interested' value='Je suis interessé'>";
        }
        else {
            return "<input class = 'btn btn-danger' type='submit' name='interested' value='Je ne suis plus interessé'>";
        }
    }

    public function insert_event($name,$address,$price,$start_date,$end_date,$url_photo,$descriptive,$latitude,$longitude){
        $query= 'INSERT INTO events(event_id,name,address,price,start_date,end_date,url_photo,descriptive,latitude,longitude)
                  VALUES (NULL,:name,:address,:price,:start_date,:end_date,:url_photo,:descriptive,:latitude,:longitude)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':name',$name);
        $ps->bindValue(':address',$address);
        $ps->bindValue(':price',$price);
        $ps->bindValue(':start_date',$start_date);
        $ps->bindValue(':end_date',$end_date);
        $ps->bindValue(':url_photo',$url_photo);
        $ps->bindValue(':descriptive',$descriptive);
        $ps->bindValue(':latitude',$latitude);
        $ps->bindValue(':longitude',$longitude);
        $ps->execute();
        return $this->_db->lastInsertId();
    }

    public function update_event($event_id,$name,$address,$price,$start_date,$end_date,$url_photo,$descriptive,$latitude,$longitude){
     $query= 'UPDATE events SET name=:name, address=:address, price=:price, start_date=:start_date, end_date=:end_date, url_photo=:url_photo, descriptive=:descriptive, latitude=:latitude, longitude=:longitude WHERE event_id=:event_id';
     $ps = $this->_db->prepare($query);
     $ps->bindValue(':event_id',$event_id);
     $ps->bindValue(':name',$name);
     $ps->bindValue(':address',$address);
     $ps->bindValue(':price',$price);
     $ps->bindValue(':start_date',$start_date);
     $ps->bindValue(':end_date',$end_date);
     $ps->bindValue(':url_photo',$url_photo);
     $ps->bindValue(':descriptive',$descriptive);
     $ps->bindValue(':latitude',$latitude);
     $ps->bindValue(':longitude',$longitude);
     $ps->execute();
    }

    public function delete_event($event_id){
      $query='DELETE FROM events WHERE event_id=:event_id';
      $ps = $this->_db->prepare($query);
      $ps->bindValue(':event_id',$event_id);
      return $ps->execute();
    }

    public function select_button_subscribe($login,$event_id){
        #return a subscribe button or an unscribed button
        $query = 'SELECT * from registered_members WHERE login = :login AND event_id=:event_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':event_id',$event_id);
        $ps->execute();
        if ($ps->rowcount() == 0){
            return "<input class = 'btn btn-success' type='submit' name='subscribe' value = Inscrire>";
        }
        else {
            return "<input class = 'btn btn-danger' type='submit' name='subscribe' value = 'Se désinscrire'>";
        }
    }

    public function delete_subscribe($login,$event_id){
        #delete a subscribed member for an event
        $query = 'DELETE FROM registered_members WHERE login=:login AND event_id = :event_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':event_id',$event_id);
        return $ps->execute();
    }

    public function insert_subscribe($login,$event_id){
        #insert a subscribed member for an event
        if($this->verify_registered($login,$event_id)==false){
            $query = 'INSERT INTO registered_members(login, event_id, payed)values (:login, :event_id,0)';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':login',$login);
            $ps->bindValue(':event_id',$event_id);
            return $ps->execute();
        }
    }

    #-----------------DB Member_fees----------------------------------------

    public function insert_member_fees($login,$year){
      if(!$this->payed_member_fees($login,$year)){
        $query= 'INSERT INTO member_fees(login,year) VALUES (:login,:year)';
        $ps=$this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':year',$year);
        $ps->execute();
      }
    }

    public function payed_member_fees($login,$year){
      $query='SELECT * FROM member_fees WHERE login=:login AND year=:year';
      $ps=$this->_db->prepare($query);
      $ps->bindValue(':year',$year);
      $ps->bindValue(':login',$login);
      $ps->execute();
      return $ps->rowcount()!=0;
    }

    public function select_payed_member_fees($login,$year){
      $query='SELECT login FROM member_fees WHERE login=:login AND year=:year ';
      $ps=$this->_db->prepare($query);
      $ps->bindValue(':login',$login);
      $ps->bindValue(':year',$year);
      $row = $ps->fetch();
  		return new MemberFees($row->$login,$row->$year);

    }

    #----------------------DB annual_member_fees-----------------------------

    public function insert_annual_member_fees($year,$price){
      $query='INSERT INTO annual_member_fees(year,price) VALUES (:year,:price)';
      $ps=$this->_db->prepare($query);
      $ps->bindValue(':year',$year);
      $ps->bindValue(':price',$price);
      $ps->execute();
    }

    public function annual_member_fees_exists($year){
      $query='SELECT * FROM annual_member_fees WHERE year=:year';
      $ps=$this->_db->prepare($query);
      $ps->bindValue(':year',$year);
      $ps->execute();
  		return ($ps->rowcount() != 0);
    }

    #---------------------------DB Training------------------------------

      public function verify_training_id($training_id){
            #return true if the training id exist
            $query = 'SELECT * from training WHERE training_id=:training_id';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':training_id',$training_id);
            $ps->execute();
            if ($ps->rowcount() != 0 && !preg_match ("/[^0-9]/", $training_id)){
                return true;
            }
            else {
                return false;
            }
        }

        public function select_training($training_id){
            $query = 'SELECT * from training WHERE training_id=:training_id';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':training_id',$training_id);
            $ps->execute();
            $array_training = array();
            $row = $ps->fetch();
            return new Training($row->training_id,$row->descriptive);

        }

        public function select_all_training(){
            $query = 'SELECT * from training';
            $ps = $this->_db->prepare($query);
            $ps->execute();
            $array_training = array();
            while ($row = $ps->fetch()) {
                $array_training[] = new Training($row->training_id,$row->descriptive);
            }
            return $array_training;
        }

        public function select_training_days($training_id){
            #select all the training days of the training
            $query = 'SELECT * from training_day WHERE training_id=:training_id ORDER BY date DESC';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':training_id',$training_id);
            $ps->execute();
            $array_training_days = array();
            while ($row = $ps->fetch()) {
                $modified_date = $row->date;
                $modified_date = date("d/m/Y", strtotime($modified_date));
                $array_training_days[] = new TrainingDay($row->training_id,$modified_date,$row->activity);
            }
            return $array_training_days;
        }

    public function select_training_days_of_week($training_id){
        #select all the training days of the week
        $date =date("Y-m-d");
        $query = "SELECT * from training_day WHERE training_id=:training_id AND date >= :date AND activity != '' ORDER BY date ASC LIMIT 7";
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':training_id',$training_id);
        $ps->bindValue(':date',$date);
        $ps->execute();
        $array_training_days = array();
        while ($row = $ps->fetch()) {
            $modified_date = $row->date;
            $modified_date = date("d/m/Y", strtotime($modified_date));
            $array_training_days[] = new TrainingDay($row->training_id,$modified_date,$row->activity);
        }
        return $array_training_days;
    }

    public function select_followed_training($login){
        #return the current training followed by the user
        $query = 'SELECT * from members_training WHERE login=:login ORDER BY following_date DESC LIMIT 1';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->execute();
        $row = $ps->fetch();
        if($ps->rowcount()==1) return $row->training_id;
        else return 1;
    }

    public function exist_followed_training($login,$training_id){
        #return true if the user already followed this training before
        $query = 'SELECT * from members_training WHERE login=:login AND training_id=:training_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':training_id',$training_id);
        $ps->execute();
        if ($ps->rowcount() != 0){
            return true;
        }
        else {
            return false;
        }
    }

    public function insert_member_training($login,$training_id){
        #create a member_training in db
        $query = 'INSERT INTO members_training (login, training_id, following_date)values (:login, :training_id, :following_date)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':training_id',$training_id);
        $ps->bindValue(':following_date',date('Y-m-d H:i:s'));
        return $ps->execute();
    }

    public function select_members_training($training_id){
        #return an array with all the members following the training_id
        $array_members = $this->select_members();
        $array = array();
        foreach ($array_members as $i => $member) {
            $login = $member->html_login();
            $following = $this->select_followed_training($login);
            if($following == $training_id) $array[]=$login;
        }
        return $array;
    }

    public function update_following_date($login,$training_id){
        #update the following date of member_training
        $query = 'UPDATE members_training SET  following_date =:following_date WHERE login = :login AND training_id=:training_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':training_id',$training_id);
        $ps->bindValue(':following_date',date('Y-m-d H:i:s'));
        return $ps->execute();
    }

    public function insert_training($descriptive){
        #insert a training in DB
        $query = 'INSERT INTO training (training_id, descriptive) VALUES (NULL,:descriptive)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':descriptive',$descriptive);
        $ps->execute();
        return $this->_db->lastInsertId();
    }

    public function delete_all_training_days($training_id){
        #delete all the days of a training
        $query = 'DELETE FROM training_day WHERE training_id = :training_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':training_id',$training_id);
        return $ps->execute();
    }

    public function delete_all_members_training($training_id){
        #delete all the members affiliate to a training
        $query = 'DELETE FROM members_training WHERE training_id = :training_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':training_id',$training_id);
        return $ps->execute();
    }

    public function delete_training($training_id){
        #delete the training
        $query = 'DELETE FROM training WHERE training_id = :training_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':training_id',$training_id);
        return $ps->execute();
    }

    public function exist_training_day($training_id,$date){
        #return true if the day already exist
        $query = 'SELECT * from training_day WHERE date=:date AND training_id=:training_id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':date',$date);
        $ps->bindValue(':training_id',$training_id);
        $ps->execute();
        if ($ps->rowcount() != 0){
            return true;
        }
        else {
            return false;
        }
    }

    public function insert_training_days($training_id,$activity,$date){
        #insert a training day
        if(!$this->exist_training_day($training_id,$date)){
            $activity = trim($activity);
            $query = 'INSERT INTO training_day (training_id, activity, date) VALUES (:training_id,:activity,:date)';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':training_id',$training_id);
            $ps->bindValue(':activity',$activity);
            $ps->bindValue(':date',$date);
            $ps->execute();
        }

    }

    public function import_training_days($training_id,$csv){
        #import days of training from csv file
        $this->delete_all_training_days($training_id);
        $fcontents = file($csv);
        foreach ($fcontents as $i => $day) {
            preg_match("/(.*);(.*)/", $day, $result);
            if(count($result) > 2){
                $temp_date = str_replace("/","-",$result[1]); #change to jj-mm-aaaa for strtotime
                if(strtotime($temp_date)!=false){
                    $temp_date = date('Y-m-d', strtotime($temp_date)); #change to american date
                    $this->insert_training_days($training_id,$result[2],$temp_date);
                }
            }
        }
    }

    public function update_training_day($training_id,$date,$activity){
        #update a training day
        $date = str_replace("/","-",$date);; #change to jj-mm-aaaa for strtotime
        $date = date('Y-m-d', strtotime($date)); #change to american date
        $query = 'UPDATE training_day SET  activity =:activity WHERE training_id = :training_id AND date = :date';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':activity',$activity);
        $ps->bindValue(':training_id',$training_id);
        $ps->bindValue(':date',$date);
        return $ps->execute();

    }




}
?>
