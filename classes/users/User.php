<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
class User{
    
    private $data;
    private $id;
    public $balance, $playername, $chips, $email, $referral, $location, $gender, $api_id, $ssid,$registered, $totalrake, $comission;
    
    public function __construct($id){
        $sql = new SQlConnection();
        $temp = $sql->getArray("SELECT * FROM poker_users WHERE id=$id");
        if(count($temp)){
            $temp = $temp[0];
            $this->id = $temp['id'];
            $this->balance = $temp['balance'];
            $this->playername = $temp['name'];
            $this->chips = $temp['chips'];
            $this->email = $temp['email'];
            $this->referral = $temp['referral'];
            $this->password = $temp['password'];
            $this->realname = $temp['realname'];
            $this->location = $temp['location'];
            $this->gender = $temp['gender'];
            $this->api_id = $temp['api_id'];
            $this->registered = $temp['registered'];
            $this->totalrake = $temp['totalrake'];
            $this->rake = $temp['rake'];
            $this->income = $temp['income']*1;
            $this->income_paid = $temp['income_paid']*1;
            $this->rake_parsed = $temp['rake_parsed'];
            $this->comission = $temp['comission']*1;
            $this->level2_comission = $temp['level2_comission']*1;
            $this->level2 = $temp["level2"];
            $this->ssid = $temp["ssid"];
            $this->points = $temp['points'];
            $this->points_dec = $temp['points_dec']*1;
            $this->tournaments_fee = $temp['tournaments_fee']*1;
            $this->referral_level = $temp["referral_level"]*1;
            $this->link2_commission = $temp["link2_commission"]*1;
        }
    }
    
    public function getId(){
        return $this->id;
    }

    public function submitChanges(){
        
        $rake_grabbed = $this->getRake();
        $rake_grabbed = $rake_grabbed['date'];
        if(!$rake_grabbed) $rake_grabbed = date("Y-m-d H:i:s");
        
        $sql = new SQLConnection;
        $q = "UPDATE poker_users
        SET 
            balance = {$this->balance}
            ,name = '{$this->playername}'
            ,points = {$this->points}
            ,points_dec = {$this->points_dec}
            ,tournaments_fee = {$this->tournaments_fee}
            ,chips = {$this->chips}
            ,email = '{$this->email}'
            ,referral = '{$this->referral}'
            ,referral_level = {$this->referral_level}
            ,password = '{$this->password}'
            ,realname = '{$this->realname}'
            ,location = '{$this->location}'
            ,gender = {$this->gender}
            ,api_id = {$this->api_id}
            ,registered = '{$this->registered}'
            ,totalrake = '{$this->totalrake}'
            ,rake = {$this->getRakeValue()}
            ,rake_parsed = '$rake_grabbed'
            ,comission = {$this->comission}
            ,level2 = {$this->level2}
            ,level2_comission = {$this->level2_comission}
            ,link2_commission = {$this->link2_commission}
            ,ssid = '{$this->ssid}'
            
        WHERE id = {$this->id}";
        $sql->query($q);
        
        if (mysqli_error($sql->DBSource)) Logger::addReport("User::submitChanges",Logger::STATUS_ERROR, mysqli_error
            ($sql->DBSource)." $q");
    }
    
    public function resetIncome($val){
        $sql = new SQLConnection;
        $val*=1;
        
        $q = "UPDATE poker_users
        SET income = $val
        WHERE id = {$this->id}";
        $sql->query($q);
        $this->income = $val;
    }
    
    public function payIncome(){
        $diff = $this->income - $this->income_paid;
        $sql = new SQLConnection;
        
        $q = "UPDATE poker_users
            SET income_paid = {$this->income}
            WHERE id = {$this->id}";
        $sql->query($q);
        
        $amount = $this->chipsToPay();
        $res = Poker_Accounts::IncBalance(["Player"=>$this->playername,"Amount"=>$amount]);
        
        if($res['Balance']){
            Poker_Transactions::chipsTransaction(NULL, $this, $amount, TRUE);
            $this->income_paid = $this->income = $res['Balance']*1;
            return $amount;
            
        }
        return FALSE;
    }
    
    public function rakeToPay(){
        return $this->income - $this->income_paid;
    }
    
    public function chipsToPay(){
        return round($this->rakeToPay()*$this->comission*100)/100;
    }
    
    public function chipsPaid(){
          return round($this->income_paid*$this->comission*100)/100;
    }
    
    public function requestFrame(){
        $sql = new SQLConnection();
        FrameRequests::request($this);
    }
    
    public function getRake(){
        return json_decode($this->totalrake,true);
    }
    
    public function getRakeValue(){
        $rake = $this->getRake();
        return $rake['rake']*1;
    }
    
    public function cacheRake($rake){
        $this->totalrake=json_encode(array("rake"=>$rake,"date"=>date("Y-m-d H:i:s")));
        $this->submitChanges();
    }
    
    public function getReferrals(){
        
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_users WHERE referral=".$this->id);
        
        $res = [];
        foreach($temp as $u){
            $res[] = new User($u['id']);
        }
        
        return $res;
        
    }

    public function getAffilateBalance(){
        $sql = new SQLConnection;
        
        $temp = $sql->getArray("SELECT * FROM poker_player_rake");
        $rakeUser = [];
        $totalHandRakeReferral = $totalTournamentFee = $totalFreerollFeeReferal = 0;

        $totalBalance = 0;
        if($temp){
            foreach ($temp as $key => $value) {
                $rakeUser[$value['player_name']] = $value['total_rake'];
            }
        }

        $refs = $this->getReferrals();
        
        foreach($refs as $u){
            if($u->referral_level != 1){
                continue;
            }

            $uRake = (isset($rakeUser[$u->playername])) ? $rakeUser[$u->playername] : 0;
            $uRake = $uRake + $u->tournaments_fee;
            $totalBalance = $totalBalance + $uRake*$this->comission;

            if($this->level2){
                $totalBalance = $totalBalance + $u->countAffiliatesRake()*$this->level2_comission;
            }
        }

     //   if($this->level2){
            foreach($refs as $u){
                if($u->referral_level == 1){
                    continue;
                }
                $totalBalance = $totalBalance +  $u->countAffiliatesRake()*$this->link2_commission;
            }
      //  }

        $transferHistorySql =  $sql->getArray("SELECT * FROM poker_users_transfer WHERE `playername`= '$this->playername' AND `status` = 1");
        $transerHistoryBalance = 0;
        if($transferHistorySql){
            foreach ($transferHistorySql as $key => $value) {
                $transerHistoryBalance += $value['amount'];
            }
        }

        return $totalBalance - $transerHistoryBalance;
    }
    
    
    public function getReferralsArray(){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_users WHERE referral=".$this->id);
        
        $res = [];
        foreach($temp as $i=>$v){
            
            $rake = json_decode($v['totalrake'],true);
            $rake = $rake['rake'];
            
            $res[] = array(
                    "realname"=>$v['realname'] 
                    ,"playername"=>($v['referral_level']*1 ==2 ?"[L2] " : "").$v['name']
                    ,"email"=>$v['email']
                    ,"comission"=>$v['comission']*1
                    ,"level2_comission"=>$v["level2_comission"]*1
                    ,"earned"=>$v['comission']*$rake/100
                    ,"referral_level"=>$v['referral_level']*1
                    ,"rake"=>$rake
                    ,"tournaments_fee"=>$v['tournaments_fee']
                    ,"registered"=>$v['registered']
                    ,"id"=>$v['id']
                );
        }
        
        return $res;
    }
    
    public function allowedLevel2(){
        
        return $this->level2 ? true : false;
    }
    
    public function countAffiliatesRake(){
        $refs = $this->getReferrals();
        $sum=0;
        foreach($refs as $u){
            if(!$this->level2){
                if($u->referral_level == 1){
                    $sum+=$u->rake;
                }else{
                    $sum+=$u->countAffiliatesRake();
                }
               
            }else{
                    $sum+=$u->rake+$u->countAffiliatesRake(); 
            }
            $sum += $u->tournaments_fee;
        }
        
        
        $this->resetIncome($sum);
        return $sum;
        
    }
    
    
    public function getRealReferrals(){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_users WHERE referral=".$this->id." AND registered<DATE_SUB(NOW(), INTERVAL ".Poker_Variables::get("referral_mintime")." DAY)");
        
        $res = [];
        foreach($temp as $u){
            $res[] = new User($u['id']);
        }
        
        return $res;
    }
    
    
    public function getRealReferralsCount(){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT COUNT(*) FROM poker_users WHERE referral=".$this->id." AND registered<DATE_SUB(NOW(), INTERVAL ".Poker_Variables::get("referral_mintime")." DAY)");
        return $temp[0][0];
    }
    
    public function getRealAffiliateReferralsCount(){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT COUNT(*) FROM poker_users WHERE referral=".$this->id." AND registered<DATE_SUB(NOW(), INTERVAL ".Poker_Variables::get("referral_mintime")." DAY) AND rake>=".Poker_Variables::get("invitations_affiliate_rake"));
        return $temp[0][0];
    }
    
    public function getPointBalance(){
        return ($this->points - $this->points_dec);
    }
    
    public function isAffiliate(){
        if(AffiliateRequests::hasRequest($this)){
            $request = AffiliateRequests::getUserRequest($user);
            if ($request['status']==AffiliateRequests::STATUS_ACCEPTED){
                return TRUE;
            }
        }
        return FALSE;
    }
    
    public function countAffiliateEarning(){
        $refs = $this->getReferrals();
        foreach($refs as $u){
            if(!$this->level2){
                if($u->referral_level == 1){
                    $sum+=$u->rake * $this->comission;
                }else{
                    $sum+=$u->countAffiliatesRake()*$this->commission; #L2
                }
            }else{
                $sum+=($u->rake+$u->countAffiliatesRake())*$this->commission; #L2
            }
        }
        
        $this->resetIncome($sum);
        return $sum;
    }
    
    public function getAffiliateBalance(){
        $comission = $this->comission;
        $totalrake = $this->countAffiliateEarning();
        $totalfee = 0;
        $freerolls = 0; $this->points_dec*1;
        
        return $totalrake+ $comission*($totalfee - $freerolls);
    }
    
    public function getOwnerAffiliateName(){
        
        if(!$this->referral){
            return "[None]";
        }
        $ref = new User($this->referral);
        if($this->rereferral_level==2){
            return $ref->playername." [L2]";    
        }
        return $ref->playername;
    }
}