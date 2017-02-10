document.getElementById('SN').onkeydown = function(e){
	kn = e.which;
	kr = /[0-9]/;
        if(kn>95 && kn<106) kn=kn-48;
	kc = String.toUpperCase(String.fromCharCode(kn));
	if(kn<47) return true;
	if(kr.test(kc))	this.value+=kc;
	return false;
	
}

document.getElementById('ST').onkeydown = function(e){
	
	kn = e.which;
	kr = /[A-Z0-9]/;
        if(kn>95 && kn<106) kn=kn-48;
	kc = String.toUpperCase(String.fromCharCode(kn));
	if(kn<47) return true;
	if(kr.test(kc)) this.value+=kc;
	
	return false;
	
}
