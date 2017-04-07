_.core(function(){

	
	
	_.$("#add").click(function(){
	
		_.$(".users ul").get("add.php",{},function(){_.$(".users ul").get("userList.php",{},initList)});
		
	});
	
	initList = function(){
		_.$(".users li").click(function(){
			var id = _.$(this).attr("user-id");
			_.$("form.editor").get("form.php",{id:id},function(){
				initForm();
				_.E.id = id;
			});
			_.$(".users li").removeClass("active");
			_.$(this).addClass("active");
		})
	}
	initList();
	
	initForm = function(){
		_.$("form.editor").display("block");
		_.$(".inactive").removeClass("inactive");
		
		_.$("#user-save").click(function(){
			var s = {
				login: _.$("#user-login").val
				,oldPassword:  _.$('#user-old-password').val
				,newPassword: _.$("#user-new-password").val
				,id: _.$("#user-id").val
				,role: _.$("#user-role").val
				,info: _.$('#user-info').val
			}
			
			_.$("form.editor").post("editUser.php",s,function(){
				
				_.E.id=0;
				_.$(".users ul").get("userList.php",{},initList)
			})
		})
		
		_.$("#remove").click(function(){
			if(_.E.id)
			_.$("form.editor").post("removeUser.php",{id:_.E.id},function(){
				initList();
				_.E.id=0;
				_.$("#remove").addClass("inactive");
				_.$(".users ul").get("userList.php",{},initList)
			})
		})
		
		
	};

})