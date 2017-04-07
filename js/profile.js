A = {
    init: function(){
        //this.FrameRequest.init();
        this.Incomes.init();
        this.Transfer.init()
        this.AffiliateRequest.init();
        //_.Templates.add("tournamentsTemplate");
        //this.Tournaments.init();
        
        _.$("#details").click(function(e){
            _.$("#details").display("none");
        })
         _.$("#hand-history").click(function(e){
            _.$("#hand-history").display("none");
        })

         _.$("#transfer-history").click(function(e){
            _.$("#transfer-history").display("none");
        })
        _.$("#details>*").click(function(e){
            e.stopPropagation();
        })
    }
    
    ,FrameRequest:{
        init: function(){
            _.$("#frameRequest").click(this.onClick)
        }
        
        ,onClick: function(){
            
            _.$(".frameRequest .status").HTML("<i class='info'>Sending request...</i>");
            _.postJSON("/profile/modules/frameRequest.php",{},function(data){
                _.$(".frameRequest .status").HTML("<i class='ok'>"+data+"</i>");
            },function(err){
                _.$(".frameRequest .status").HTML("<i class='error'>"+err+"</i>");
            },function(e){console.log(e)})
        }
    }
    
    ,AffiliateRequest:{
        init: function(){
            _.$("#affiliateRequest").click(this.onClick);
        }
        
        
        ,onClick: function(){
            _.$("p.affiliate.status").HTML("<i class='info'>Sending request...</i>");
            _.postJSON("/profile/modules/affiliateRequest.php",{},function(d){
                 _.$("p.affiliate.status").HTML("<i class='ok'>"+d+"</i>");
            },function(e){
                _.$("p.affiliate.status").HTML("<i class='error'>"+e+"</i>");
            },function(r){
                _.$("p.affiliate.status").HTML("<i class='error'>An unexpected error occured!</i>");
                console.error(r)
            })
        }
    }
    
    ,Incomes: {
        
        init: function(){
            _.$(".referralsLink").click(this.openReferrals)
            this.done = _.$(".referrals .refs tr[data-id]").length;
            this.ids=[];
            //_.$(".referrals .refs tr[data-id]").forEach(this.proceed)
            
            //this.load();
            //_.$("#totalrake").HTML("<i class='spinner_small'></i><span>Calculating..</span>");
            _.$(".referrals .refs .income a").click(A.Incomes.Details.onClick);
            
        }
        
        ,openReferrals: function(e){
            var id = _.$(this).data('id');
            
            _.$("#details").display("block");
            _.$("#details .wrap .container").HTML("<p class='spinner_big'></p>");
            
            _.postJSON("/profile/modules/referrals.php",{id:id},function(d){
               var table = _.new("table");
               table.appendHTML("<tbody></tbody>");
              
               var thead = _.new("thead").HTML("<td>Name</td><td>E-mail</td><td>Total rake</td>");
               table.appendHTML(thead[0].outerHTML);
               
               tbody = table.find("tbody");
               var sum = 0;
               for(var i in d){
                   tbody.appendHTML("<td>"+d[i].name+"</td><td>"+d[i].email+"</td><td>"+d[i].rake.rake+"</td>");
                   sum+=d[i].rake.rake*1;
               }
               
               tbody.appendHTML("<td colspan='2'>Total rake: </td><td class='result'>"+sum+"</td>");
                _.$("#details .wrap .container").HTML(_.$(table)[0].outerHTML);
            }, function(m){
                console.error(m);
            }, function(e){
                console.error(e);
            });
            
        }
        
        ,done: 0
        
        ,proceed: function(el){
            var id = el.data("id");
            var field = el.find(".income");
            
            //field.HTML("<i class='spinner_small'></i><span>Calculating..</span>");
            A.Incomes.ids.push(id);
            
        }
        
        ,load:function(){
            // _.postJSON("/profile/modules/calculateRake.php",{id:A.Incomes.ids.join(",")},function(d){
            //     for(var i in d){
            //          _.$(".referrals .refs tr[data-id='"+i+"'] .income").HTML(d[i]);
            //     }
            //     var sum = 0;
            //     for(var i in d){
            //         sum+= parseFloat(_.$(".referrals .refs tr[data-id='"+i+"'] .income .result").HTML());
            //     }
            //     _.$("#totalrake").HTML(Math.round(sum*100)/100);
                
            // },function(d){
            //     field.HTML("<p class='status'><i class='error'>"+d+"</i></p>")
            // },function(e){
            //     field.HTML("<p class='status'><i class='error'>Unexpected error happened while calculations!</i></p>")
            //     console.error(e);
            // })
        }
        
        ,Details: {
            onClick: function(e){
                
                e.preventDefault();
                _.$("#details").display("block");
                _.$("#details .wrap").HTML("<p class='spinner_big'></p>");
                var id = _.$(this).data("id");
                //alert(id);
                _.$("#details .wrap").get("/profile/modules/details.php",{id:id},A.Incomes.Details.onLoad)
            }
            
            ,onLoad: function(r){
                _.$("#details a.view").click(function(e){
                    e.preventDefault();
                    _.$(this).parent().find("div.hand").display("block");
                })
                
                _.$('#fees').display("none");
                _.$(".nav a.fees").click(function(e){
                    e.preventDefault();
                    _.$(".nav a").removeClass("active")
                    _.$(this).addClass("active");
                    _.$("#details table").display('none')
                    _.$("#fees").display("table");
                     _.$("#rakes").display('none')
                    
                })
                _.$(".nav a.rakes").click(function(e){
                    e.preventDefault();
                    _.$(".nav a").removeClass("active")
                    _.$(this).addClass("active");
                    _.$("#details table").display('none')
                    _.$("#rakes").display("table");
                     _.$("#rakes").display('none')
                    
                })
            }
            
        }
    }
    
    ,Transfer: {
        init: function(){
            _.Templates.add("player-option");
            _.$("#transferChips").submit(this.onSubmit);
            _.$("#transfer_player").keydown(this.onPrint);
             _.$("#transferAffiliate").submit(this.onTransferAffiliate);
        }
        
        ,onPrint: function(){
            _.postJSON("/profile/modules/getUserNames.php",{text: _.$(this).val},function(d){
                _.$("#players").fromTemplate("player-option",d);
            },function(e){
                console.error(e)
            }, function(r){
                console.error(r)
            });
        }
        
        ,onSubmit: function(e){
            e.preventDefault();
            _.postJSON("/profile/modules/transferChips.php",{player: _.$("#transfer_player").val, amount: _.$("#transfer_amount").val},
            function(d){
                _.$("#transfer-status").HTML("<i class='ok'>Transfer completed successfully! Your balance: "+d+"</i>");
                _.$(".accBalance").HTML(d);
            },function(e){
                _.$("#transfer-status").HTML("<i class='error'>"+e+"</i>");
            },function(r){
                _.$("#transfer-status").HTML("<i class='error'> An unexpected error occured!</i>");
                console.error(r);
            });
        }
        ,onTransferAffiliate: function(e){
            e.preventDefault();
            _.postJSON("/profile/modules/transferBalance.php",{amount: _.$("#affiliate_amount").val},
            function(d){
                _.$("#affiliate-transfer-status").HTML("<i class='ok'>Your request has been sent successfully! Please waiting admin approve</i>");
            },function(e){
                _.$("#affiliate-transfer-status").HTML("<i class='error'>"+e+"</i>");
            },function(r){
                _.$("#affiliate-transfer-status").HTML("<i class='error'> An unexpected error occured!</i>");
                console.error(r);
            });
        }
    }

}

_.core(function(){
    A.init();  
    pagination = function(id,page){
        _.$("#details .wrap").get("/profile/modules/details.php",{id:id,page:page},A.Incomes.Details.onLoad)
    }  
    openHanHistory = function(handId,date,name){
         _.$("#hand-history").display("block");
        _.$("#hand-history .wrap .container").HTML("<p class='spinner_big'></p>");
        
        _.$("#hand-history .wrap").get("/profile/modules/handHistory.php",{hand_id:handId,date:date,name:name},A.Incomes.Details.onLoad)
    }

    openTransferHistory = function(){
         _.$("#transfer-history").display("block");
        _.$("#transfer-history .wrap .container").HTML("<p class='spinner_big'></p>");
        
        _.$("#transfer-history .wrap").get("/profile/modules/transferBalanceHistory.php",A.Incomes.Details.onLoad)
    }
    viewTournamentResult = function(id){
        _.$("#hand-history").display("block");
        _.$("#hand-history .wrap .container").HTML("<p class='spinner_big'></p>");
        
        _.$("#hand-history .wrap").get("/profile/modules/handHistory.php",{hand_id:handId,date:date,name:name},A.Incomes.Details.onLoad)
    }  
})