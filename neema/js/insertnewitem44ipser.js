// JavaScript Document// JavaScript Document
function insertitem4()
{
	if(document.form1.services.value=="")
	{
		alert("Please enter services name");
		document.form1.services.focus();
		return false;
	}
	if(document.form1.rate3.value=="")
	{
		alert("Please enter rate");
		document.form1.rate3.focus();
		return false;
	}
	if(document.form1.servicesfree.value=="")
	{
		alert("Please enter free status");
		document.form1.servicesfree.focus();
		return false;
	}
	if(document.form1.quantityser3.value=="")
	{
		alert("Please enter Quanitiy status");
		document.form1.quantityser3.focus();
		return false;
	}
	if(document.form1.totalservice3.value=="")
	{
		alert("Please enter Total status");
		document.form1.totalservice3.focus();
		return false;
	}
	
	var varservicesfree = document.getElementById("servicesfree").value;
	
	if(varservicesfree == "no")
	{
		varservicesfreename = 'No';
	}
	if(varservicesfree == "yes")
	{
		varservicesfreename = 'Yes';
	}
	
	
	var varSerialNumber31 = document.getElementById("serialnumber3").value;
	var varServices = document.getElementById("services").value;
	var varserRate = document.getElementById("rate3").value;
	var varquantityser3 = document.getElementById("quantityser3").value;
	var vartotalservice3 = document.getElementById("totalservice3").value;
	
	var varSerialNumber3=parseInt(varSerialNumber31)+31;
	
	var m = varSerialNumber3;
	//alert(m);
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+m+"";
	
	var td1 = document.createElement ('td');
	td1.id = "services"+m+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber3"+m+"";
	text1.name = "serialnumber3"+m+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber3;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "services"+m+"";
	text11.name = "services[]"+m+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "25";
	text11.value = varServices;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	var td88 = document.createElement ('td');
	td88.id = "quantityser3"+m+"";
	td88.align = "left";
	td88.valign = "top";
	td88.style.backgroundColor = "#FFFFFF";
	td88.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text88 = document.createElement ('input');
	text88.id = "quantityser3"+m+"";
	text88.name = "quantityser3[]"+m+"";
	text88.type = "text";
	text88.size = "8";
	text88.value = varquantityser3;
	text88.readOnly = "readonly";
	text88.style.backgroundColor = "#FFFFFF";
	text88.style.border = "0px solid #001E6A";
	text88.style.textAlign = "left";
	td88.appendChild (text88);
	tr.appendChild (td88);
	
	var td8 = document.createElement ('td');
	td8.id = "rate3"+m+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate3"+m+"";
	text8.name = "rate3[]"+m+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varserRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td888 = document.createElement ('td');
	td888.id = "totalservice3"+m+"";
	td888.align = "left";
	td888.valign = "top";
	td888.style.backgroundColor = "#FFFFFF";
	td888.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text888 = document.createElement ('input');
	text888.id = "totalservice3"+m+"";
	text888.name = "totalservice3[]"+m+"";
	text888.type = "text";
	text888.size = "8";
	text888.value = vartotalservice3;
	text888.readOnly = "readonly";
	text888.style.backgroundColor = "#FFFFFF";
	text888.style.border = "0px solid #001E6A";
	text888.style.textAlign = "left";
	td888.appendChild (text888);
	tr.appendChild (td888);
	
	var td9 = document.createElement ('td');
	td9.id = "servicesfree"+m+"";
	td9.align = "left";
	td9.valign = "top";
	td9.style.backgroundColor = "#FFFFFF";
	td9.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text9 = document.createElement ('input');
	text9.id = "servicesfree"+m+"";
	text9.name = "servicesfree[]"+m+"";
	text9.type = "text";
	text9.size = "8";
	text9.value = varservicesfreename;
	text9.readOnly = "readonly";
	text9.style.backgroundColor = "#FFFFFF";
	text9.style.border = "0px solid #001E6A";
	text9.style.textAlign = "left";
	td9.appendChild (text9);
	tr.appendChild (td9);
	
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete3"+m+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete3"+m+"";
	text11.name = "btndelete3"+m+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick3(m,vartotalservice3); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow3').appendChild (tr);
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber3").value = parseInt(m) + 1;
		if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	totalamount3=document.getElementById('total3').value;
	}
	
	
	totalamount3=parseInt(totalamount3) + parseInt(vartotalservice3);
	//alert(totalamount3);
	document.getElementById("total3").value=totalamount3.toFixed(2);
	
	
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	
	
	grandtotal= parseInt(totalamount1)+parseInt(totalamount2)+parseInt(totalamount3);
	
	document.getElementById("total4").value=grandtotal.toFixed(2);
	
	var varLab = document.getElementById("services").value = "";
	var varRate = document.getElementById("rate3").value = "";
	var varquantityser3 = document.getElementById("quantityser3").value='';
	document.getElementById("totalservice3").value='';
	document.getElementById("services").focus();
	
	window.scrollBy(0,5); 
	return true;

}