function getClient(email){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/get_client.php?email='+email);
}
document.addEventListener("DOMContentLoaded",function(){
	$('.opener').click(function(e){
		$(this).parent('li').toggleClass('open');
	});
	$('.auroraForm').click(function(e){
		const formType=$(this).data('formtype');
		$('#'+formType+'-btn').removeAttr('disabled');
	});
	$('.auroraForm').submit(function(e){
		const formType=$(this).data('formtype');
		const formButtonText=$('#'+formType+'-btn').html();
		$('#'+formType+'-btn').html('<i class="i i-spin"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 4.62,11.2 q 0,0.525 -0.371875,0.8925 Q 3.87625,12.46 3.36,12.46 2.835,12.46 2.4675,12.0925 2.1,11.725 2.1,11.2 2.1,10.675 2.4675,10.3075 2.835,9.94 3.36,9.94 3.87625,9.94 4.248125,10.3075 4.62,10.675 4.62,11.2 z m 3.78,1.68 q 0,0.46375 -0.328125,0.791875 Q 7.74375,14 7.28,14 6.81625,14 6.488125,13.671875 6.16,13.34375 6.16,12.88 6.16,12.41625 6.488125,12.088125 6.81625,11.76 7.28,11.76 q 0.46375,0 0.791875,0.328125 Q 8.4,12.41625 8.4,12.88 z M 3.08,7.28 Q 3.08,7.8575 2.66875,8.26875 2.2575,8.68 1.68,8.68 1.1025,8.68 0.69125,8.26875 0.28,7.8575 0.28,7.28 0.28,6.7025 0.69125,6.29125 1.1025,5.88 1.68,5.88 2.2575,5.88 2.66875,6.29125 3.08,6.7025 3.08,7.28 z m 9.1,3.92 q 0,0.4025 -0.28875,0.69125 Q 11.6025,12.18 11.2,12.18 10.7975,12.18 10.50875,11.89125 10.22,11.6025 10.22,11.2 q 0,-0.4025 0.28875,-0.69125 Q 10.7975,10.22 11.2,10.22 q 0.4025,0 0.69125,0.28875 Q 12.18,10.7975 12.18,11.2 z M 4.9,3.36 Q 4.9,3.99875 4.449375,4.449375 3.99875,4.9 3.36,4.9 2.72125,4.9 2.270625,4.449375 1.82,3.99875 1.82,3.36 1.82,2.72125 2.270625,2.270625 2.72125,1.82 3.36,1.82 3.99875,1.82 4.449375,2.270625 4.9,2.72125 4.9,3.36 z M 8.96,1.68 q 0,0.7 -0.49,1.19 Q 7.98,3.36 7.28,3.36 6.58,3.36 6.09,2.87 5.6,2.38 5.6,1.68 5.6,0.98 6.09,0.49 6.58,0 7.28,0 7.98,0 8.47,0.49 8.96,0.98 8.96,1.68 z m 4.76,5.6 q 0,0.35 -0.245,0.595 Q 13.23,8.12 12.88,8.12 12.53,8.12 12.285,7.875 12.04,7.63 12.04,7.28 12.04,6.93 12.285,6.685 12.53,6.44 12.88,6.44 q 0.35,0 0.595,0.245 Q 13.72,6.93 13.72,7.28 z M 11.9,3.36 q 0,0.28875 -0.205625,0.494375 Q 11.48875,4.06 11.2,4.06 10.91125,4.06 10.705625,3.854375 10.5,3.64875 10.5,3.36 10.5,3.07125 10.705625,2.865625 10.91125,2.66 11.2,2.66 q 0.28875,0 0.494375,0.205625 Q 11.9,3.07125 11.9,3.36 z"/></svg></i>');
		$.ajax({
			data:$(this).serialize(),
			type:$(this).attr('method'),
			url:$(this).attr('action'),
			success:function(response){
				var action=response.split("|");
				const el=document.getElementById(action[0]);
				const notification=document.createElement(action[1]);
				notification.className=action[3];
				notification.innerHTML=action[4];
				$('form .not').remove();
				if(action[2]=='prepend'){
					el.insertBefore(notification,el.firstChild);
				}else if(action[2]=='append'){
					el.appendChild(notification);
				}else if(action[2]=='after'){
					el.after(notification);
				}else if(action[2]=='before'){
					el.before(notification);
				}else if(action[2]=='replace'){
					el.innerHTML=`<`+action[1]+` class="`+action[3]+`">`+action[4]+`</`+action[1]+`>`;
				}
				$('#'+formType+'-btn').html(formButtonText);
			}
		});
		return false;
	});
});
$(document).on(
	"click",
	".addCart",function(){
		var id=$(this).data('cartid');
		var cid=$(this).data('cartchoice');
		$.ajax({
			type:"POST",
			url:"core/add_cart.php",
			data:{
				id:id,
				cid:cid
			}
		}).done(
			function(msg){
				if(msg=='nomore'){
					alert('Purchase Limit Reached');
				} else {
					$('.cart').text(msg);
					if($('#cartage').length>0){
						$.ajax({
							type:"GET",
							url:"core/update_cartage.php"
						}).done(
							function(msg){
								$('#sidecart').removeClass('d-none');
								$('#sidecart').removeClass('jello');
								$('#sidecart').addClass('jello');
								var height=$('#cartage').height();
								$('#cartage').css('min-height',height);
								$('#cartage').fadeOut(250,function(){
	        				$(this).html(msg).slideDown(250);
	    					});
							}
						);
					}
				}
		});
	}
);
function clean0(timeto0){
	if(timeto0 < 10){
		var timeto0='0'+timeto0;
	}else{
		var timeto0=timeto0;
	}
	return timeto0;
}
function countdown(){
	var enddate=document.getElementById("countdownDateEnd").value;
	if(enddate!=''){
		var countDownDate=new Date(enddate).getTime();
		var x=setInterval(function(){
			var now=new Date().getTime();
			var distance=countDownDate - now;
			var days=Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours=Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes=Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds=Math.floor((distance % (1000 * 60)) / 1000);
			var days=clean0(days);
			var hours=clean0(hours);
			var minutes=clean0(minutes);
			var seconds=clean0(seconds);
			document.getElementById("countdownDays").innerHTML=days+"<small>Days</small>";
			document.getElementById("countdownHours").innerHTML=hours+"<small>Hours</small>";
			document.getElementById("countdownMinutes").innerHTML=minutes+"<small>Minutes</small>";
			document.getElementById("countdownSeconds").innerHTML=seconds+"<small>Seconds</small>";
			if(distance < 0){
				clearInterval(x);
				document.getElementById("countdowninfo").innerHTML="EXPIRED";
			}
		},1000);
	}else{
		document.getElementById("countdowninfo").innerHTML="EXPIRED";
	}
}
