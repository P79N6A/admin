function create_order(result,txt,from) {
	if (result.type == 1) {
		txt += '<tr><td>AUTO TICKET</td></tr>';
		var autotext = '<input type="checkbox" id="auto" value="1" checked="checked" onclick="change_auto();">长期';
	}
	else{
		var autotext = '<input type="checkbox" id="auto" value="1" onclick="change_auto();">长期';
	}
	$('.auto').html(autotext);
	$('#order_id').val(result.order_id);
	if (result.order_status == 2) {
		txt += '<tr><td>CANCEL BY '+result.cancel_time+'</td></tr>';
	}
	txt += '<tr><td>'+result.account+'&nbsp;&nbsp;#'+result.sn+'</td></tr>';
	if (result.has_sale_out == 1) {
		$('#restore').show();
		txt += '<tr><td style="font-size:18px;">WARNING LINE S.OUT</td></tr>';
	}
	else{
		$('#restore').hide();
	}
	if (result.no_edit == 1) {
		$('#edit_btn').hide();
		$('#restore').hide();
	}
	else{
		$('#edit_btn').show();
		$('#restore').show();
	}
	txt += '<tr><td>B：'+result.ordertime+'</td></tr>';
	var end = result.end;
	for (var i in end) {
		txt += '<tr><td>D：'+i+'('+end[i]+')</td></tr>';
	}
	txt += '<tr><td> </td></tr>';
	var uorder = result.uorder;
	for (var key in uorder) {
		if (key.indexOf('J',1)>-1) {
			$('#delete').hide();
		}
		txt += '<tr><td>='+key+'=</td></tr>';
		var value = uorder[key];
		for (var j = 0 in value) {
			var out = value[j].sale_out;
			if (out.length>0) {
				for (var o in out) {
					var number = out[o].number;
					if (out[o].is_red == 1) {
						if (o == 0) {
							if (value[j].type == 1) {
								txt += '<tr><td style="color:red;">{'+number+'}&nbsp;&nbsp;';
							}
							if (value[j].type == 2) {
								txt += '<tr><td style="color:red;">IB{'+number+'}&nbsp;&nbsp;';
							}
							if (value[j].type == 3) {
								txt += '<tr><td style="color:red;">{0~9}'+number.substr(1,number.length-1)+'&nbsp;&nbsp;';
							}
							if (value[j].type == 4) {
								txt += '<tr><td style="color:red;">'+number.substr(0,number.length-1)+'{0~9}&nbsp;&nbsp;';
							}
							if (value[j].type == 0){
								txt += '<tr><td style="color:red;">'+number+'&nbsp;&nbsp;';
							}
						}
						else{
							txt += '<tr><td style="color:red;">'+number+'&nbsp;&nbsp;';
						}
					}
					else{
						if (o == 0) {
							if (value[j].type == 1) {
								txt += '<tr><td>{'+number+'}&nbsp;&nbsp;';
							}
							if (value[j].type == 2) {
								txt += '<tr><td>IB{'+number+'}&nbsp;&nbsp;';
							}
							if (value[j].type == 3) {
								txt += '<tr><td>{0~9}'+number.substr(1,number.length-1)+'&nbsp;&nbsp;';
							}
							if (value[j].type == 4) {
								txt += '<tr><td>'+number.substr(0,number.length-1)+'{0~9}&nbsp;&nbsp;';
							}
							if (value[j].type == 0){
								txt += '<tr><td style="color:red;">'+number+'&nbsp;&nbsp;';
							}
						}
						else{
							txt += '<tr><td>'+number+'&nbsp;&nbsp;';
						}
					}
					
					var out_pay = out[o].can_pay;
					for (var p in out_pay) {
						txt += p+'：'+parseFloat(out_pay[p]).toFixed(2)+'[S.OUT]&nbsp;&nbsp;';
					}
					console.log(value[j].partner);
					if (value[j].partner != null && value[j].partner != '') {
						if (value[j].jackpot_number != null) {
							if (value[j].type == 1) {
								txt += '【'+value[j].jackpot_number+'{'+number+'}';
							}
							if (value[j].type == 2) {
								txt += '【'+value[j].jackpot_number+'{'+number+'}';
							}
							if (value[j].type == 3) {
								txt += '【'+value[j].jackpot_number+'{0~9}'+number.substr(1,number.length-1);
							}
							if (value[j].type == 4) {
								txt += '【'+value[j].jackpot_number+number.substr(0,number.length-1)+'{0~9}';
							}
							if (value[j].type == 0){
								txt += '【'+value[j].jackpot_number+number;
							}
						}
						else{
							if (value[j].type == 1) {
								txt += '【'+'{'+number+'}';
							}
							if (value[j].type == 2) {
								txt += '【'+'{'+number+'}';
							}
							if (value[j].type == 3) {
								txt += '【{0~9}'+number.substr(1,number.length-1);
							}
							if (value[j].type == 4) {
								txt += '【'+number.substr(0,number.length-1)+'{0~9}';
							}
							if (value[j].type == 0){
								txt += '【'+number;
							}
						}
						txt += '='+value[j].partner+'】';
					}
					txt += '</td></tr>';
				}
			}
			else{
				var number = value[j].number;
				if (value[j].type == 1) {
					txt += '<tr><td>{'+number+'}&nbsp;&nbsp;';
				}
				if (value[j].type == 2) {
					txt += '<tr><td>IB{'+number+'}&nbsp;&nbsp;';
				}
				if (value[j].type == 3) {
					txt += '<tr><td>{0~9}'+number.substr(1,number.length-1)+'&nbsp;&nbsp;';
				}
				if (value[j].type == 4) {
					txt += '<tr><td>'+number.substr(0,number.length-1)+'{0~9}&nbsp;&nbsp;';
				}
				if (value[j].type == 0) {
					txt += '<tr><td>'+number+'&nbsp;&nbsp;';
				}
				var len = number.length;
				var pay = value[j].pay;
				if (pay.length > 0) {
					for (var k = 0 in pay) {
						if (len > 4) {
							if (pay[k] > 0) {
								txt += len+'D:'+parseFloat(pay[k]).toFixed(2)+'&nbsp;&nbsp;';
							}
						}
						else{
							for (var l = 0 in rule) {
								if (value[j].rule == rule[l].id) {
									var rule_content = rule[l].content;
									var content = rule_content.split(',');
									if (content[k] != undefined && pay[k] > 0) {
										if (parseInt(value[j].false_price)>0 && from != 'xiazhu') {
											var number_price = (parseFloat(pay[k])*(100+parseInt(value[j].false_price))/100);
											txt += content[k]+':'+number_price.toFixed(2)+'&nbsp;&nbsp;';
										}
										else{
											txt += content[k]+':'+parseFloat(pay[k]).toFixed(2)+'&nbsp;&nbsp;';
										}
									}
								}
							}
						}
					}
				}
				console.log(value[j].partner);
				if (value[j].partner != null && value[j].partner != '') {
					if (value[j].jackpot_number != null) {
						if (value[j].type == 1) {
							txt += '【'+value[j].jackpot_number+'{'+number+'}';
						}
						if (value[j].type == 2) {
							txt += '【'+value[j].jackpot_number+'{'+number+'}';
						}
						if (value[j].type == 3) {
							txt += '【'+value[j].jackpot_number+'{0~9}'+number.substr(1,number.length-1);
						}
						if (value[j].type == 4) {
							txt += '【'+value[j].jackpot_number+number.substr(0,number.length-1)+'{0~9}';
						}
						if (value[j].type == 0){
							txt += '【'+value[j].jackpot_number+number;
						}
					}
					else{
						if (value[j].type == 1) {
							txt += '【'+'{'+number+'}';
						}
						if (value[j].type == 2) {
							txt += '【'+'{'+number+'}';
						}
						if (value[j].type == 3) {
							txt += '【{0~9}'+number.substr(1,number.length-1);
						}
						if (value[j].type == 4) {
							txt += '【'+number.substr(0,number.length-1)+'{0~9}';
						}
						if (value[j].type == 0){
							txt += '【'+number;
						}
					}
					txt += '='+value[j].partner+'】';
				}
				txt += '</td></tr>';
			}
		}
	}
	console.log('from：'+from);
	if (parseInt(value[0].false_price)>0 && from != 'xiazhu') {
		txt += '<tr><td>$'+(parseFloat(result.amount)*(100+parseInt(value[0].false_price))/100)+'&nbsp;&nbsp;[x：'+result.counts+']</td></tr>';
	}
	else{
		txt += '<tr><td>$'+result.amount+'&nbsp;&nbsp;[x：'+result.counts+']</td></tr>';
	}
	if (result.show_amount > 0) {
		txt += '<tr><td>N：'+result['show_amount'].toFixed(2)+'</td></tr>';
	}
	txt += '<tr><td> </td></tr>';
	txt += '<tr><td>Bayaran ikut resit.</td></tr>';
	txt += '<tr><td>S:'+result.pid+'</td></tr>';

	return txt;
}