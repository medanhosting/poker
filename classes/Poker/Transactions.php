<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";

class Poker_Transactions{
    
    /**
     * <User> $user, <User> $target, float $amount
     */
    public static function chipsTransaction($user, $target, $amount, $affiliate = false){
        $sql = new SQLConnection();
        if($user==NULL){
            if($affiliate){
                $sql->query("INSERT INTO poker_chips_transactions VALUES (default,'[[Referrals]]', '{$target->playername}', $amount, {$target->balance}, NOW(), 'Got chips from affiliate program')");
            }else{
                $sql->query("INSERT INTO poker_chips_transactions VALUES (default,'', '{$target->playername}', $amount, {$target->balance}, NOW(), 'Transferred by admin')");
            }
        }else{
            $sql->query("INSERT INTO poker_chips_transactions VALUES (default,'{$user->playername}', '{$target->playername}', $amount, {$user->balance}, NOW(), '')");
        }
        return mysqli_error() ? false : true;
    }
    
    public static function getChipsTransactions(){
        $sql = new SQLConnection();
        return $sql->getArray("SELECT * FROM poker_chips_transactions ORDER BY date DESC");
    }
    
    public static $methods = [
            array("method"=>"Visa")
        ];
    
    const CASHOUT_PENDING = 1;
    const CASHOUT_ACCEPTED = 2;
    const CASHOUT_DECLINED = 3;
    
    public static function cashOut($user, $method, $amount){
        $sql = new SQLConnection();
        if(!$user){
           
            return FALSE;
        }
        if($user->balance < $amount){
            
            return FALSE;
        }
        $sql->query("INSERT INTO poker_cashout_transactions VALUES (default, '{$user->playername}', $amount, NOW(), '$method', ".self::CASHOUT_PENDING.", '')");
        
        
        if(mysqli_error()){
            return FALSE;
        }
        $user->balance -=$amount;
        Poker_Accounts::DecBalance(["Player"=>$user->playername, "Amount"=>$amount]);
        $user->submitChanges();
        return $user->balance;
        
    }
    
    public static function cashOutTransactions(){
        $sql = new SQLConnection();
        return $sql->getArray("SELECT * FROM poker_cashout_transactions ORDER BY status ASC, date DESC");
    }
    
    public static function cashOutTransactionStatus($id, $status){
        $sql = new SQLConnection();
        if($status == self::CASHOUT_DECLINED){
            $tmp = $sql->getArray("SELECT * FROM poker_cashout_transactions WHERE id=$id");
            $user = $tmp[0]['user'];
            $user = UserMachine::getUserByPlayerName($user);
            $user->balance += $tmp[0]['amount']*1;
            Poker_Accounts::IncBalance(["Player"=>$user->playername, "Amount"=>$tmp[0]['amount']*1]);
            $user->submitChanges();
        }
        $sql->query("UPDATE poker_cashout_transactions SET status=$status WHERE id=$id");
        echo mysqli_error();
    }
    
    public static function cashOutTransactionAmount($id, $amount){
        $sql = new SQLConnection;
        $amount = $amount*1;
        $sql->query("UPDATE poker_cashout_transactions SET amount=$amount WHERE id=$id AND status=".self::CASHOUT_PENDING);
        return (mysqli_error() ? FALSE : TRUE);
    }
    
    
    const DEPOSIT_PENDING = 1;
    const DEPOSIT_ACCEPTED = 2;
    const DEPOSIT_DECLINED = 3;
    
    public static function depositTransaction($user, $amount){
        $sql = new SQLConnection();
        if(!$user){
            return FALSE;
        }
        $sql->query("INSERT INTO poker_deposit_transactions VALUES (default, '{$user->playername}', $amount, NOW(), ".self::DEPOSIT_PENDING.",  '')");
        if(mysqli_error()){
            return FALSE;
        }
        return TRUE;
    }
    
    public static function getDepositTransactions(){
        $sql = new SQLConnection();
        return $sql->getArray("SELECT * FROM poker_deposit_transactions ORDER BY status ASC, date DESC");
    }
    
    public static function depositTransactionStatus($id, $status){
        $sql = new SQLConnection();
        if($status == self::DEPOSIT_ACCEPTED){
            $tmp = $sql->getArray("SELECT * FROM poker_deposit_transactions WHERE id=$id");
            $user = $tmp[0]['user'];
            $user = UserMachine::getUserByPlayerName($user);
            $user->balance += $tmp[0]['amount']*1;
            Poker_Accounts::IncBalance(["Player"=>$user->playername, "Amount"=>$tmp[0]['amount']*1]);
            $user->submitChanges();
        }
        $sql->query("UPDATE poker_deposit_transactions SET status=$status WHERE id=$id");
        echo mysqli_error();
    }
    
    public static function depositTransactionAmount($id, $amount){
        $sql = new SQLConnection;
        $amount = $amount*1;
        $sql->query("UPDATE poker_deposit_transactions SET amount=$amount WHERE id=$id AND status=".self::DEPOSIT_PENDING);
        return (mysqli_error() ? FALSE : TRUE);
    }
    
    public static function IOTransactionList($user){
        $sql = new SQLConnection();
        $name = $user->playername;
        
        $income = $sql->getArray("
        
            SELECT id, '[[Deposit]]' AS subject, amount, date 
                FROM poker_deposit_transactions 
                WHERE user='$name' AND status='".self::DEPOSIT_ACCEPTED."' 
            UNION
            SELECT id, '[[Admin]]' as subject, amount, date 
                FROM poker_chips_transactions 
                WHERE target='$name' AND amount>0 AND user!='[[Referrals]]' 
            UNION
            SELECT id, user as subject, amount, date 
                FROM poker_chips_transactions 
                WHERE target='$name' AND user!=''
            ORDER BY date DESC 
        "); 
        
        
        $outcome = $sql->getArray("
        SELECT id, target as subject, amount, date 
            FROM poker_chips_transactions 
            WHERE user='$name'
        UNION
        SELECT id, '[[Admin]]' as subject, -amount, date 
            FROM poker_chips_transactions 
            WHERE target='$name' AND user='' AND amount<0
        UNION
        SELECT id, '[[CashOut]]' as subject, amount, date 
            FROM poker_cashout_transactions 
            WHERE status!='".self::CASHOUT_DECLINED."' AND user='$name'
        ORDER BY date DESC");
        
        
        return [
                "income"=>$income
                ,"outcome"=>$outcome
            ];
    }
    

}