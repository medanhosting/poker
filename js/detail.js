A = {
    init: function(){
        //this.FrameRequest.init();
        this.Incomes.init();
        alert("heheh");
        _.$("#details").click(function(e){
            _.$("#details").display("none");
        })
        _.$("#details>*").click(function(e){
            e.stopPropagation();
        })
    }
    ,Incomes: {
        
        init: function(){
            _.$(".referralsLink").click(this.openReferrals)
            this.done = _.$(".referrals .refs tr[data-id]").length;
            this.ids=[];
            _.$(".pagination a").click(A.Incomes.Details.onClick);            
        }
        
        ,Details: {
            onClick: function(e){
                e.preventDefault();
                _.$("#details").display("block");
                _.$("#details .wrap").HTML("<p class='spinner_big'></p>");
                var id = _.$(this).data("id");
                var page = _.$(this).data("page")
                console.log(_.$('#details .wrap'));
                _.$("#details .wrap").get("/profile/modules/details.php",{id:id,page:page},A.Incomes.Details.onLoad)
            }
            
            ,onLoad: function(r){
                alert("hihih");
                _.$("#details a.view").click(function(e){
                    e.preventDefault();
                    _.$(this).parent().find("div.hand").display("block");
                })
                
                _.$('#fees').display("none");
                _.$(".nav a.fees").click(function(e){
                    alert('fee');
                    e.preventDefault();
                    _.$(".nav a").removeClass("active")
                    _.$(this).addClass("active");
                    _.$("#details table").display('none')
                    _.$("#rakes").display('none')
                    _.$("#fees").display("table");
                    
                })
                _.$(".nav a.rakes").click(function(e){
                    alert('rake');
                    e.preventDefault();
                    _.$(".nav a").removeClass("active")
                    _.$(this).addClass("active");
                    _.$("#details table").display('none')
                    _.$("#fees").display("none");
                    _.$("#rakes").display("table");
                    
                })
            }
            
        }
    }
}

_.core(function(){
    A.init();    
    pagination = function(){
        alert("hihi");
    }   
})
