<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Classes.php";
    
    $id = $_POST['id'];
    $user = new User($id);
    
    $tournaments = Poker_Cache::getTournamentsOf($user);
    $sum = 0;
    $sumFee = 0;
    $result = [];
    foreach($tournaments as $i=>$v){
        
        // if($v['buyin']!="0+0"){
        //     continue;
        // }
        
        $v['date'] = date("Y-m-d",strtotime($tournaments[$i]["date"]));
        $fees = Poker_Calculations::getTournamentFeeArray($v);
        $freerolls = Poker_Calculations::getFreerollArray($v);
        $fee = $fees[$user->playername];
        $freeroll = $freerolls[$user->playername];
        $sum+=$fee*1;
        $sumFee+=$freeroll*1;
        $v['fee'] = $fee*1;#$fees[$user->playername]*1;
        $v['feerolls_fee'] = $freeroll;
        $result[]=$v;
    }
    echo json_encode(array("status"=>"OK", "data"=>["data"=>$result,"sum"=>$sum,'sumFee'=>$sumFee,"name"=>$user->playername]));