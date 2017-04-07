<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Poker/Poker.php";
    
class Poker_Tickets{
    
    public static function getTickets(){
        $sql = new SQLConnection();
        $data = $sql->getArray("SELECT * FROM poker_tickets ORDER BY id DESC");
        return $data;
    }
    
    const ERROR_TICKET_EXISTS = 5;
    const ERROR_DB_ERROR = 13;
    const ERROR_NO_ERROR = 1;
    
    public static function createTicket($data){
        $sql = new SQLConnection;
        
        if(self::ticketExists($data['tournament'], $data['for'])){
            return self::ERROR_TICKET_EXISTS;
        }
        $q = "INSERT INTO poker_tickets VALUES (default, '{$data['tournament']}', '{$data['places']}', '{$data['for']}', NOW(), '')";
        $sql->query($q);
        
        #echo mysqli_error() ? $q  : "";
        
        return mysqli_error() ? self::ERROR_DB_ERROR : self::ERROR_NO_ERROR;
    }
    
    public static function getTournamentNames(){
        $sql = new SQLConnection();
        $data = $sql->getArray("SELECT name FROM poker_cache_tournaments");
        $res = array_map(function($e){
            return $e["name"];
        },$data);
        
        return $res;
    }
    
    public static function ticketExists($tournament, $for){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT id FROM poker_tickets WHERE tournament='$tournament' AND tournament_for='$for'");
        if(count($temp)){
            return true;
        }
        return false;
    }
    
    public static function removeTicket($id){
        $id = intval($id);
        $sql = new SQLConnection;
        $sql->query("DELETE FROM poker_tickets WHERE id=$id");
    }
    
    public static function isTicketTournament($name){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT id FROM poker_tickets WHERE tournament='$name'");
        if(count($temp)){
            return true;
        }
        return false;
    }
    
    public static function getTicketsOf($name){
        $sql = new SQLConnection;
        $temp = $sql->getArray("SELECT * FROM poker_tickets WHERE tournament='$name'");
        return $temp;
    }
}