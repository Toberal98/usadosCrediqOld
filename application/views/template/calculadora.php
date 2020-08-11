<script>

////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNCION 1
// popup(url,nombre, barra,menu,herramientas,resizable,directorio,izquierda,arriba,alto,ancho)
// ESTA FUNCION SE ENCARGA DE ABRIR UNA VENTANA FLOTANTE A PARTIR DE PARAMETROS ENVIADOS POR EL 
// USUARIO 
/////////////////////////////////////////////////////////////////////////////////////////////////////
function popup(url,nombre, barra,menu,herramientas,resizable,directorio,izquierda,arriba,alto,ancho)
{
window.open(url,nombre,"location=0,scrollbars="+barra+",menubar="+menu+",toolbar="+herramientas+",status=0,resizable="+resizable+",directories="+directorio+",left="+izquierda+",top="+arriba+",width="+ancho+",height="+alto+"");
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNCION 2
// FormatCurrency(PARAM1, PARAM2)
// ESTA FUNCION SE ENCARGA DE ASIGNAR FORMATO DE MONEDA AL VALOR ESPECIFICADO 
// USUARIO 
/////////////////////////////////////////////////////////////////////////////////////////////////////

function FormatCurrency(WholeNumber,TotalDecs) {

var Work= WholeNumber.toString();
if (Work.indexOf('.')==-1)
return "$"+Comma(WholeNumber)+".00";

Work = Work.split('.');
var FirstNum = Work[0];
var n2 = Work[1];
var n3 = n2.substring(TotalDecs,TotalDecs+1)
var SecondNum= n2.substring(0,TotalDecs);
if (Number(n3) >=5 && Number(SecondNum) <99) {
SecondNum = Number(SecondNum) +1;
} else if (Number(n3)>=5 && Number(SecondNum)==99) {
FirstNum=Number(FirstNum)+1;
SecondNum="00";
}
if (SecondNum.length==0) 
SecondNum="00";
else if (SecondNum.length==1)
SecondNum+="0"

return "$" + Comma(FirstNum) + "." + SecondNum;
}


////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNCION 3
// Comma(PARAM)
// ESTA FUNCION SE ENCARGA DAR FORMATO DE DECIMALES A UN VALOR DADO
// USUARIO 
/////////////////////////////////////////////////////////////////////////////////////////////////////


function Comma(number) {
number = '' + number;
if (number.length > 3) {
var mod = number.length % 3;
var output = (mod > 0 ? (number.substring(0,mod)) : '');

for (i=0 ; i < Math.floor(number.length / 3); i++) {
if ((mod == 0) && (i == 0))
output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
else
output+= ',' + number.substring(mod + 3 * i, mod + 3 * i + 3);
}
return (output);
}
else 
return number;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNCION 4
// format(PARAM1, PARAM2)
// ESTA FUNCION SE ENCARGA DAR FORMATO DE DECIMALES A UN VALOR DADO
// USUARIO 
/////////////////////////////////////////////////////////////////////////////////////////////////////

function format(num,decimal) {
  var count = decimal;
  var result = "";
  if(decimal) { result = "."; }
  while(count--) { num = num*10; }
  num = Math.round(num) + "";
  var len = num.length;
  count = decimal;
  while(count--) { result = result + num.charAt(len-count-1); }
  for(var x=len-decimal-1,count=0;x>=0;x--) {
    result = num.charAt(x) + result;
    if(!(++count%3) && x > 0) { result = "," + result; } // add commas
  }
  return(result);

}

////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNCION 5
// convertYears()
// ESTA FUNCION SE ENCARGA DAR FORMATO EN AÑOS Y MESES A UNA DATO INGRESADO EN MESES 
// EJEMPLO: INGRESA 39 MESE Y LA FUNCION DEVUELVE "3 AÑOS Y 3 MESES
/////////////////////////////////////////////////////////////////////////////////////////////////////

function convertYears(time) {
  var convertY = Math.floor(time/12);
  var convertM = Math.ceil(time%12);	//math.ceil
  if(convertM==12) {
    convertY++;
    convertM=0;
  }
  unitY = convertY>1 ? " años" : " año";
  unitM = convertM>1 ? " meses" : " mes";
  if(convertY>=1 && convertM>=1) { var x= convertY + unitY + " y " + convertM + unitM; }
  else if(convertY>=1 && convertM==0) { var x= convertY + unitY; }
  else if(convertY==0 && convertM>=1) { var x= convertM + unitM; }
  return x;
}


function year_invert(){
//form1.calculate2.style.visibility='hidden';
form1.result.value = "";
//form1.resultint.value = "";

if (form1.periodo_tipo[0].checked){
	form1.years.value = ((form1.Year1.value/form1.perioricidad.value));
	}
else {
	form1.years.value = ((form1.Year1.value));
}

}
function year(){
//form1.calculate2.style.visibility='hidden';
form1.result.value = "";
//form1.resultint.value = "";

if (form1.periodo_tipo[0].checked){
	form1.years.value = ((form1.Year1.value*form1.perioricidad.value));
	}
else {
	form1.years.value = ((form1.Year1.value));
}

}
function ayuda(pag){
	popup(pag,"ventana", 1,0,0,"no",0,50,50,300,300);
}
function calc(info) {
  var exit = 0;
  var count = 3; 
  var p = validate(form1.principal.value);
  if(form1.rate.value.length==0) { form1.rate.value=0; }
  var i = validate(form1.rate.value);
  var y = validate(form1.years.value);
  for(var x=0; x<count; x++) { // REDONDEA LOS ERRORES 
  form1.elements[x].value = validate(form1.elements[x].value,1)
  }
  for(var x=0,exit=0;x<count && !exit;x++) {
    exit = (form1.elements[x].value == "ERROR" || form1.elements[x].value == "VACIO") ? 1 : 0;
  }

  if(!exit) { // second round of error checking
    form1.rate.value = (i<100) ? form1.rate.value : "ERROR"
    form1.years.value = (y>0) ? form1.years.value : "ERROR"
    for(var x=0,exit=0;x<count && !exit;x++) {
     exit = (form1.elements[x].value == "ERROR" || form1.elements[x].value == "VACIO") ? 1 : 0;
    }
  }
  if(!exit) {
    form1.principal.value = p;
    form1.rate.value = i;
    result = "";
    if(i==0) {
     // var pmt = e/(y); 
	 alert('El interes no debe ser 0');
	 return false;
    }
    else {
	  i = (i/100)/form1.perioricidad.value;
	  form1.tasa_mes.value = i;

  	
	  var pmt = (p*i)/(1-Math.pow((1+i),(-1*(y)))); // perform calculation

	  var inte = (pmt*y)-p;
    }


//        <option value = 12> Mensual</option>
//          <option value = 4> Trimestral</option>
//          <option value = 2> Semestral</option>
//          <option value = 1> Anual</option>

if (form1.perioricidad.value == 12){
	perioricidad_name = "Mensual";
}
if (form1.perioricidad.value == 4){
	perioricidad_name = "Trimestral";
}
if (form1.perioricidad.value == 2){
	perioricidad_name = "Semestral";
}
if (form1.perioricidad.value == 1){
	perioricidad_name = "Anual";
}
    form1.result.value = "El valor aproximado de su cuota "+ perioricidad_name +" es : $"+format(pmt,2)+" ";
	//form1.resultint.value = "El Interes Total es : $"+format(inte,2)+"";
	form1.cuota.value = pmt;
  }
  else {
    form1.result.value = "Corregir campos con "+unescape("%22")+"ERROR"+unescape("%22")+" or "+unescape("%22")+"VACIO"+unescape("%22")+".";
  }
  //form1.calculate2.style.visibility='visible';
  form1.help1.style.visibility='visible';
  
}


function calc2(info) {
	 //window.open("GSC-FIC15-2.html");
	 popup("/","ventana", 1,0,0,"no",0,50,50,450,450);


}



function convertYears(time) {
  var convertY = Math.floor(time/12);
  var convertM = Math.ceil(time%12);	//math.ceil
  if(convertM==12) {
    convertY++;
    convertM=0;
  }
  unitY = convertY>1 ? " años" : " año";
  unitM = convertM>1 ? " meses" : " mes";
  if(convertY>=1 && convertM>=1) { var x= convertY + unitY + " y " + convertM + unitM; }
  else if(convertY>=1 && convertM==0) { var x= convertY + unitY; }
  else if(convertY==0 && convertM>=1) { var x= convertM + unitM; }
  return x;
}

function format(num,decimal) {
  var count = decimal;
  var result = "";
  if(decimal) { result = "."; }
  while(count--) { num = num*10; }
  num = Math.round(num) + "";
  var len = num.length;
  count = decimal;
  while(count--) { result = result + num.charAt(len-count-1); }
  for(var x=len-decimal-1,count=0;x>=0;x--) {
    result = num.charAt(x) + result;
    if(!(++count%3) && x > 0) { result = "," + result; } // add commas
  }
  return(result);
}

function validate(entry,errorchk) {
  var validlist = "1234567890";
  var number = "";
  var period = 1; // decimal point can only appear once
  if(errorchk && entry.length == 0) { return("VACIO"); }
  for(var x=0; x < entry.length; x++) {
    var datum = entry.charAt(x);
    if(validlist.indexOf(datum) != -1) { number += datum; 
	}
    else if(datum == "." && period) {
      number += datum;
      period = 0;
    }
    else {
      if(errorchk) {
      if(datum == "," || datum == "%" || datum == unescape("%24")) {
      if((datum=="%" && x != entry.length-1) || (datum==unescape("%24") && x != 0)) return("ERROR");
    }
    else return("ERROR");
    }
  }
  }
  if(number == "") { return(0); }
  else if(errorchk) return(entry);
  else { return(parseFloat(number)); }
}

</script>
<!--link href="../../../public/css/template.css" rel="stylesheet" type="text/css" /-->



<FORM METHOD=POST name="form1">
    <INPUT TYPE=HIDDEN NAME="cuota" value=0>
    <INPUT TYPE=HIDDEN NAME="tasa_mes" value=0>
<div style="color:#ed1b24;">Calcule la cuota de su crédito</div>
 <div class="separator"></div>
<div class="labels l_large left text-right">
	<label for="">Valor del Veh&iacute;culo: </label>
    <label for="">Tasa de inter&eacute;s anual(%) :</label>
	<label for="">Número de Cuotas: </label>
    
	<label for="">Periodicidad de pagos: </label>
	<label for="">Resultado.</label>
</div>

<div class="inputs left">
	<input type=TEXT class="i_medium" name="principal" value="<?=$monto;?>" size=40 maxlength=15  >

    <input type=TEXT name="rate" value="" size=20 maxlength=6 class="i_medium">
        
    <input type="hidden" name="periodo_tipo" value = "anios"  onChange = "year()">
    <input type="hidden" name="periodo_tipo" value = "cuotas" checked = "year_invert()">
       
    <input type=TEXT name="Year1"  value="" size=20 maxlength=3 onchange="year()" class="i_medium">
       
    <input type=HIDDEN name="years" value="" size=20 maxlength=3 readonly>
        
<SELECT NAME="perioricidad" onchange="year()" style="width:135px;"  >
          <option value = 12> Mensual</option>
          <option value = 4> Trimestral</option>
          <option value = 2> Semestral</option>
          <option value = 1> Anual</option>
        </SELECT>
<textarea name="result" rows="2" cols="23" style="width:130px; margin-top:5px; " ></textarea>

	  <input type="button" onClick="calc(this.form1);" value="Calcular&nbsp;&nbsp;&nbsp;" class="large_boton" style="border:none;">
</div>
<div class="clear_0"></div>


        

        

        

      <div class="separator"></div>
		<span class="nota">Nota: &nbsp; La cuota no incluye seguros y los valores de la cuota dependen de las condiciones contractuales de cada cliente. 
        Este cálculo es únicamente ilustrativo. Si desea tener una cuota acorde a sus necesidades lo invitamos a llenar la solicitud
        o acercarse a nuestras oficinas en donde lo atenderá de forma personalizada uno de nuestros asesores.</span>
	<div class="separator"></div>
</form>