
/*
 * 获取本地通讯录
 */

var phonebooksList = new Vue({
	el: '#phoneBookList',
	data: {
		selectAll : false,
		phonebooklist: []
	},
	methods : {
		selectedPhone: function(item) {
			if(typeof item.checked == 'undefined') { //判断是否未定义，如果没点击过按钮是没有注册的，则需要先注册checked属性
				// Vue.set(item,"checked",true);//全局注册
				this.$set(item, "checked", true); //局部注册
			} else {
				item.checked = !item.checked;
			}
			
			var countTrue = 0;
			this.phonebooklist.forEach(function(item, index) {
				if(item.checked == true) {
					countTrue++;
				}
				
			});
			if(countTrue == this.phonebooklist.length) {
				document.getElementById('selectAll').classList.add("check"); //直接添加选中样式
			} else {
				document.getElementById('selectAll').classList.remove("check"); //直接移除选中样式
			}
			
		},
		checkAll :function(){
			var b = !this.selectAll;
			for(var i = 0;i<this.phonebooklist.length;i++){
				var item = this.phonebooklist[i];
				if(typeof item.checked == 'undefined') { //判断是否未定义，如果没点击过按钮是没有注册的，则需要先注册checked属性
					// Vue.set(item,"checked",true);//全局注册
					this.$set(item, "checked", b); //局部注册
					} else {
					item.checked = b;
				}
			}
			if(b){
				document.getElementById('selectAll').classList.add("check");
			}else{
				document.getElementById('selectAll').classList.remove("check");
			}
			
			this.selectAll = b;
		},
		
		//上传通讯录好友
		recommend : function(){
			var newItems = [];
			for(var i = 0;i<this.phonebooklist.length;i++){
				var item = this.phonebooklist[i];
				if(typeof item.checked != 'undefined'  &&  item.checked ){
					newItems.push({
						name : item.name,
						phone : item.phone
					});
				}
			}
			var str = JSON.stringify(newItems);
			console.log("上传数据："+str);
			mui.post(HTTP_PATTERN_URL+"upload_phone_book",{
				user_id : getState().id,
				token : getState().token,
				json : str
			},function(data){
				console.log(JSON.stringify(data));
				mui.toast(data.info);
			},'json')
		}
		
	}
});

mui_plusReady(function(){
	plus.contacts.getAddressBook(plus.contacts.ADDRESSBOOK_PHONE, function(addressbook) { //获取通讯录信息
                // 可通过addressbook进行通讯录操作
                //查找通讯录
                var newItems = [];
                addressbook.find(null, function(contacts) {
                    var username = new Array();
                    
                    for(var i = 0;i<contacts.length;i++){
                		var item = contacts[i];
                		if(item.displayName==null){
                			item.displayName = "未知联系人";
                		}
                		var phones = item.phoneNumbers;
                		for(var j = 0;j<phones.length;j++){
                			var phone = phones[j];
                			newItems.push({
                				name : item.displayName,
                				phone : phone.value
                			});
                		}
                    }
                    
                    phonebooksList.phonebooklist = newItems;
                    //console.log("手机联系人："+JSON.stringify(phonebooksList.phonebooklist));
                }, function(e) {
                    alert("Find contact error: "+ e.message);
                });

            }, function(e) {

    });
});