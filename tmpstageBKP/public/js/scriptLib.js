// JavaScript Document
var numbers = '0123456789';
var numericKeys = '0123456789.';
var numericInteger='0123456789-';
var numericFloat='0123456789-.';
var smallDate='0123456789/';
var hourKeys='0123456789:';
var dateKeys = '0123456789./-';
var phoneKeys = '0123456789.+-()';
var emailKeys = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ._-@';
var er_email = /^(.+\@.+\..+)$/

function openWin(W,H,Page){
  window.open(Page,'_win' ,'width='+W+',height='+H+',top=5,left=50,scrollbars=yes,resizable=yes,toolbars=no,status=no');
}
function openWinName(W,H,Page,name){
  window.open(Page,name ,'width='+W+',height='+H+',top=10,left=250,scrollbars=yes,resizable=yes,toolbars=no,status=no');
}


/*funcion que se utiliza para limitar el maximo de caracteres de un textarea*/
  function textAreaLength(obj,num){
    if (obj.value.length >= num){
      obj.value = obj.value.substring(0,num);
    }
  }
/*funcion que valida que el caracter digitado se encuentre en una cadena determinada, si lo encuentra 
  se podra digitar dicho caracter, si no pues no se podra digitar.*/
  function validateKey(evt, validKeys){
	var charCode;
	if(evt.charCode){
		charCode=evt.charCode;
		if(!(validKeys.indexOf(String.fromCharCode(charCode)) >= 0)){
		    evt.preventDefault();
	    }
	}else{
		charCode=evt.keyCode;
		evt.returnValue=validKeys.indexOf(String.fromCharCode(charCode)) >= 0;
	}
	//var charCode = (evt.charCode ) ? evt.charCode : event.keyCode
  }

function concatenaHttp(pVar){
  if(pVar.value != ""){
    if(pVar.value.substring(0,7) != "http://"){
	  pVar.value="http://"+pVar.value;
	}
  }
}  