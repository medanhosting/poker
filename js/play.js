_.core(function(){
    _.$("header")[0].outerHTML+= "<a href='#' id='showHeader'>↓</a>";
    _.$("header nav.login ul").appendHTML("<li><a href='#' id='hideHeader'>x</a></li>");
    App.init()
    _.$("header").paddingRight("0px");
    
    _.$("#hideHeader").click(function(e){
        e.preventDefault();
        _.$("header").top("-60px").opacity("0");
        _.$("main").transition(".1s");
        _.$("main")[0].style.paddingTop = "0px"
    })
    
    _.$("#showHeader").click(function(e){
        e.preventDefault();
        _.$("header").top("0px").opacity("1");
        _.$("main")[0].style.removeProperty("padding-top");
    })
})