A = {
    
    init: function(){
        A.Data.Routers = {
            "frameRequests": {
                path: "/admin/modules/frameRequests.php"
                ,handler: A.Actions.FrameRequests
            }
            ,"rakeHistory": {
                path: "/admin/modules/rakeHistory.php"
                ,handler: A.Actions.RakeHistory
            }
            
            ,"affiliates":{
                path: "/admin/modules/manageAffiliates.php"
                ,handler: A.Actions.Affiliates
            }
            
            ,"affiliateRequests":{
                path: "/admin/modules/affiliateRequests.php"
                ,handler: A.Actions.AffiliateRequests
            }
            ,"affiliateBalanceRequests":{
                path: "/admin/modules/affiliateBalanceRequests.php"
                ,handler: A.Actions.AffiliateBalanceRequests
            }
            ,"tournamentFees":{
                path: "/admin/modules/tournamentFees.php"
                ,handler: A.Actions.Tournaments
            }
            ,"buyinTournaments":{
                path: "/admin/modules/zeroBuyIn.php"
                ,handler: null
            }
            ,"variables":{
                path: "/admin/modules/variables.php"
                ,handler: A.Actions.Variables
            }
            ,"currenttournaments":{
                path: "/admin/modules/currentTournaments.php"
                ,handler: A.Actions.CurrentTournaments
            }
            ,"ticket":{
                path:"/admin/modules/ticket.php"
                ,handler: A.Actions.TicketTournaments
            }
            ,"cashout":{
                path: "/admin/modules/cashout.php"
                ,handler: A.Actions.Cashout
            }
            ,"deposits":{
                path: "/admin/modules/deposits.php"
                ,handler: A.Actions.Deposits
            }
        };
        _.$(window).hashchange(A.Actions.onHashChange);
        A.Actions.onHashChange();
    }
    
    ,Data: {
        Routers:{}
    }
    
    ,Actions:{
        
        onHashChange: function(){
            var hash = window.location.hash;
            for (var i in A.Data.Routers){
                if("#"+i == hash){
                    _.$("a[href^='#']").removeClass("active");
                    _.$("a[href='#"+i+"']").addClass("active");
                    A.Actions.loadFragment(A.Data.Routers[i]);
                }
            }
        }
        
        ,loadFragment: function(hash){
            _.$("#content").HTML("<p class='spinner_big'></p>").post(hash.path,{},function(r){
                hash.handler.init(r);
            });
            
        }
        
        ,Variables:{
            init: function(){
                _.$("#variables input").change(this.onChange)
            }
            
            ,interval: 0
            
            ,onChange: function(e){
                var t =  _.$(this);
                
                var id = t[0].id;
                var value = t.val;
                
                clearTimeout(A.Actions.Variables.interval);
                A.Actions.Variables.interval = setTimeout(function(){
                    t[0].disabled = true;
                    _.postJSON("/admin/modules/changeVar.php",{variable: id, value: value },function(d){
                        t[0].disabled = false;
                    }, function(e){
                        console.error(e);
                    }, function(r){
                        console.error(r);
                    })
                },1000)
                
                
            }
        }
        
        ,FrameRequests:{
            init: function(){
                _.$(".frameRequests td .accept").click(this.onAccept);
                _.$(".frameRequests td .decline").click(this.onDecline)
            }
            
            ,onAccept: function(e){
                var id = _.$(this).parent(2).data("id");
                A.Actions.FrameRequests.change({id: id, status: "accepted"})
            }
            
            ,onDecline: function(e){
                var id = _.$(this).parent(2).data("id");
                A.Actions.FrameRequests.change({id: id, status: "declined"})
            }
            
            ,change: function(o){
                var target = _.$(".frameRequests tr[data-id='"+o.id+"'] td:last-child");
                _.postJSON("/admin/modules/frameRequestStatus.php",o, function(d){
                    target.HTML(d);
                }, function(m){
                    target.HTML("<p class='status'><i class='error'>"+m+"</i></p>");
                }, function(r){
                    target.HTML("<p class='status'><i class='error'>An error occured while changing status!</i></p>");
                    console.error(r);
                })
            }
        }
        
        ,AffiliateRequests:{
            init: function(){
                _.$(".affiliateRequests td .accept").click(this.onAccept);
                _.$(".affiliateRequests td .decline").click(this.onDecline)
            }
            
            ,onAccept: function(e){
                var id = _.$(this).parent(2).data("id");
                A.Actions.AffiliateRequests.change({id: id, status: "accepted"})
            }
            
            ,onDecline: function(e){
                var id = _.$(this).parent(2).data("id");
                A.Actions.AffiliateRequests.change({id: id, status: "declined"})
            }
            
            ,change: function(o){
                var target = _.$(".affiliateRequests tr[data-id='"+o.id+"'] td:last-child");
                _.postJSON("/admin/modules/affiliateRequestStatus.php",o, function(d){
                    target.HTML(d);
                }, function(m){
                    target.HTML("<p class='status'><i class='error'>"+m+"</i></p>");
                }, function(r){
                    target.HTML("<p class='status'><i class='error'>An error occured while changing status!</i></p>");
                    console.error(r);
                })
            }
        }

        ,AffiliateBalanceRequests:{
            init: function(){
                _.$(".affiliateRequests td .accept").click(this.onAccept);
                _.$(".affiliateRequests td .decline").click(this.onDecline)
            }
            
            ,onAccept: function(e){
                var id = _.$(this).parent(2).data("id");
                A.Actions.AffiliateBalanceRequests.change({id: id, status: "accepted"})
            }
            
            ,onDecline: function(e){
                var id = _.$(this).parent(2).data("id");
                A.Actions.AffiliateBalanceRequests.change({id: id, status: "declined"})
            }
            
            ,change: function(o){
                var target = _.$(".affiliateRequests tr[data-id='"+o.id+"'] td:last-child");
                _.postJSON("/admin/modules/affiliateBalanceRequestStatus.php",o, function(d){
                    target.HTML(d);
                }, function(m){
                    target.HTML("<p class='status'><i class='error'>"+m+"</i></p>");
                }, function(r){
                    target.HTML("<p class='status'><i class='error'>An error occured while changing status!</i></p>");
                    console.error(r);
                })
            }
        }
        
        ,RakeHistory:{
            init: function(){
        
                _.$("#rakeHistoryHand").click(function(){_.$(this).display("none")});
                _.$("#rakeHistoryHand>*").click(function(e){e.stopPropagation()});
                
                _.$(".rakeHistory li").click(this.openHand);
            }
            
            ,openHand: function(e){
                var id = _.$(this).data("hand");
                
                _.$("#rakeHistoryHand").display("block").find(".wrap").HTML("<p class='spinner_big'></p>");
                _.postJSON("/admin/modules/getHand.php",{hand: id},function(d){
                    var data = JSON.parse(d.history);
                    var s = "";
                    for(var i in data){
                        
                        s+=(i!=0) ? "<p>"+data[i]+"</p>" : "<h3> "+data[i]+"</h3>";
                    }
                    _.$("#rakeHistoryHand .wrap").HTML(s);
                },function(m){
                    _.$("#rakeHistoryHand .wrap").HTML("<p class='status'><i class='error'>"+m+"</i> </p>");
                },function(e){
                    console.error(e);
                    _.$("#rakeHistoryHand .wrap").HTML("<p class='status'><i class='error'>An unexpected error occured. Please, try again later.</i> </p>");
                })
            }
        }
        
        ,Affiliates:{
            
            init: function(r){
                this.users = _.$("#affiliates").data("amount")*1;
                _.$(".affiliatePopup").click(function(e){
                    _.$(this).display("none");
                })
                _.$(".affiliatePopup>*").click(function(e){
                    e.stopPropagation();
                })
                _.E.name="";
                this.Pagination.init();
                
                this.Search.init();
            
            }
            
            ,Search:{
                init: function(){
                    _.$("#searchLine").keyup(this.onPrint);
                }
                
                ,onPrint: function(){
                    var s = _.$(this).val;
                    if(s.trim().length>2){
                        _.E.name = s.trim();
                       
                    }else{
                        _.E.name = "";
                    }
                    A.Actions.Affiliates.Pagination.init();
                }
            }
            ,Details:{
                init: function(){
                    _.$("#affiliates .details").click(this.onOpen)
                    if (!_.E.name) {
                        _.Templates.add("affiliateDetailTemplate");
                    }
                }
                
                ,onOpen: function(){
                    var id = _.$(this).data("id");
                    _.$("#affiliateDetails").display("block");
                    _.postJSON("/admin/modules/affiliateDetails.php",{id:id}, function(d){
                        console.log(d['data']);
                        _.$("#affiliateDetails table tbody").fromTemplate("affiliateDetailTemplate",d['data']);
                        _.$("#affiliateDetails table tbody").appendHTML("<tr><td colspan='2'>Total:</td><td class='number'></td><td class='number'>"+d['sumFee']+"</td><td class='number'>"+d['sum']+"</td></tr>");
                        _.$("#affiliateName").HTML(d['name']);
                    },function(m){
                        console.error(m);
                    },function(r){
                        console.error(r)
                    })
                }
            }
            ,Pagination: {
                init: function(){
                    this.createNavigation();
                    this.openPage(1);
                    
                    if (!_.E.name) {
                        _.Templates.add("user");
                    }
                }
                ,createNavigation: function(){
                    var pages = Math.ceil(A.Actions.Affiliates.users/this.step);
                    this.pages = pages;
                    
                     _.$(".affiliates.pages").HTML("");
                    for(var i = 1; i<=pages; i++){
                         _.$(".affiliates.pages").appendHTML("<li><a href='#' data-n='"+i+"'>"+i+"</a></li>");
                    }
                    _.$(".affiliates.pages a").click(this.onClick);
                }
                ,onClick: function(e){
                    e.preventDefault();
                    var page = _.$(this).data("n");
                    A.Actions.Affiliates.Pagination.openPage(page*1);
                }
                ,step: 20
                ,openPage: function(i){
                    _.postJSON("/admin/modules/users.php",{offset: this.step*(i-1), step:this.step, name: _.E.name},
                    function(d){
                        
                        _.$("#affiliates tbody").fromTemplate("user", d);
                        A.Actions.Affiliates.Settings.init();
                        A.Actions.Affiliates.Pagination.setActive(i);
                        A.Actions.Affiliates.Details.init();
                        A.Actions.Affiliates.Message.init();
                    },function(m){
                        console.error(e);
                    },function(e){
                        console.error(e);
                    });
                }
                
                ,setActive: function(i){
                    _.$(".affiliates.pages li a").removeClass("active");
                    _.$(".affiliates.pages li a[data-n='"+i+"']").addClass("active");
                    
                }
            }
            
            ,Message: {
                init: function(){
                    _.$("#affiliates .message").click(this.onClick);
                    _.$("#affiliateMessage form").submit(this.onSend)
                }
                
                ,onClick: function(e){
                    var id = _.$(this).data("id");
                    _.E.affiliate = id;
                    _.$("#affiliateMessage").display("block")
                }
                
                ,onSend: function(e){
                    e.preventDefault();
                    var s = {
                        id: _.E.affiliate
                        ,message:  _.$("#affiliatemsg").val
                    }
                    _.$("#messageStatus").HTML("<i class='info'>Sending message...</i>");
                    _.postJSON("/admin/modules/sendMessage.php",s,function(d){
                        _.$("#messageStatus").HTML("<i class='ok'>"+d+"</i>");
                    }, function(e){
                        _.$("#messageStatus").HTML("<i class='error'>"+e+"</i>");
                    }, function(r){
                        _.$("#messageStatus").HTML("<i class='error'>An unexpected error occured!</i>");
                        console.error(r);
                    })
                }
            }
            
            ,Settings: {
                
                init: function(){
                    _.$("#affiliates input.settings").click(this.onClick);
                     if (!_.E.name) {
                         _.Templates.add("referralTemplate");
                        _.Templates.add("referralAddTemplate");
                     }
                }
                
                ,onClick: function(){
                    _.E.affiliate = _.$(this).data("id");
                    _.$("#affiliateSettings").display("block");
                    _.$("#addReferralForm").display("none");
                    
                    _.postJSON("/admin/modules/userInfo.php",{id: _.$(this).data("id")},function(d){
                        _.$("#affiliateSettings #realname").val = d.realname;
                        _.$("#affiliateSettings #playername").val = d.playername;
                        _.$("#affiliateSettings #comission").val = d.comission;
                        _.$("#affiliateSettings #level2_comission").val = d.level2_comission;
                        _.$("#affiliateSettings #link2_commission").val = d.link2_commission;
                        _.$("#affiliateSettings #email").val = d.email;
                        _.$("#affiliateSettings #twolevel").val = d.level2;
                        _.$("#affiliateSettings #chipsBalance").HTML(d.balance);
                        A.Actions.Affiliates.Settings.Balance.init()
                        
                        _.$("#saveAffiliate").click(A.Actions.Affiliates.Settings.onSave);
                        A.Actions.Affiliates.Settings.Referrals.load();
                    }, function(m){
                        console.error(m);
                    }, function(e){
                        console.error(e);
                    })
                }
                
                ,onSave: function(e){
                    _.$("#affiliateStatus").HTML("<i class='info'>Saving...</i>")
                    var s = {
                        realname: _.$("#affiliateSettings #realname").val
                        ,playername: _.$("#affiliateSettings #playername").val
                        ,comission: _.$("#affiliateSettings #comission").val
                        ,link2_commission: _.$("#affiliateSettings #link2_commission").val
                        ,level2_comission: _.$("#affiliateSettings #level2_comission").val
                        ,email:  _.$("#affiliateSettings #email").val
                        ,level2:  _.$("#affiliateSettings #twolevel").val
                        ,id: _.E.affiliate
                    }
                    
                    console.log(s);
                    _.postJSON("/admin/modules/saveAffiliate.php",s,function(d){
                        _.$("#affiliateStatus").HTML("<i class='ok'>"+d+"</i>")
                    },function(m){
                        _.$("#affiliateStatus").HTML("<i class='error'>"+m+"</i>")
                    },function(e){
                        _.$("#affiliateStatus").HTML("<i class='error'>An unexpected error occured!</i>");
                        console.error(e);
                    })
                }
                
                ,Balance: {
                    init: function(){
                        _.$("#chips label.dec").addClass("inactive");
                        _.$("#chips label.dec input").click(this.focusDec).focus(this.focusDec);
                        _.$("#chips label.inc input").click(this.focusInc).focus(this.focusInc);
                        A.Actions.Affiliates.Settings.Balance.onInc.call(_.$("#addChips")[0])
                        
                        _.$("#chips #addChips").keyup(this.onInc).change(this.onInc);
                        _.$("#chips #decChips").keyup(this.onDec).change(this.onDec);
                        _.$("#transferChips").click(this.onSubmit);
                        
                    }
                    
                    ,focusDec: function(){
                        _.$("#chips label.dec").removeClass("inactive");
                        _.$("#chips label.inc").addClass("inactive");
                        A.Actions.Affiliates.Settings.Balance.onDec.call(this)
                    }
                    
                    ,focusInc: function(){
                        _.$("#chips label.inc").removeClass("inactive");
                        _.$("#chips label.dec").addClass("inactive");
                        A.Actions.Affiliates.Settings.Balance.onInc.call(this)
                    }
                    
                    ,onInc: function(e){
                        var amount = this.value*1;
                        _.$("#transferChips").val = "Add "+amount+" chips to player balance";
                        _.$("#transferChips").data("amount",amount)
                    }
                    
                    ,onDec: function(e){
                        var amount = this.value*1;
                        _.$("#transferChips").val = "Deduct "+amount+" chips from player balance";
                        _.$("#transferChips").data("amount", -amount)
                    }
                    
                    ,onSubmit: function(){
                        var amount = _.$(this).data("amount");
                        
                        
                        _.$("#transferStatus").HTML("<i class='info'>Transferring...</i>");
                        _.postJSON("/admin/modules/chipsTransfer.php",{player: _.E.affiliate, amount: amount}, function(d){
                            _.$("#transferStatus").HTML("<i class='ok'>Transfer completed successfully.</i>");
                            _.$("#chipsBalance").HTML(d);
                        }, function(e){
                            _.$("#transferStatus").HTML("<i class='error'>"+e+"</i>")
                        }, function(r){
                            _.$("#transferStatus").HTML("<i class='error'>An unexected error occured!</i>");
                            console.error(r);
                        })
                    }
                }
                ,Referrals:{
                    load: function(){
                        
                        _.$("#affiliateSettings .referralList tbody").HTML("")
                        _.$("#affiliateSettings .referralList")[0].outerHTML+="<p class='spinner_big'></p>";
                        
                        
                        _.postJSON("/admin/modules/getReferrals.php",{id: _.E.affiliate},function(d){
                            _.$("#affiliateSettings .spinner_big").remove();
                            _.$("#affiliateSettings .referralList tbody").fromTemplate("referralTemplate", d);
                            A.Actions.Affiliates.Settings.Referrals.Add.init();
                            A.Actions.Affiliates.Settings.Referrals.Remove.init();
                            
                        },function(e){
                            console.error(e);
                        }, function(r){
                            console.error(r);
                        })
                    }
                    
                    ,Remove:{
                        init: function(){
                            _.$(".removeReferral").click(this.onClick);
                        }
                        
                        ,onClick: function(e){
                            var ref = _.$(this).data("id");
                            _.postJSON("/admin/modules/removeReferral.php",{ref:ref, from: _.E.affiliate},function(d){
                                A.Actions.Affiliates.Settings.Referrals.load();
                                A.Actions.Affiliates.Settings.Referrals.Add.Loader.onPrint();
                            }, function(e){
                                console.error(e);
                            }, function(r){
                                console.error(r)
                            })
                        }
                    }
                    
                    ,Add:{
                        init: function(){
                            this.Opener.init();
                            this.Loader.init();
                        }
                        
                        ,Opener:{
                            init: function(){
                                this.unevent();
                                _.$("#addReferral").click(this.onClick)
                            }
                            
                            ,unevent: function(){
                                _.$("#addReferral").unevent("click", this.onClick)
                            }
                            
                            ,onClick:function(){
                                (_.$("#addReferralForm").display()=="block") ?
                                _.$("#addReferralForm").display("none") :  (function(){
                                    _.$("#affiliateNameSearch").val="";
                                    _.$("#addReferralForm").display("block")
                                })()
                            }
                        }
                        
                        ,Loader:{
                            init: function(){
                                this.unevent();
                                _.$("#affiliateNameSearch").keyup(this.onPrint)
                            }
                            
                            ,unevent: function(){
                                _.$("#affiliateNameSearch").unevent("keyup", this.onPrint);
                            }
                            
                            ,onPrint: function(e){
                                var text = _.$("#affiliateNameSearch").val.trim();
                                if(text.length>=3){
                                    A.Actions.Affiliates.Settings.Referrals.Add.Loader.proceed(text);
                                }
                            }
                            
                            ,proceed: function(text){
                                var table = _.$("#addReferralForm table");
                                table[0].outerHTML+="<p class='spinner_big'></p>";
                                _.postJSON("/admin/modules/searchUsers.php",{name: text}, function(d){
                                    console.log(d);
                                    _.$("#addReferralForm table tbody").fromTemplate("referralAddTemplate", d);
                                    _.$("#addReferralForm table tbody tr[data-id='"+_.E.affiliate+"']").addClass("inactive");
                                    _.$("#addReferralForm table tbody tr[data-id='"+_.E.affiliate+"'] input").remove()
                                    
                                    _.$("#addReferralForm table tbody tr[data-referral='"+_.E.affiliate+"']").addClass("inactive");
                                    _.$("#addReferralForm table tbody tr[data-referral='"+_.E.affiliate+"'] input").remove()
                                    
                                    
                                    _.$("#addReferralForm .spinner_big").remove();
                                    
                                    A.Actions.Affiliates.Settings.Referrals.Add.List.init();
                                }, function(e){
                                    console.error(e);
                                }, function(r){
                                    console.error(r);
                                })
                            }
                        }
                        
                        ,List: {
                            init: function(){
                                _.$(".submitAddReferral").click(this.onAdd);
                            }
                            
                            ,onAdd: function(e){
                                var id = _.$(this).data('id');
                                _.postJSON("/admin/modules/addAffiliateTo.php",{id: _.E.affiliate, ref: id}, function(d){
                                    A.Actions.Affiliates.Settings.Referrals.load();
                                    A.Actions.Affiliates.Settings.Referrals.Add.Loader.onPrint();
                                    
                                }, function(e){
                                    console.error(e);
                                }, function(r){
                                    console.error(r)
                                })
                            }
                        }
                    }
                    
                    
                }
            }
        }
        
        ,Tournaments:{
            init: function(){
                //_.$("#tournaments .details").click(this.Details.onClick)
            }
            
            
        }
        
        ,CurrentTournaments:{
            init: function(){
                _.$(".entryfee").click(this.onFocus).focus(this.onFocus).change(this.onFocus);
                _.$(".editentryfee").click(this.onClick);
            }
            
            ,onFocus: function(){
                _.$(this).addClass("unsaved")
            }
            
            ,onClick: function(e){
                var trn = _.$(this).data("tournament");
                var fee = _.$(this).parent(2).find(".entryfee.fee").val;
                var restart = _.$(this).parent(2).find(".restart").val
                var enabled = _.$(this).parent(2).find(".enabled")[0].checked ? 1 : 0;
                var latereg = _.$(this).parent(2).find(".latereg").val
                var showentryfee = _.$(this).parent(2).find(".enableentrypoint:checked").val;
                _.$(this).parent(2).find(".entryfee").forEach(function(e){
                    e[0].disabled = true;
                })
                var t = this;
                
                this.disabled = true;
                _.postJSON("/admin/modules/changeTournamentFee.php",{tournament: trn, fee: fee, restart: restart, enabled: enabled, latereg: latereg, show_entry_fee: showentryfee}, 
                function(d){
                    t.disabled = false;
                    _.$(t).parent(2).find(".entryfee").forEach(function(e){
                        e[0].disabled = false;
                        e.removeClass("unsaved");
                    })
                }, function(e){
                    console.error(e)
                }, function(r){
                    console.error(r)
                })
                
            }
        }
        
        ,TicketTournaments:{
            init: function(){
                _.$("#createTicket").submit(this.onCreate)
                _.Templates.add("ticket_template");
                A.Actions.TicketTournaments.handleList(); 
            }
            
            ,onCreate: function(e){
                e.preventDefault();
                var s = {
                    places: _.$("#ticket_places").val
                    ,tournament: _.$("#ticket_tournament").val
                    ,tournament_for: _.$("#ticket_for").val
                }
                console.log(s);
                
                if(s.tournament == s.tournament_for){
                    _.$("#ticketStatus").HTML("<i class='error'>Tournament and ticket target must be different! </i>");
                    return;
                }
                _.$("#ticketStatus").HTML("<i class='info'>Saving ticket... </i>");
                
                _.postJSON("/admin/modules/createTicket.php",s,function(d){
                    _.$("#ticketStatus").HTML("<i class='ok'>"+d+"</i>");
                    A.Actions.TicketTournaments.reload()
                },function(e){
                    _.$("#ticketStatus").HTML("<i class='error'>"+e+"</i>");
                }, function(r){
                    _.$("#ticketStatus").HTML("<i class='error'>An unexpected error has occured!</i>");
                    console.error(r)
                })
            }
            
            ,reload: function(){
                _.postJSON("/admin/modules/ticketList.php",{}, function(d){
                    _.$("#tickets tbody").fromTemplate("ticket_template",d);
                    A.Actions.TicketTournaments.handleList();
                }, function(e){
                    console.error(e);
                },function(r){
                    console.error(r)
                })
            }
            
            ,handleList: function(){
                _.$("#tickets .removeTicket").click(this.onDelete)
            }
            
            ,onDelete: function(){
                var id = _.$(this).parent(2).data("ticket");
                _.$("#ticketStatus").HTML("<i class='info'>Deleting ticket...</i>");
                _.postJSON("/admin/modules/removeTicket.php",{id:id}, function(d){
                    _.$("#tickets tr[data-ticket='"+id+"']").remove()
                    _.$("#ticketStatus").HTML("<i class='ok'>Ticket removed successfully!</i>");
                }, function(e){
                    console.error(e);
                    _.$("#ticketStatus").HTML("<i class='error'>An error occured while deleting!</i>");
                }, function(r){
                    _.$("#ticketStatus").HTML("<i class='error'>An unexpected error occured while deleting!</i>");
                    console.error(r);
                })
            }
        }
        
        ,Cashout:{
            init: function(){
                _.$("#cashouts .accept").click(this.onAccept);
                _.$("#cashouts .decline").click(this.onDecline);
                this.History.init();
                _.$("input.history").click(this.onHistory);
                this.Amount.init()
            }
            
            ,Amount:{
                init: function(){
                    _.$("tr .editAmount").click(this.onStart)
                }
                
                ,onStart: function(){
                    var amo = _.$(this).parent().find("span").HTML()*1;
                    _.$(this).removeClass("editAmount").addClass("saveAmount");
                    _.$(this).unevent("click", A.Actions.Cashout.Amount.onStart);
                    _.$(this).click(A.Actions.Cashout.Amount.onSave);
                    
                    _.$(this).parent().find("span").HTML("<input type='number' value='"+amo+"'/>");
                }
                
                ,onSave: function(){
                    var amo = _.$(this).parent().find("input").val
                    var id = _.$(this).parent(2).data("id");
                    
                    var t = this;
                    t.disabled = true;
                    _.$(t).parent().find("span input")[0].disabled=true;
                    
                    _.postJSON("/admin/modules/cashoutAmount.php",{amount: amo, id: id}, function(d){
                        
                        t.disabled = false;
                        _.$(t).parent().find("span").HTML(_.$(t).parent().find("span input").val);
                        
                        _.$(t).addClass("editAmount").removeClass("saveAmount").unevent("click", A.Actions.Cashout.Amount.onSave).click(A.Actions.Cashout.Amount.onStart);
                        
                    }, function(e){
                        console.error(e)
                    }, function(r){
                        console.error(r);
                    })
                }
            }
            
            ,onAccept: function(){
                var id = _.$(this).parent(2).data("id");
                A.Actions.Cashout.change({id: id, status: 1})
            }
            
            ,onDecline: function(){
                var id = _.$(this).parent(2).data("id");
                A.Actions.Cashout.change({id: id, status: -1})
            }
            
            ,change: function(s){
                _.postJSON("/admin/modules/cashoutStatus.php",s,function(d){
                    _.$("#cashouts tr[data-id='"+s.id+"'] .buttons").HTML("");
                    _.$("#cashouts tr[data-id='"+s.id+"'] .stat").HTML(d);
                },function(e){
                    console.error(e)
                }, function(r){
                    console.error(r);
                })
            }
            
            ,History:{
                init: function(){
                    _.Templates.add("transferTemplate");
                    _.$("td input.history").click(this.onClick);
                    _.$("#transfersHistory").click(function(e){
                        if(e.target==this) {
                            _.$(this).display("none");
                        }
                    })
                    
                }
                
                ,onClick: function(e){
                    e.preventDefault()
                    var user = _.$(this).parent(1).find(".user").HTML().trim();
                    _.$("#transfersHistory").display("block");
                    A.Actions.Cashout.History.load(user);
                
                }
                
                ,load: function(user){
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
        
        ,Deposits:{
            init: function(){
                _.$("#deposits .accept").click(this.onAccept);
                _.$("#deposits .decline").click(this.onDecline);
                A.Actions.Cashout.History.init();
                this.Amount.init()
            }
            
            ,Amount:{
                init: function(){
                    _.$("tr .editAmount").click(this.onStart)
                }
                
                ,onStart: function(){
                    var amo = _.$(this).parent().find("span").HTML()*1;
                    _.$(this).removeClass("editAmount").addClass("saveAmount");
                    _.$(this).unevent("click", A.Actions.Deposits.Amount.onStart);
                    _.$(this).click(A.Actions.Deposits.Amount.onSave);
                    
                    _.$(this).parent().find("span").HTML("<input type='number' value='"+amo+"'/>");
                }
                
                ,onSave: function(){
                    var amo = _.$(this).parent().find("input").val
                    var id = _.$(this).parent(2).data("id");
                    
                    var t = this;
                    t.disabled = true;
                    _.$(t).parent().find("span input")[0].disabled=true;
                    
                    _.postJSON("/admin/modules/depositAmount.php",{amount: amo, id: id}, function(d){
                        
                        t.disabled = false;
                        _.$(t).parent().find("span").HTML(_.$(t).parent().find("span input").val);
                        
                        _.$(t).addClass("editAmount").removeClass("saveAmount").unevent("click", A.Actions.Deposits.Amount.onSave).click(A.Actions.Deposits.Amount.onStart);
                        
                    }, function(e){
                        console.error(e)
                    }, function(r){
                        console.error(r);
                    })
                }
            }
            
            ,onAccept: function(){
                var id = _.$(this).parent(2).data("id");
                A.Actions.Deposits.change({id: id, status: 1})
            }
            
            ,onDecline: function(){
                var id = _.$(this).parent(2).data("id");
                A.Actions.Deposits.change({id: id, status: -1})
            }
            
            ,change: function(s){
                _.postJSON("/admin/modules/depositStatus.php",s,function(d){
                    _.$("#deposits tr[data-id='"+s.id+"'] .buttons").HTML("");
                    _.$("#deposits tr[data-id='"+s.id+"'] .stat").HTML(d);
                },function(e){
                    console.error(e)
                }, function(r){
                    console.error(r);
                })
            }
        }
    }
}
_.core(function(){ 
    A.init(); 
    viewTournamentResult = function(id){
        _.$("#tournamentResultView").display("block");
        _.$("#tournamentResultView .wrap .container").HTML("<p class='spinner_big'></p>");
        
        _.$("#tournamentResultView .wrap").get("/profile/modules/tournament-result.php",{tournament_id:id})
    }  
})