window.onload = function(){
	
	$('#cert_date_d').val('10');
	$('#cert_date_m').val('6');
	$('#cert_date_y').val('2016');
	setDefault("sex",2);
	$('#birthday_y').val('1999');
	$('#natio').val('1');
	$('#country').val('1');
	$('#inst_rank_id').val('1');
	$('#institution_id').val('1');
	$('#certificate_id').val('1');
	$('#cur_lang_id').val('1');
	$('#experience_id').val('1');
	$('#try_id').val('1');
	setDefault("hostel_id",2);
    
}

function setDefault(idElem, Value) {
	elem = (document.getElementById(idElem)) ? document.getElementById(idElem) : false;
	console.log(elem);
	if (elem)
		{
			elem.value = Value;

		}
}