function myfun1(){
	document.getElementById("item1mobile").style.display="block";
	document.getElementById("item2mobile").style.display="none";
}
function myfun2(){
	document.getElementById("item1mobile").style.display="none";
	document.getElementById("item2mobile").style.display="block";
}

//计算水钱
function cal_shuiqia(total_money, cashback_rate, jackpot_rate,number_type) {		
	var shui_qian_value =0;
	if (number_type == 3 ) {
		shui_qian_value = 100 - total_money - cashback_rate -  	jackpot_rate;
	}else if( number_type == 2 ){
		shui_qian_value = (1000 - total_money - cashback_rate*10 - jackpot_rate*10)/10;
	}else if( number_type == 1 ){
		shui_qian_value = (10000 - total_money - cashback_rate*100 - jackpot_rate*100)/100;
	}

	if (shui_qian_value < 0) {
		shui_qian_value = 0;
	}
	if ( shui_qian_value > 100 ) {
		shui_qian_value = 100;
	}
	return shui_qian_value;
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

function cal_cashback() {
	var odds_b = [];
	var odds_s = [];
	var odds_a = [];
	var odds_3abc = [];
	var odds_4a = [];
	var odds_4abc = [];
	var odds_2a = [];
	var odds_2abc = [];
	var my_cashback = [];
	var commission = [];

	$('.my_cashback').each(function() {
		my_cashback.push(parseFloat($(this).val()));
	});
	$('.commission').each(function() {
		commission.push(parseFloat($(this).val()));
	});

	$('.odds_b').each(function () {
		odds_b.push(parseFloat($(this).val()));
	});
	var odds_b_total = getTotal(odds_b);
	var cashback_money_b = cal_shuiqia(odds_b_total,(my_cashback[0]+commission[0]),0,1);
	

	$('.odds_s').each(function () {
		odds_s.push(parseFloat($(this).val()));
	});
	var odds_s_total = getTotal(odds_s);
	var cashback_money_s = cal_shuiqia(odds_s_total,(my_cashback[1]+commission[1]),0,1);

	$('.odds_3abc').each(function () {
		odds_3abc.push(parseFloat($(this).val()));
	});
	setallodds(odds_3abc[0],'odds_3abc');
	odds_3abc = [];
	$('.odds_3abc').each(function () {
		odds_3abc.push(parseFloat($(this).val()));
	});
	var odds_3abc_total = getTotal(odds_3abc);
	var cashback_money_3abc = cal_shuiqia(odds_3abc_total,(my_cashback[3]+commission[3]),0,2);

	$('.odds_4abc').each(function () {
		odds_4abc.push(parseFloat($(this).val()));
	});
	setallodds(odds_4abc[0],'odds_4abc');
	odds_4abc = [];
	$('.odds_4abc').each(function () {
		odds_4abc.push(parseFloat($(this).val()));
	});
	var odds_4abc_total = getTotal(odds_4abc);
	var cashback_money_4abc = cal_shuiqia(odds_4abc_total,(my_cashback[5]+commission[5]),0,1);

	$('.odds_2abc').each(function () {
		odds_2abc.push(parseFloat($(this).val()));
	});
	setallodds(odds_2abc[0],'odds_2abc');
	odds_2abc = [];
	$('.odds_2abc').each(function () {
		odds_2abc.push(parseFloat($(this).val()));
	});
	var odds_2abc_total = getTotal(odds_2abc);
	var cashback_money_2abc = cal_shuiqia(odds_2abc_total,(my_cashback[7]+commission[7]),0,3);

	$('.odds_2a').each(function () {
		odds_2a.push(parseFloat($(this).val()));
	});
	var odds_2a_max = get_max(odds_2a);
	var cashback_money_2a = cal_shuiqia(odds_2a_max,(my_cashback[6]+commission[6]),0,3);
	setallodds(odds_2a_max,'odds_2a');

	$('.odds_4a').each(function () {
		odds_4a.push(parseFloat($(this).val()));
	});
	var odds_4a_max = get_max(odds_4a);
	var cashback_money_4a = cal_shuiqia(odds_4a_max,(my_cashback[4]+commission[4]),0,1);
	setallodds(odds_4a_max,'odds_4a');

	$('.odds_a').each(function () {
		odds_a.push(parseFloat($(this).val()));
	});
	var odds_a_max = get_max(odds_a);
	var cashback_money_a = cal_shuiqia(odds_a_max,(my_cashback[2]+commission[2]),0,2);
	setallodds(odds_a_max,'odds_a');

	$('#cashback_money_b').text(Math.round(cashback_money_b));
	$('#cashback_money_s').text(Math.round(cashback_money_s));
	$('#cashback_money_a').text(Math.round(cashback_money_a));
	$('#cashback_money_3abc').text(Math.round(cashback_money_3abc));
	$('#cashback_money_4a').text(Math.round(cashback_money_4a));
	$('#cashback_money_4abc').text(Math.round(cashback_money_4abc));
	$('#cashback_money_2a').text(Math.round(cashback_money_2a));
	$('#cashback_money_2abc').text(Math.round(cashback_money_2abc));
}
$('input').blur(function () {
	cal_cashback();
});
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

function keyupcheck(obj) {
	var my_cashback = [];
	$('.my_cashback').each(function() {
		my_cashback.push(parseFloat($(this).val()));
	});
	var jackpot = parseFloat($('input[name=jackpot]').val());
	obj.value=obj.value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'');
	var cl = $(obj).attr('class');
	if (cl == 'odds_b') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		var odds_check = getTotal(odds);
		var total = 10000-my_cashback[0]-jackpot;
		if (odds_check>total) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_s') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		var odds_check = getTotal(odds);
		var total = 10000-my_cashback[1]-jackpot;
		if (odds_check>total) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_a') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		var odds_check = get_max(odds);
		var total = 1000-my_cashback[2]-jackpot;
		if (odds_check>total) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_3abc') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		var odds_check = getTotal(odds);
		var total = 1000-my_cashback[3]-jackpot;
		if (odds_check>total) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_4a') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		var odds_check = get_max(odds);
		var total = 10000-my_cashback[4]-jackpot;
		if (odds_check>total) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_4abc') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		var odds_check = getTotal(odds);
		var total = 10000-my_cashback[5]-jackpot;
		if (odds_check>total) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_2a') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		var odds_check = get_max(odds);
		var total = 100-my_cashback[6]-jackpot;
		if (odds_check>total) {
			$(obj).val('');
		}
	}
	if (cl == 'odds_2abc') {
		var odds = [];
		$('.'+cl).each(function () {
			odds.push(parseFloat($(this).val()));
		});
		var odds_check = getTotal(odds);
		var total = 100-my_cashback[7]-jackpot;
		if (odds_check>total) {
			$(obj).val('');
		}
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

function add_agent(url) {
	var cashback = [];
	var cashback_percent = [];
	var credit = parseFloat($('input[name=credit]').val());
	var bonus = parseFloat($('input[name=bonus]').val());
	var account = $('input[name=agent_account]').val();
	var nickname = $('input[name=agent_nickname]').val();
	var password = $('input[name=agent_password]').val();
	var repassword = $('input[name=agent_repassword]').val();
	$('.cashback_agent').each(function () {
		cashback.push(parseFloat($(this).val()));
	})
	cashback_percent.push({'B':cashback[0],'S':cashback[1],'A':cashback[2],'3ABC':cashback[3],'4A':cashback[4],'4ABC':cashback[5],'2A':cashback[6],'2ABC':cashback[7]});

	$.post(url,{credit:credit,bonus:bonus,cashback:cashback_percent,account:account,nickname:nickname,password:password,repassword:repassword},function(result) {
		alert(result.message);
		if (result.type == 'success') {
			location.href = history.back(-1);
		}
	},'JSON');
}

function add_player(url) {
	var odds_b = [];
	var odds_s = [];
	var odds_a = [];
	var odds_3abc = [];
	var odds_4a = [];
	var odds_4abc = [];
	var odds_2a = [];
	var odds_2abc = [];
	var credit = $('input[name=credit]').val();
	var account = $('input[name=account]').val();
	var nickname = $('input[name=nickname]').val();
	var password = $('input[name=password]').val();
	var repassword = $('input[name=repassword]').val();

	$('.odds_b').each(function () {
		odds_b.push(parseFloat($(this).val()));
	});

	$('.odds_s').each(function () {
		odds_s.push(parseFloat($(this).val()));
	});

	$('.odds_3abc').each(function () {
		odds_3abc.push(parseFloat($(this).val()));
	});

	$('.odds_4abc').each(function () {
		odds_4abc.push(parseFloat($(this).val()));
	});

	$('.odds_2abc').each(function () {
		odds_2abc.push(parseFloat($(this).val()));
	});

	$('.odds_2a').each(function () {
		odds_2a.push(parseFloat($(this).val()));
	});

	$('.odds_4a').each(function () {
		odds_4a.push(parseFloat($(this).val()));
	});

	$('.odds_a').each(function () {
		odds_a.push(parseFloat($(this).val()));
	});

	var odds = [];
	var cashback_percent = [];
	odds.push({'B':odds_b,'S':odds_s,'A':odds_a,'3ABC':odds_3abc,'4ABC':odds_4abc,'2ABC':odds_2abc,'2A':odds_2a,'4A':odds_4a});
	$.post(url,{odds:odds,account:account,nickname:nickname,password:password,repassword:repassword,credit:credit},function(result) {
		alert(result.message);
		if (result.type == 'success') {
			location.href = history.back(-1);
		}
	},'JSON');
}

function save_odds(url) {
	var odds_b = [];
	var odds_s = [];
	var odds_a = [];
	var odds_3abc = [];
	var odds_4a = [];
	var odds_4abc = [];
	var odds_2a = [];
	var odds_2abc = [];
	$('.odds_b').each(function () {
		odds_b.push(parseFloat($(this).val()));
	});

	$('.odds_s').each(function () {
		odds_s.push(parseFloat($(this).val()));
	});

	$('.odds_3abc').each(function () {
		odds_3abc.push(parseFloat($(this).val()));
	});

	$('.odds_4abc').each(function () {
		odds_4abc.push(parseFloat($(this).val()));
	});

	$('.odds_2abc').each(function () {
		odds_2abc.push(parseFloat($(this).val()));
	});

	$('.odds_2a').each(function () {
		odds_2a.push(parseFloat($(this).val()));
	});

	$('.odds_4a').each(function () {
		odds_4a.push(parseFloat($(this).val()));
	});

	$('.odds_a').each(function () {
		odds_a.push(parseFloat($(this).val()));
	});
	var title = $('#odds-title').val();

	var odds = {'B':odds_b,'S':odds_s,'A':odds_a,'3ABC':odds_3abc,'4ABC':odds_4abc,'2ABC':odds_2abc,'2A':odds_2a,'4A':odds_4a};
	$.post(url,{odds:odds,title,title},function(result) {
		alert(result.info);
		if (result.status == 3) {
			location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
		}
		if (result.status == 1) {
			window.location.reload();
		}
	},'JSON');
}

function use_odds(url,id) {
	$.post(url,{id:id},function(result) {
		if (result.status == 3) {
			alert(result.info);
			location.href="./index.php?i=6&c=entry&m=purchasing&do=login";
		}else{
			var list = result.list;
			var odds_b = list.odds_B;
			var odds_s = list.odds_S;
			var odds_3abc = list.odds_3ABC;
			var odds_4abc = list.odds_4ABC;
			var odds_2abc = list.odds_2ABC;
			for (var i = 0 in odds_b) {
				$('input[data-value=odds_b_'+i+']').val(odds_b[i]);
			}
			for (var j = 0 in odds_s) {
				$('input[data-value=odds_s_'+j+']').val(odds_s[j]);
			}
			for (var k = 0 in odds_3abc) {
				$('input[data-value=odds_3abc_'+k+']').val(odds_3abc[k]);
			}
			for (var l = 0 in odds_4abc) {
				$('input[data-value=odds_4abc_'+l+']').val(odds_4abc[l]);
			}
			for (var m = 0 in odds_2abc) {
				$('input[data-value=odds_2abc_'+m+']').val(odds_2abc[m]);
			}
			$('input[data-value=odds_a]').val(list.odds_A);
			$('input[data-value=odds_c2]').val(list.odds_C2);
			$('input[data-value=odds_c3]').val(list.odds_C3);
			$('input[data-value=odds_c4]').val(list.odds_C4);
			$('input[data-value=odds_c5]').val(list.odds_C5);
			$('input[data-value=odds_4a]').val(list.odds_4A);
			$('input[data-value=odds_4b]').val(list.odds_4B);
			$('input[data-value=odds_4c]').val(list.odds_4C);
			$('input[data-value=odds_4d]').val(list.odds_4D);
			$('input[data-value=odds_4e]').val(list.odds_4E);
			$('input[data-value=odds_2a]').val(list.odds_2A);
			$('input[data-value=odds_2b]').val(list.odds_2B);
			$('input[data-value=odds_2c]').val(list.odds_2C);
			$('input[data-value=odds_2d]').val(list.odds_2D);
			$('input[data-value=odds_2e]').val(list.odds_2E);
			$('input[data-value=odds_ec]').val(list.odds_EC);
			$('input[data-value=odds_ea]').val(list.odds_EA);
			$('input[data-value=odds_ex]').val(list.odds_EX);
			cal_cashback();
		}
		$('.get-area').hide();
	},'JSON');
}