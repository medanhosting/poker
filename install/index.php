<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/system/System.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/core/lib/utils/Utils.php";
    
    $sql = new SQLConnection();
    
    #Users table
    $sql->query("DROP TABLE IF EXISTS poker_users");
    $sql->query("CREATE TABLE poker_users(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,name VARCHAR(1000)
        ,balance FLOAT DEFAULT 0
        ,points FLOAT DEFAULT 0
        ,points_dec FLOAT DEFAULT 0
        ,tournaments_fee FLOAT DEFAULT 0
        ,chips FLOAT
        ,referral_level INT
        ,referral INT
        ,email VARCHAR(200)
        ,password VARCHAR(40)
        ,realname VARCHAR(100)
        ,location VARCHAR(1000)
        ,gender INT
        ,api_id INT
        ,registered DATETIME
        ,rake FLOAT
        ,income FLOAT DEFAULT 0
        ,income_paid FLOAT DEFAULT 0
        ,rake_parsed DATETIME
        ,totalrake varchar(2000) default '[{\"rake\":\"0\", \"date\":\"2016-10-10 00:00:00\"}]'
        ,comission FLOAT default 0.01
        ,level2_comission FLOAT default 0.1
        ,level2 INT default 0
        ,ssid VARCHAR(60)
        
    )");
    
    $sql->query("drop table if exists poker_frame_requests");
    $sql->query("create table poker_frame_requests(
         id int not null auto_increment primary key
        ,user int
        ,created datetime
        ,status INT default 1
        ,data text
        )");
       
    $sql->query("DROP TABLE IF EXISTS poker_cache_handhistory"); 
    $sql->query("create table poker_cache_handhistory(
             id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            ,name VARCHAR(500)
            ,`date` DATETIME
            ,data MEDIUMTEXT
            ,grabbed DATETIME
            ,type INT
            )");
            
       
    $sql->query("DROP TABLE IF EXISTS poker_cache_hands");     
    $sql->query("create table poker_cache_hands(
         hand INT NOT NULL PRImARY KEY
        ,handtitle VARCHAR(1000)
        ,statstitle VARCHAR(3000)
        ,stats TEXT
        ,history MEDIUMTEXT
        ,handnumber VARCHAR(100)
        ,`date` DATETIME
        ,fileName VARCHAR(1000)
        ,fileDate DATETIME
        )");
        
    
    $sql->query("DROP TABLE IF EXISTS poker_cache_ringgames");
    $sql->query("create table poker_cache_ringgames(
         id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,name VARCHAR(1000)
        ,status VARCHAR(1000)
        ,description TEXT
        ,auto VARCHAR(10)
        ,game VARCHAR(1000)
        ,pw VARCHAR(1000)
        ,private VARCHAR(10)
        ,permplay TEXT
        ,permobserve TEXT
        ,permplayerchat TEXT
        ,permobserverchat TEXT
        ,suspendchatallin VARCHAR(10)
        ,seats INT
        ,smallestchip FLOAT
        ,buyinmin float
        ,buyinmax float
        ,buyindef float
        ,rake float
        ,rakeevery float
        ,rakemax float
        ,turnclock float
        ,timebank float
        ,bankreset float
        ,disprotect VARCHAR(10)
        ,smallblind float
        ,bigblind float
        ,dupeips VARCHAR(10)
        ,ratholeminutes float
        ,sitoutminutes float
        ,sitoutrelaxed VARCHAR(10)
        
        )");
        
        
    $sql->query("DROP TABLE IF EXISTS poker_cache_tournaments");
    $sql->query("create table poker_cache_tournaments(
         id int not null primary key auto_increment
        ,point_fee FLOAT DEFAULT 0
        ,restart_time FLOAT DEFAULT 0
        ,point_enabled INT DEFAULT 0
        ,name VARCHAR(1000)
        ,status VARCHAR(1000)
        , description TEXT
        ,auto VARCHAR(100)
        ,game VARCHAR(1000)
        ,shootout VARCHAR(100)
        ,pw VARCHAR(1000)
        ,private VARCHAR(100)
        ,permregister TEXT
        ,permunregister TEXT
        ,permobserve TEXT
        ,permplayerchat TEXT
        ,permobserverchat TEXT
        ,suspendchatallin TEXT
        ,tables INT
        ,seats INT
        ,startfull VARCHAR(100)
        ,startmin INT
        ,startcode INT
        ,starttime DATETIME
        ,regminutes INT
        ,lateregminutes INT
        ,minplayers INT
        ,recurminutes INT
        ,noshowminutes INT
        ,buyin FLOAT
        ,entryfee FLOAT
        ,prizebonus FLOAT
        ,multiplybonus FLOAT
        ,chips FLOAT
        ,addonchips FLOAT
        ,turnclock FLOAT
        ,timebank FLOAT
        ,bankreset FLOAT
        ,disprotect VARCHAR(100)
        ,level INT
        ,rebuylevels INT
        ,threshold FLOAT
        ,maxrebuys INT
        ,rebuycost FLOAT
        ,rebuyfee FLOAT
        ,breaktime FLOAT
        ,breaklevels FLOAT
        ,stoponchop VARCHAR(100)
        ,blinds MEDIUMTEXT
        ,payout TEXT
        ,unreglogout VARCHAR(100)
        )");
        
    $sql->query("DROP TABLE IF EXISTS poker_cache_tournament_results");
    $sql->query("create table poker_cache_tournament_results(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,name VARCHAR(1000)
        ,date DATETIME
        ,tournament VARCHAR(1000)
        ,number INT
        ,buyin VARCHAR(1000)
        ,prizebonus VARCHAR(1000)
        ,multiplybonus VARCHAR(100)
        ,entrants INT
        ,late INT
        ,removed INT
        ,rebuys INT
        ,addons INT
        ,rebuycost VARCHAR(1000)
        ,netbonus FLOAT
        ,stoponchop VARCHAR(100)
        ,start DATETIME
        ,stop DATETIME
        ,places TEXT
        
        )");
        
        
    $sql->query("DROP TABLE IF EXISTS poker_variables");
    $sql->query("create table poker_variables(
         id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,name VARCHAR(3000)
        ,value VARCHAR(1000)
        ,changed DATETIME
        ,data MEDIUMTEXT
        
    )");
    $sql->query("INSERT INTO poker_variables VALUES 
        (default, 'points_invitation', 50, default, '')
        ,(default, 'referral_mintime', 10, default, '')
        ,(default, 'invitations_affiliate', 3, default, '')
        ,(default, 'points_formula_rake', 14, default, '')
        ,(default, 'invitations_affiliate_rake', 150, default, '')
        ,(default, 'second_level_commission', 0.095, default, '')
        ,(default, 'url_game_frame', 'http://71.19.252.239:81', default, '')
        ,(default, 'domain_referrals', 'http://poker.retarcorp.com/', default, '')
        ");
    
    $sql->query("DROP TABLE poker_tournament_registrations");
    $sql->query("create table poker_tournament_registrations(
         id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,user VARCHAR(1000)
        ,tournament VARCHAR(1000)
        ,registered DATETIME
        ,data TEXT
        )");
        
    $sql->query("DROP TABLE IF EXISTS poker_tickets");
    $sql->query("create table poker_tickets(
         id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,tournament VARCHAR(1000)
        ,places INT
        ,tournament_for VARCHAR(1000)
        ,created DATETIME
        ,data TEXT
        )");
        
    $sql->query("DROP TABLE IF EXISTS poker_chips_transactions");
    $sql->query("create table poker_chips_transactions(
         id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,user VARCHAR(1000)
        ,target VARCHAR(1000)
        ,amount FLOAT
        ,balance FLOAT
        ,date DATETIME
        ,data TEXT
        
    )");
    
    $sql->query("drop table if exists poker_cashout_transactions");
    $sql->query("create table poker_cashout_transactions(
         id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,user VARCHAR(1000)
        ,amount FLOAT
        ,date DATETIME
        ,method VARCHAR(1000)
        ,status INT
        ,data TEXT
    )");    
    
    $sql->query("DROP TABLE IF EXISTS poker_deposit_transactions");
    $sql->query("CREATE TABLE poker_deposit_transactions(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
        ,user VARCHAR(1000)
        ,amount FLOAT
        ,date DATETIME
        ,status INT
        ,data TEXT
    )");