<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
class AffiliateRequests{
    
    const STATUS_WAITING = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_DECLINED = 3;
    
    public static function hasRequest($user){
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT * FROM poker_affiliate_requests WHERE user ='".$user->playername."'");
        return count($temp) ? TRUE : FALSE ;
    }
    
    public static function request($user){
        if (self::hasRequest($user)){
            return FALSE;
        }
        $sql = new SQLConnection();
        $sql->query("INSERT INTO poker_affiliate_requests VALUES (default, NOW(), '0000-00-00 00:00:00', '".$user->playername."',".self::STATUS_WAITING.",'')");
        if(!mysqli_error()){
            return TRUE;
        }
        return false;
    }
    
    public static function _list(){
        $sql = new SQLConnection();
        return $sql->getArray("SELECT * FROM poker_affiliate_requests ORDER BY  status , created DESC");
    }
    
    public static function getUserRequest($user){
        $sql = new SQLConnection();
        $temp = $sql->getArray("SELECT * FROM poker_affiliate_requests WHERE user='{$user->playername}'");
        if(!count($temp)){
            return null;
        }
        return $temp[0];
    }
    
    public static function accept($id){
        $sql = new SQLConnection();
        $id = intval($id);
        $sql->query("UPDATE poker_affiliate_requests SET status =".self::STATUS_ACCEPTED." , answered=NOW() WHERE id=$id");
        #echo "UPDATE poker_affiliate_requests SET status =".self::STATUS_ACCEPTED.", answered='".date("Y-m-d H:i:s")."' WHERE id=$id";
        if (mysqli_error()) return false;
        return true;
    }
    
    public static function decline($id){
        $sql = new SQLConnection();
        $id = intval($id);
        $sql->query("UPDATE poker_affiliate_requests SET status =".self::STATUS_DECLINED.", answered='".date("Y-m-d H:i:s")."' WHERE id=$id");
        if (mysqli_error()) return false;
        return true;
    }
    
    public static function getStatus($id){
        $sql = new SQLConnection();
        $id = intval($id);
        $temp = $sql->getArray("SELECT status FROM poker_affiliate_requests WHERE id=$id");
        if(!count($temp)){
            return null;
        }
        return $temp[0]['status'];
    }

}