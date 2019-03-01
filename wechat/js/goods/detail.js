var zsSuit  = new ZsSuit();		
function getData(id){
	if (is_weixin()) {
		var send_url = WECHAT_URL;
		var param = {product_id:id,url:HTTP_URL+'product_details'};
	}
	else{
		var send_url = HTTP_URL+'product_details';
		var param = {product_id:id}
	}
	mui.getJSON(send_url, param, function(resp) {
		goodsDetail.list = convert(resp.product_details);
		console.log("=== product_details.property.detail start === ")		
		console.log(JSON.stringify(resp.product_details.property.detail));
		console.log("===  product_details.property.detail end === ")
		changeData(resp.product_details.property.detail);
		var rule = propertyJson(resp.product_details.property.contrast);	
		zsSuit.config({'suitRuleInfo': eval(rule)});
	   
		var defaultSuitJSON = [];
		console.log("===  组合属性  === ")		
	    console.log(JSON.stringify(rule));
	    var contrast_num = 0;
	    for(var i in rule){
	    	contrast_num ++;
	    	defaultSuitJSON =  rule[i].split('_'); 
	    }
	    $('#contrast_num').val(contrast_num);//可选择的组合数
		if(defaultSuitJSON){
            for(var position in defaultSuitJSON){
                zsSuit.chooseCancel(2,position,defaultSuitJSON[position]);//重新选中
            	zsSuit.set(position,defaultSuitJSON[position]);
            }
        }
		
	});
}

function getThumb (id) {
//	mui.getJSON(HTTP_URL+'product_thumb_details', {product_id:id}, function (data) {
//		var list = data.list;
//		var txt = '';
//		list.forEach(function (item) {
//			txt += '<img src="'+HTTP_SRC_URL+item+'" style="width:100%">';
//		})
//      $('#detail_thumb').html(txt);
	 
//	});
}

function getDescription(goodsId){

	if (is_weixin()) {
		var send_url = WECHAT_URL;
		var param = {goods_id:goodsId,url:HTTP_URL+'goods_description'};
	}
	else{
		var send_url = HTTP_URL+'goods_description';
		var param = {goods_id:goodsId}
	}
	 
	mui.getJSON(send_url, param, function (data) {
		var description = data.description;
        $('#detail_thumb').html(description);
     });
     
}

function convert(item) {
	var newItems = [];
	//遍历items
		var src = HTTP_SRC_URL+item.thumb;
		newItems.push({
			name:item.name,
			id:item.id,
			price:item.price,
			order_num:item.order_num,
			thumb:src,
			unit:item.unit,
			freight:item.freight,
			property:item.property
		})

	return newItems;
}

function changeData (list) {
	var newList = '<div class="deal-section"> <div class="dealinfor"><div class="sku" >';
	list.forEach(function (options,sort) {
		var optionList = newChange(options.data,sort);
		newList += '<dl><dt>'+options.title+'</dt><dd><ul class="options-item ">';
		newList += optionList;
		newList += '</ul></dd></dl>';
	});
	newList+='</div></div></div> ';
	$('#property_zone').html(newList);
}

function newChange (list,sort) {
	var newOption = '';
	list.forEach(function (items,index) {
		newOption +='<li num="'+sort+'" fn="click" note="" optionvalueid="'+items.id+'" class="" onclick="select_attr(this)">'
		+'<span class="">'+items.value +'</span><i></i></li>'; 
	})
	return newOption;
}

function minus () {
	var amount = $('input[name=amount]').val();
	var result = amount-1;
	if (result <= 0) {
		$('input[name=amount]').val(1);
	}
	else{
		$('input[name=amount]').val(result);
	}
}

function pluss () {
	var amount = $('input[name=amount]').val();
	var result = parseInt(amount)+1;
	$('input[name=amount]').val(result);
}

function propertyJson(data){ 
	console.log("组合属性"+JSON.stringify(data));
	var str = [];
	for(var i in data){
		if(data[i].contrast.length>0){
			str.push('"'+data[i].id+'":"'+data[i].contrast.reverse().join("_")+'"');
		}
	}
	str = str.join(',');
	str = '{'+str+'}';
    return JSON.parse(str);
}

zsSuit.callBack = function(data, skuId){
    //可选与不可选
    for(var i in data){
        $(".sku").find("[num="+i+"]").each(function(){
            var that    = $(this),
                curVal  = that.attr("optionValueId");
            if(zsSuit.inArr(curVal, data[i]) < 0){
                that.find("span").attr("class","");
            }else{
                that.find("span").attr("class","disabled");
            }
        });
    }
    console.log("========= 组合ID ===== "+skuId);
    $('#contrast_id').val(skuId);//设置属性组合ID
    if(skuId){
        $(".buy-now").removeClass("buy-now-disabled");
    }else{
    	$(".buy-now").addClass("buy-now-disabled");
    }
};

//套装选择事件
function select_attr(obj){
    
    var that            = $(obj),
        curVal          = that.attr("optionValueId"),
        position        = that.attr("num"),
        chooseFlag      = that.hasClass("current"),
        canNotClick     = that.find("span").hasClass("disabled");
	 
    //是否可点击
    if(canNotClick){
        return false;
    }
  
    //判断选择
    if(chooseFlag){
        zsSuit.chooseCancel(1,position,curVal);//样式变化
        zsSuit.unset(position, curVal);
    }else{
    	zsSuit.chooseCancel(2,position,curVal);//重新选中
    	zsSuit.set(position,curVal);
    }
    
} 

//套装选择导致的样式变化
zsSuit.chooseCancel = function(type,position,val){
	   
    $(".sku").find("[num="+position+"]").each(function(){
        var that    = $(this),
            curVal  = that.attr("optionValueId");
        //type操作 1取消 2选中
        if(curVal == val){
            if(type == 1){
                that.removeClass("current");
            }else{
                that.addClass("current").siblings().removeClass("current");
            }
        }
    });
}	
