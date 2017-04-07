var App = {
    
    init: function(){
        _.Templates.add("tournamentsTemplate")
        this.Tournaments.init(); 
        this.CashOut.init()
        this.History.init()
        this.Deposit.init();
        this.Forms.init();
        this.Partners.init()
    }
    
    ,Partners:{
        init: function(){
            _.$("[href='#partnership']").click(function(){
                _.$("#partnership").display("block");
            })
            _.$("#partnership").click(function(e){
                if(e.target == this) {
                    _.$(this).display("none");
                }
            })
              _.$("#partnership input, #partnership textarea").click(function(){
                    if(this.select){
                        this.select()
                    }
              })
            _.$("#partnership .copy").click(function(){
                
                document.getSelection().removeAllRanges();
                _.$(this).parent(2).find("input, textarea")[0].select()
                console.log( _.$(this).parent(2).find("input, textarea"));
                if(document.execCommand("copy")){
                    _.$("#partnership .copy").val = "  Copy  ";
                    _.$(this).val = "Copied!";
                }
            })
        }
    }
    
    ,Forms:{
        init: function(){
            
             _.$("#login").click(function(){
                _.$("#popup, #login_form").display("block");
            })
            
             _.$("#register").click(function(){
                _.$("#popup,#register_form").display("block")
            })
            
            _.$("#closeForm, .popup, #popup").click(function(){
                _.$("#popup, #popup>*, .popup").display("none")
            })
            
            _.$("#popup>*, .popup>*").click(function(e){
                e.stopPropagation();
            })
            
            _.$("#register_form").submit(function(e){
                e.preventDefault();
                var path = _.$(this).attr("action");
                
                
                _.$("#register_form .status").HTML("<i class='info'>Processing...</i>");
                _.new("div").post(path,{
                    playername: _.$("#register_form [name='playername']").val
                    ,email: _.$("#register_form [name='email']").val
                    ,password: _.$("#register_form [name='password']").val
                    ,confirmpassword: _.$(" #register_form [name='confirmpassword']").val
                    ,realname: _.$("#register_form [name='realname']").val
                    ,referral: _.$("#register_form [name='affiliatecode']").val
                    ,location: _.$("#register_form [name='location']").val
                    ,sex: _.$("#register_form [name='sex']:checked").val
                    ,referral_level: _.$("#register_form [name='level']").val
                },function(r){
                    var d;
                    try{
                        d = JSON.parse(r)
                    }catch(e){
                        console.error(r);
                        return;
                    }
                    if(d.status.toUpperCase()=="ERROR"){
                        _.$("#register_form .status").HTML("<i class='error'>"+d.message+"</i>");
                    }
                    
                    if(d.status.toLowerCase()=="ok"){
                        _.$("#register_form .status").HTML("<i class='ok'>"+d.data+"</i>");
                        setTimeout(function(){
                            location.assign("/profile");
                        },1500);
                    }
                    
                })
            })
            
            _.$("#login_form").submit(function(e){
                
                e.preventDefault();
                var path = _.$(this).attr("action");
                
                _.$("#login_form .status").HTML("<i class='info'>Processing...</i>");
                
                _.postJSON(path,{
                    playername: _.$("#login_form #playername").val
                    ,password: _.$("#login_form #password").val
                },function(data){
                    _.$("#login_form .status").HTML("<i class='ok'>"+data+"</i>");
                    setTimeout(function(){
                        location.href="/profile";
                    },1000)
                }, function(message){
                    _.$("#login_form .status").HTML("<i class='error'>"+message+"</i>");
                }, function(response){
                     _.$("#login_form .status").HTML("<i class='error'> An error occured while executing your response! </i>");
                    console.error(response);
                })
            })
        }
    }
    ,Tournaments:{
        init: function(){
            
            _.$("#tournamentsPart").HTML("<tr><td colspan='5'><p class='spinner_small'></p>Retrieving tournament list...</td></tr>");
            _.$("[href='#freeroll']").click(this.onOpen);
            _.$("#freeroll").click(function(e){
                this.style.display="none";
            })
            _.$("#freeroll>*").click(function(e){
                e.stopPropagation();
            })
            this.load();
            
        }
        
        ,onOpen: function(e){
            e.stopPropagation();
            e.preventDefault();
            _.$("#freeroll").display("block");
        }
        
        ,load: function(){
            _.postJSON("/views/tournamentList.php",{},function(d){
                _.$("#tournamentsPart").fromTemplate("tournamentsTemplate", d);
                _.$("#tournamentsPart td[data-accepted]").forEach(function(e){
                    if(e.data("accepted")==1){
                        e.find(".unregister, .unauthorized, .nenough").remove();
                    }
                    if(e.data("accepted")==0){
                        e.find(".register, .unauthorized, .nenough").remove()
                    }
                    if(e.data("accepted")==-1){
                        e.find(".register, .unregister, .nenough").remove();
                    }
                    if(e.data("accepted")==-2){
                        e.find(".register, .unregister, .unauthorized").remove()
                    }
                })
                App.Tournaments.handle();
            }, function(e){
                console.error(e);
            }, function(r){
                console.error(r);
            })
        }
        
        ,handle: function(){
            _.$("#tournamentsPart input.register").click(this.onRegister);
            _.$("#tournamentsPart input.unregister").click(this.onUnregister);
        }
        
        ,onRegister: function(){
            var name = _.$(this).parent(3)[0].children[0].innerText.trim();
            var p = this.parentNode;
            this.outerHTML="<p class='spinner_small'></p>";
            _.postJSON("/views/tournamentRegister.php",{tournament: name},function(d){
                   
                   //_.$(p).HTML(d);
                    setTimeout(function(){
                        App.Tournaments.init()    
                    },1000)
                   console.log(d);
            },function(e){
                alert(e);
            },function(r){
                console.error(r);
            })
        }
        
        ,onUnregister: function(){
            var name = _.$(this).parent(3)[0].children[0].innerText.trim();
            var p = this.parentNode;
            this.outerHTML="<p class='spinner_small'></p>";
            console.log({tournament: name});
            _.postJSON("/views/tournamentUnregister.php",{tournament: name},function(d){
                   
                   //_.$(p).HTML(d);
                    setTimeout(function(){
                        App.Tournaments.init()    
                    },1000)
                   console.log(d);
            },function(e){
                alert(e);
            },function(r){
                console.error(r);
            })
        }
    }
    
    ,Deposit:{
        init: function(){

            _.$("a#depositLink").click(function(e){
                e.preventDefault();
                _.$("#requestDeposit").display("block");
                
            })
            _.$("#deposit").click(this.onClick);
        }
        
        ,onClick: function(){
            
            var amo = _.$("#depositAmount").val
            _.$("#depositStatus").HTML("<i class='info'>Sending request...</i>");
            _.postJSON("/profile/modules/deposit.php",{amount: amo}, function(d){
                _.$("#depositStatus").HTML("<i class='ok'>Request sent successfully!</i>");
                _.$("#balanceAmount, #balanceAmountDep").HTML(d);
            }, function(e){
                _.$("#depositStatus").HTML("<i class='error'>"+e+"</i>");
            }, function(r){
                _.$("#depositStatus").HTML("<i class='error'>An unexpected error occured!</i>");
                console.error(r);
            })
        }
    }
    ,CashOut:{
        init: function(){
            
            
            _.$("a#cashinLink").click(function(e){
                e.preventDefault();
                _.$("#balance").display("block");
                
            })
            _.$("#cashin").click(this.onClick);
        }
        
        ,onClick: function(e){
            var sum = _.$("#chips").val;
            var method = _.$("#chips_method").val;
            
            _.$("#balanceStatus").HTML("<i class='info'>Proceeding...</i>");
            _.postJSON("/profile/modules/cashOut.php",{sum:sum, method: method}, function(d){
                _.$("#balanceStatus").HTML("<i class='ok'>Request sent successfully!</i>");
                _.$("#balanceAmount, #balanceAmountDep").HTML(d);
            }, function(e){
                _.$("#balanceStatus").HTML("<i class='error'>"+e+"</i>")
            }, function(r){
                _.$("#balanceStatus").HTML("<i class='error'>An unexpected error occured!</i>")
                console.error(r);
            })
        }
    }
    ,History:{
        init: function(){
            _.Templates.add("transferTemplate");
            _.$("a#historyLink").click(function(e){
                e.preventDefault();
                _.$("#transfersHistory").display("block");
                var user =  _.$("a#historyLink").attr('data-name');
                App.History.load(user);
                
            })
        },
        load: function(user){
            _.postJSON("/admin/modules/transferHistory.php",{user: user}, function(d){
                _.$("#transfersHistory .spinner_big").display("none");
                _.$("#transfersHistory #historyIncome tbody").fromTemplate("transferTemplate", d.income);
                _.$("#transfersHistory #historyOutcome tbody").fromTemplate("transferTemplate", d.outcome);
                
                _.$("#transfersHistory #historyIncome").display("table");
                
                 _.$("#transfersHistory nav a").click(function(e){
                     e.preventDefault();
                    _.$("#transfersHistory table").display("none");
                    _.$("#transfersHistory nav a").removeClass("active");
                    _.$(this).addClass("active");
                })
                
                _.$("#outcomesTab").click(function(e){
                   _.$("#transfersHistory #historyOutcome").display("table");
                })
                
                _.$("#incomesTab").click(function(e){
                    _.$("#transfersHistory #historyIncome").display("table");
                })
               
            }, function(e){
                console.error(e)
            }, function(r){
                console.error(r)
            })
        }
        
    }
}

_.core(function(){
    App.init();
})

