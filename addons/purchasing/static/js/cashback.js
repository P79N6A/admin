function cal_shuiqia(total_money, cashback_rate,number_type) {		
	var shui_qian_value =0;
	if (number_type == 3 ) {
		shui_qian_value = 100 - total_money - cashback_rate;
	}else if( number_type == 2 ){
		shui_qian_value = (1000 - total_money - cashback_rate*10)/10;
	}else if( number_type == 1 ){
		shui_qian_value = (10000 - total_money - cashback_rate*100)/100;
	}
	else if (number_type == 4) {
		shui_qian_value = (100000 - total_money - cashback_rate*1000)/1000;
	}
	else if (number_type == 5) {
		shui_qian_value = (1000000 - total_money - cashback_rate*10000)/10000;
	}
	if ( shui_qian_value > 100 ) {
		shui_qian_value = 100;
	}
	return shui_qian_value;
}
function cal_cashback(id,odds_event) {
	// var odds_b = [];
	// var odds_s = [];
	// var odds_a = [];
	// var odds_3abc = [];
	// var odds_4a = [];
	// var odds_4abc = [];
	// var odds_2a = [];
	// var odds_2abc = [];
	// var odds_5d = [];
	// var odds_6d = [];
	var odds = [];
	var my_cashback = [];
	var agent_cashback = [];
	var used_odds = $('#used_odds').val();


	$('.agent_cashback_'+id).each(function() {
		agent_cashback.push(parseFloat($(this).val()));
	})
	$('.commission_'+id).each(function() {
		my_cashback.push(parseFloat($(this).val()));
	});

	$('.odds_'+odds_event+'_'+id).each(function() {
		odds.push(parseFloat($(this).val()));
	})
	if (odds_event == 'b' || odds_event == 's' || odds_event == '3abc' || odds_event == '4abc' || odds_event == '2abc') {
		var odds_total = getTotal(odds);
	}
	if (odds_event == 'a' || odds_event == '4a' || odds_event == '2a') {
		var odds_total = get_max(odds);
	}
	if(odds_event == '5d') {
		var odds_total = get_5d_total(odds);
	}
	if (odds_event == '6d'){
		var odds_total = get_6d_total(odds);
	}
	var cashback_money = 0
	switch (odds_event) {
		case 'b':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[0]+agent_cashback[0]),1);
			break;
		case 's':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[1]+agent_cashback[1]),1);
			break;
		case 'a':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[2]+agent_cashback[2]),2);
			break;
		case '3abc':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[3]+agent_cashback[3]),2);
			break;
		case '4a':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[4]+agent_cashback[4]),1);
			break;
		case '4abc':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[5]+agent_cashback[5]),1);
			break;
		case '2a':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[6]+agent_cashback[6]),3);
			break;
		case '2abc':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[7]+agent_cashback[7]),3);
			break;
		case '5d':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[8]+agent_cashback[8]),4);
			break;
		case '6d':
			cashback_money = cal_shuiqia(odds_total,(my_cashback[9]+agent_cashback[9]),5);
			break;
	}
	console.log(odds_total);
	$('#cashback_money_'+odds_event+'_'+id).text(Math.round(cashback_money));
	return false;
	// $('.odds_b_'+id).each(function () {
	// 	odds_b.push(parseFloat($(this).val()));
	// });
	// var odds_b_total = getTotal(odds_b);
	// var cashback_money_b = cal_shuiqia(odds_b_total,(my_cashback[0]+agent_cashback[0]),0,1);
	

	// $('.odds_s_'+id).each(function () {
	// 	odds_s.push(parseFloat($(this).val()));
	// });
	// var odds_s_total = getTotal(odds_s);
	// var cashback_money_s = cal_shuiqia(odds_s_total,(my_cashback[1]+agent_cashback[1]),0,1);

	// $('.odds_3abc_'+id).each(function () {
	// 	odds_3abc.push(parseFloat($(this).val()));
	// });
	// var odds_3abc_total = getTotal(odds_3abc);
	// var cashback_money_3abc = cal_shuiqia(odds_3abc_total,(my_cashback[3]+agent_cashback[3]),0,2);
	// $('.odds_4abc_'+id).each(function () {
	// 	odds_4abc.push(parseFloat($(this).val()));
	// });
	// var odds_4abc_total = getTotal(odds_4abc);
	// var cashback_money_4abc = cal_shuiqia(odds_4abc_total,(my_cashback[5]+agent_cashback[5]),0,1);
	// $('.odds_2abc_'+id).each(function () {
	// 	odds_2abc.push(parseFloat($(this).val()));
	// });
	// var odds_2abc_total = getTotal(odds_2abc);
	// var cashback_money_2abc = cal_shuiqia(odds_2abc_total,(my_cashback[7]+agent_cashback[7]),0,3);

	// $('.odds_2a_'+id).each(function () {
	// 	odds_2a.push(parseFloat($(this).val()));
	// });
	// var odds_2a_max = get_max(odds_2a);
	// var cashback_money_2a = cal_shuiqia(odds_2a_max,(my_cashback[6]+agent_cashback[6]),0,3);

	// $('.odds_4a_'+id).each(function () {
	// 	odds_4a.push(parseFloat($(this).val()));
	// });
	// var odds_4a_max = get_max(odds_4a);
	// var cashback_money_4a = cal_shuiqia(odds_4a_max,(my_cashback[4]+agent_cashback[4]),0,1);

	// $('.odds_a_'+id).each(function () {
	// 	odds_a.push(parseFloat($(this).val()));
	// });
	// var odds_a_max = get_max(odds_a);
	// var cashback_money_a = cal_shuiqia(odds_a_max,(my_cashback[2]+agent_cashback[2]),0,2);

	// $('.odds_5d_'+id).each(function() {
	// 	odds_5d.push($(this).val());
	// });
	// var odds_5d_total = get_5d_total(odds_5d);
	// var cashback_money_5d = cal_shuiqia(odds_5d_total,(my_cashback[8]+agent_cashback[8]),0,4);

	// $('.odds_6d_'+id).each(function() {
	// 	odds_6d.push($(this).val());
	// });
	// var odds_6d_total = get_6d_total(odds_6d);
	// var cashback_money_6d = cal_shuiqia(odds_6d_total,(my_cashback[9]+agent_cashback[9]),0,5);
	// $('#cashback_money_b_'+id).text(Math.round(cashback_money_b));
	// $('#cashback_money_s_'+id).text(Math.round(cashback_money_s));
	// $('#cashback_money_a_'+id).text(Math.round(cashback_money_a));
	// $('#cashback_money_3abc_'+id).text(Math.round(cashback_money_3abc));
	// $('#cashback_money_4a_'+id).text(Math.round(cashback_money_4a));
	// $('#cashback_money_4abc_'+id).text(Math.round(cashback_money_4abc));
	// $('#cashback_money_2a_'+id).text(Math.round(cashback_money_2a));
	// $('#cashback_money_2abc_'+id).text(Math.round(cashback_money_2abc));
	// $('#cashback_money_5d_'+id).text(Math.round(cashback_money_5d));
	// $('#cashback_money_6d_'+id).text(Math.round(cashback_money_6d));
}
function keyupcheck(obj) {
	obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
	obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
	obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
	obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
	var cl = $(obj).attr('class');
	if (cl == 'odds_b' || cl == 'odds_s' ||  cl == 'odds_4abc' || cl == 'odds_4a') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		if (cl == 'odds_4a') {
			var odds_check = get_max(odds);
		}
		else{
			var odds_check = getTotal(odds);
		}
		if (odds_check>10000) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_3abc' || cl == 'odds_a') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		if (cl == 'odds_a') {
			var odds_check = get_max(odds);
		}
		else{
			var odds_check = getTotal(odds);
		}
		if (odds_check>1000) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_2abc' || cl == 'odds_2a') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		if (cl == 'odds_2a') {
			var odds_check = get_max(odds);
		}
		else{
			var odds_check = getTotal(odds);
		}
		if (odds_check > 100) {
			$(obj).val('');
		}
	}
}

function get_5d_total(odds) {
	var total_odds = 0;
	for (var i = 0; i < 6; i++) {
		if (i == 3) {
			total_odds = total_odds+(odds[i]*10*2);
		}
		else if (i == 4) {
			total_odds = total_odds+(odds[i]*100*2);
		}
		else if (i == 5) {
			total_odds = total_odds+(odds[i]*1000*2);
		}
		else{
			total_odds = total_odds+parseFloat(odds[i]);
		}
	}
	return total_odds;
}

function get_6d_total(odds) {
	var total_odds = 0;
	for (var i = 0; i < 5; i++) {
		if (i == 1) {
			total_odds = total_odds+(odds[i]*10*2);
		}
		else if (i == 2) {
			total_odds = total_odds+(odds[i]*100*2);
		}
		else if (i == 3) {
			total_odds = total_odds+(odds[i]*1000*2);
		}
		else if (i == 4) {
			total_odds = total_odds+(odds[i]*10000*2);
		}
		else{
			total_odds = total_odds+parseFloat(odds[i]);
		}
	}
	return total_odds;
}
function setallodds(odds,cl) {
	if (cl == 'odds_a') {
		$('input[data-value=odds_a]').val(odds);
		$('input[data-value=odds_c2]').val(odds);
		$('input[data-value=odds_c3]').val(odds);
		$('input[data-value=odds_c4]').val(odds/10);
		$('input[data-value=odds_c5]').val(odds/10);
		$('input[data-value=odds_ec]').val(odds/23);
	}
	if (cl == 'odds_2a') {
		$('input[data-value=odds_2a]').val(odds);
		$('input[data-value=odds_2b]').val(odds);
		$('input[data-value=odds_2c]').val(odds);
		$('input[data-value=odds_2d]').val(odds/10);
		$('input[data-value=odds_2e]').val(odds/10);
		$('input[data-value=odds_ex]').val(odds/23);
	}
	if (cl == 'odds_4a') {
		$('input[data-value=odds_4a]').val(odds);
		$('input[data-value=odds_4b]').val(odds);
		$('input[data-value=odds_4c]').val(odds);
		$('input[data-value=odds_4d]').val(odds/10);
		$('input[data-value=odds_4e]').val(odds/10);
		$('input[data-value=odds_ea]').val(odds/23);
	}
	if (cl == 'odds_s' || cl == 'odds_3abc' || cl == 'odds_4abc' || cl == 'odds_2abc') {
		$('.'+cl).val(odds);
	}
}
function get_max(obj) {
	var max = obj[0];
	var len = obj.length;
	for (var i = 1; i < len; i++){
		if (i >= 3) {
			obj[i] = obj[i]*10;
		}
		if (obj[i] > max) {
			max = obj[i];
		}
	}
	return max;
}
function getTotal(obj) {
	var len = obj.length;
	var total = 0;
	for (var i = 0; i < len; i++) {
		if (i>=3) {
			total = total + obj[i]*10;
		}
		else{
			total = total + obj[i];
		}
	}
	return total;
}