// JavaScript Document
function insertitem2()
{

	if(document.form1.lab.value=="")
	{
		alert("Please enter laboratory name");
		document.form1.lab.focus();
		return false;
	}
	
	if(document.form1.rate5.value=="")
	{
		alert("Please enter rate");
		document.form1.rate5.focus();
		return false;
	}
	var varSerialNumber11 = document.getElementById("serialnumber17").value;
	//alert(varSerialNumber11);
	var varLab = document.getElementById("lab").value;
	var varlabRate = document.getElementById("rate5").value;
	var varLabdiscount = document.getElementById("labdiscount").value;
	var varLabdiscountamount = document.getElementById("labdiscountamount").value;
	var varSerialNumber1=parseInt(varSerialNumber11)+51;
	var j = varSerialNumber1;
	//alert(j);
	var tr = document.createElement ('TR');
	tr.id = "idTR"+j+"";
	tr.size = "40";
	
	var td1 = document.createElement ('td');
	td1.id = "lab"+j+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber1"+j+"";
	text1.name = "serialnumber1"+j+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber1;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "lab"+j+"";
	text11.name = "lab[]"+j+"";
	text11.type = "text";
	text11.align = "left";
	text11.size = "50";
	text11.value = varLab;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";

	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	var td81 = document.createElement ('td');
	td81.id = "TDdisc"+j+"";
	td81.align = "left";
	td81.valign = "top";
	td81.style.backgroundColor = "#FFFFFF";
	td81.style.border = "0px solid #001E6A";
	//var text81 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text81 = document.createElement ('input');
	text81.id = "labdiscountamount"+j+"";
	text81.name = "labdiscountamount[]"+j+"";
	text81.type = "hidden";
	text81.size = "6";
	text81.value = varLabdiscountamount;
	text81.readOnly = "readonly";
	text81.style.backgroundColor = "#FFFFFF";
	text81.style.border = "0px solid #001E6A";
	text81.style.textAlign = "left";
	td81.appendChild (text81);
	var text82 = document.createElement ('input');
	text82.id = "labdiscount"+j+"";
	text82.name = "labdiscount[]"+j+"";
	text82.type = "text";
	text82.size = "6";
	text82.value = varLabdiscount;
	text82.readOnly = "readonly";
	text82.style.backgroundColor = "#FFFFFF";
	text82.style.border = "0px solid #001E6A";
	text82.style.textAlign = "left";
	td81.appendChild (text82);
	tr.appendChild (td81);
	
	
	var td8 = document.createElement ('td');
	td8.id = "rate5"+j+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "rate5"+j+"";
	text8.name = "rate5[]"+j+"";
	text8.type = "text";
	text8.size = "8";
	text8.value = varlabRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete1"+j+"";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete1"+j+"";
	text11.name = "btndelete1"+j+"";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick1(j,varlabRate); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);

    document.getElementById ('insertrow1').appendChild (tr);
	
	
	
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber17").value = parseInt(j) + 1;
	
		if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	
	totalamount1=parseInt(totalamount1) + parseInt(varlabRate);
	document.getElementById("total1").value=totalamount1.toFixed(2);
	
	
	if(document.getElementById('total2').value=='')
	{
	 totalamount2=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount3=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount3=document.getElementById('total3').value;
	}
	
	grandtotal= parseInt(totalamount1)+parseInt(totalamount2)+parseInt(totalamount3);
	
	
	document.getElementById("total4").value=grandtotal.toFixed(2);
	document.getElementById("subtotal").value=grandtotal.toFixed(2);
	 //alert('h');
		document.getElementById("totalamount").value=grandtotal.toFixed(2);
		document.getElementById("tdShowTotal").innerHTML=grandtotal.toFixed(2);
		document.getElementById("nettamount").value=grandtotal.toFixed(2);
		document.getElementById("cashamount").value=grandtotal.toFixed(2);
		document.getElementById("creditamount").value=grandtotal.toFixed(2);
		document.getElementById("chequeamount").value=grandtotal.toFixed(2);
		document.getElementById("cardamount").value=grandtotal.toFixed(2);
		document.getElementById("onlineamount").value=grandtotal.toFixed(2);
	
	var varLab = document.getElementById("lab").value = "";
	var varRate = document.getElementById("rate5").value = "";
	var varLabdiscount = document.getElementById("labdiscount").value = "";
	var varLabdiscountamount = document.getElementById("labdiscountamount").value = "";
	document.getElementById("itemrate5").value = "";	
	
	
	document.getElementById("lab").focus();
	
	window.scrollBy(0,5); 
	return true;

}