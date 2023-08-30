<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir='ltr' >
	<head profile=""><title>New Sales Order Entry</title>
		<meta http-equiv='X-UA-Compatible' content='IE=10'>
		<meta http-equiv='Content-type' content='text/html; charset=iso-8859-1'>
		<link href='css/default.css' rel='stylesheet' type='text/css'> 
		<script language="javascript" type="text/javascript" src="../company/0/js_cache/JsHttpRequest.js"></script>
		<script language="javascript" type="text/javascript" src="../company/0/js_cache/behaviour.js"></script>
		<script language="javascript" type="text/javascript" src="../company/0/js_cache/utils.js"></script>
		<script language="javascript" type="text/javascript" src="../company/0/js_cache/inserts.js"></script>
		<script language="javascript" type="text/javascript" src="../company/0/js_cache/date_picker.js"></script>
	</head> 
<body>
	<table class='callout_main' border='0' cellpadding='0' cellspacing='0'>
	<tr>
	<td colspan='2' rowspan='2'>
<table class='main_page' border='0' cellpadding='0' cellspacing='0'>
<tr>
<td>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr>
<td class='quick_menu'>
<table cellpadding='0' cellspacing='0' width='100%'><tr><td><div class='tabs'><a class='selected' href='../index.php?application=orders' accesskey='S'><u>S</u>ales</a><a class='menu_tab' href='../index.php?application=AP' accesskey='P'><u>P</u>urchases</a><a class='menu_tab' href='../index.php?application=stock' accesskey='I'><u>I</u>tems and Inventory</a><a class='menu_tab' href='../index.php?application=manuf' accesskey='M'><u>M</u>anufacturing</a><a class='menu_tab' href='../index.php?application=proj' accesskey='D'><u>D</u>imensions</a><a class='menu_tab' href='../index.php?application=GL' accesskey='B'><u>B</u>anking and General Ledger</a><a class='menu_tab' href='../index.php?application=system' accesskey='E'>S<u>e</u>tup</a></div></td></tr></table><table class='logoutBar'><tr><td class='headingtext3'>WEBASTICK PVT LTD | localhost | Administrator</td><td class='logoutBarRight'><img id='ajaxmark' src='../themes/default/images/ajax-loader.gif' align='center' style='visibility:hidden;' alt='ajaxmark'></td>  <td class='logoutBarRight'><a class='shortcut' href='../admin/display_prefs.php?'>Preferences</a>&nbsp;&nbsp;&nbsp;
  <a class='shortcut' href='../admin/change_current_user_password.php?selected_id=admin'>Change password</a>&nbsp;&nbsp;&nbsp;
<img src='../themes/default/images/login.gif' width='14' height='14' border='0' alt='Logout'>&nbsp;&nbsp;<a class='shortcut' href='../access/logout.php?'>Logout</a>&nbsp;&nbsp;&nbsp;</td></tr><tr><td colspan=3></td></tr></table></td></tr></table><center><table id='title'><tr><td width='100%' class='titletext'>New Sales Order Entry</td><td align=right></td></tr></table></center><div id='msgbox'></div><div id='_page_body'><form method='post' action='/frontaccounting/sales/sales_order_entry.php' >
<center><table class='tablestyle2' width='80%' cellpadding='2' cellspacing='0'>
<tr valign=top><td>
<table class='tablestyle_inner'>
<tr><td class='label'>Customer:</td><td nowrap><span id='_customer_id_sel'><select autocomplete='off'  name='customer_id' class='combo2' title='Select customer' ><option selected  value='1'>Beefeater&nbsp;-&nbsp;GBP</option>
<option   value='3'>Brezan&nbsp;-&nbsp;EUR</option>
<option   value='2'>Ghostbusters</option>
</select>
</span>
<input  type='submit' class='combo_select' style='border:0;background:url(../themes/default/images/button_ok.png) no-repeat;display:none;' aspect='fallback' name='_customer_id_update' value=' ' title='Select'> 
</td>
</tr>
<tr><td class='label'>Branch:</td><td><span id='_branch_id_sel'><select autocomplete='off'  name='branch_id' class='combo' title='Select customer branch' ><option   value='1'>Beefeater</option>
</select>
</span>
<input  type='submit' class='combo_select' style='border:0;background:url(../themes/default/images/button_ok.png) no-repeat;display:none;' aspect='fallback' name='_branch_id_update' value=' ' title='Select'> 
</td>
</tr><tr><td class='label'>Reference:</td><td><input  type="text" name="ref" size="16" maxlength="18" value="6" title='Reference number unique for this document type' ></td>
</tr>
</table>
<input type="hidden" name="cart_id" value="570cc4593eb4a"></td><td style='border-left:1px solid #cccccc;' >
<table class='tablestyle_inner'>
<tr><td class='label'>Current Credit:</td><td ><a target='_blank' href='../sales/inquiry/customer_inquiry.php?customer_id=1' onclick="javascript:openWindow(this.href,this.target); return false;" >1,000.00</a></td>
</tr>
<tr><td class='label'>Customer Discount:</td><td >0%</td>
</tr>
</table>
</td><td style='border-left:1px solid #cccccc;' >
<table class='tablestyle_inner'>
<tr>
<td class='label'>Payment:</td>
<td><span id='_payment_sel'><select autocomplete='off'  name='payment' class='combo' title='' ><option   value='4'>Cash Only</option>
<option   value='1'>Due 15th Of the Following Month</option>
<option   value='2'>Due By End Of The Following Month</option>
<option selected  value='3'>Payment due within 10 days</option>
</select>
</span>
<input  type='submit' class='combo_select' style='border:0;background:url(../themes/default/images/button_ok.png) no-repeat;display:none;' aspect='fallback' name='_payment_update' value=' ' title='Select'> 
</td>
</tr>
<tr><td class='label'>Price List:</td><td><span id='_sales_type_sel'><select autocomplete='off'  name='sales_type' class='combo' title='' ><option   value='1'>Retail</option>
<option selected  value='2'>Wholesale</option>
</select>
</span>
<input  type='submit' class='combo_select' style='border:0;background:url(../themes/default/images/button_ok.png) no-repeat;display:none;' aspect='fallback' name='_sales_type_update' value=' ' title='Select'> 
</td>
</tr>
</table>
</td><td style='border-left:1px solid #cccccc;' >
<table class='tablestyle_inner'>
<tr><td class='label'>Order Date:</td><td><input type="text" name="OrderDate" class="date active" aspect="cdate" style="color:#FF0000" size="10" maxlength="12" value="12/31/2014" title='Date of order receive' > <a tabindex='-1' href="javascript:date_picker(document.getElementsByName('OrderDate')[0]);">	<img src='../themes/default/images/cal.gif' style='vertical-align:middle;padding-bottom:4px;width:16px;height:16px;border:0;' alt='Click Here to Pick up the date'></a>
</td>
</tr>
</table>
</td></tr>
</table></center>
<br><center><table class='tablestyle' width='80%' cellpadding='10' cellspacing='0'>
<tr><td><center><span class='headingtext'>Sales Order Items</span></center>
<div id='items_table'><center><table class='tablestyle' width='90%' cellpadding='2' cellspacing='0'>
<tr>
<td class='tableheader' >Item Code</td>
<td class='tableheader' >Item Description</td>
<td class='tableheader' >Quantity</td>
<td class='tableheader' >Unit</td>
<td class='tableheader' >Price before Tax</td>
<td class='tableheader' >Discount %</td>
<td class='tableheader' >Total</td>
<td class='tableheader' ></td>
</tr>
<tr class='evenrow'>
<td><input  type='text' name='_stock_id_edit' id='_stock_id_edit' size='15' maxlength='255' value='' class='combo' rel='stock_id' autocomplete='off' title=''>
<input  type='submit' class='combo_submit' style='border:0;background:url(../themes/default/images/locate.png) no-repeat;display:none;' aspect='fallback' name='_stock_id_button' value=' ' title='Set filter'> 
</td><td><span id='_stock_id_sel'><select autocomplete='off'  name='stock_id' class='combo' title='' rel='_stock_id_edit'><optgroup label='Components'>
<option   value='102'>17inch VGA Monitor</option>
<option   value='103'>32MB VGA Card</option>
<option   value='104'>52x CD Drive</option>
</optgroup><optgroup label='Services'>
<option   value='201'>Assembly Labour</option>
</optgroup><optgroup label='Systems'>
<option   value='3400'>P4 Business System</option>
</optgroup></select>
</span>
<input  type='submit' class='combo_select' style='border:0;background:url(../themes/default/images/button_ok.png) no-repeat;display:none;' aspect='fallback' name='_stock_id_update' value=' ' title='Select'> 
</td><td align='right'><input class='amount' type="text" name="qty" size="15" maxlength="15" dec="0" value="1"></td>
<td  id='units'>each</td>
<td align='right'><input class='amount' type="text" name="price" size="15" maxlength="15" dec="2" value="21.28"></td>
<td align='right'><input class='amount' type="text" name="Disc" size="7" maxlength="12" dec="1" value="0.0"></td>
<td nowrap align=right  id='line_total'>21.28</td>
<td colspan=2 align='center'><button class="ajaxsubmit" type="submit" name="AddItem"  id="AddItem" value="Add Item" title='Add new item to document'><span>Add Item</span></button>
</td>
</tr>
<tr>
<td colspan=6 align=right>Shipping Charge</td>
<td align='right'><input class='amount' type="text" name="freight_cost" size="7" maxlength="12" dec="2" value="0.00"></td>
<td colspan=2></td>
</tr>
<tr><td colspan=6 align=right>Sub-total</td>
<td align=right>0.00</td>
<td colspan=2></td></tr>
<tr>
<td colspan=6 align=right>Amount Total</td>
<td align=right>0.00</td>
<td colspan=2 align='center'><button class="ajaxsubmit" type="submit" name="update"  id="update" value="Update" title='Refresh'><span>Update</span></button>
</td>
</tr>
</table></center>
</div></td></tr><tr><td><div id='delivery'><center><span class='headingtext'>Order Delivery Details</span></center>
<center><table class='tablestyle2' width='90%' cellpadding='2' cellspacing='0'>
<tr valign=top><td>
<table class='tablestyle_inner'>
<tr><td class='label'>Deliver from Location:</td><td><span id='_Location_sel'><select autocomplete='off'  name='Location' class='combo' title='' ><option selected  value='DEF'>Default</option>
</select>
</span>
<input  type='submit' class='combo_select' style='border:0;background:url(../themes/default/images/button_ok.png) no-repeat;display:none;' aspect='fallback' name='_Location_update' value=' ' title='Select'> 
</td>
</tr>
<tr><td class='label'>Required Delivery Date:</td><td><input type="text" name="delivery_date" class="date"  size="10" maxlength="12" value="01/01/2015" title='Enter Valid until Date' > <a tabindex='-1' href="javascript:date_picker(document.getElementsByName('delivery_date')[0]);">	<img src='../themes/default/images/cal.gif' style='vertical-align:middle;padding-bottom:4px;width:16px;height:16px;border:0;' alt='Click Here to Pick up the date'></a>
</td>
</tr>
<tr><td class='label'>Deliver To:</td><td><input  type="text" name="deliver_to" size="40" maxlength="40" value="Beefeater Ltd." title='Additional identifier for delivery e.g. name of receiving person'></td>
</tr>
<tr><td class='label'>Address:</td><td><textarea name='delivery_address' cols='35' rows='5' title='Delivery address. Default is address of customer branch'>Address 1
Address 2
Address 3</textarea></td>
</tr>
</table>
</td><td style='border-left:1px solid #cccccc;' >
<table class='tablestyle_inner'>
<tr><td class='label'>Contact Phone Number:</td><td><input  type="text" name="phone" size="25" maxlength="25" value="" title='Phone number of ordering person. Defaults to branch phone number'></td>
</tr>
<tr><td class='label'>Customer Reference:</td><td><input  type="text" name="cust_ref" size="25" maxlength="25" value="" title='Customer reference number for this order (if any)'></td>
</tr>
<tr><td class='label'>Comments:</td><td><textarea name='Comments' cols='31' rows='5'></textarea></td>
</tr>
<tr><td class='label'>Shipping Company:</td><td><span id='_ship_via_sel'><select autocomplete='off'  name='ship_via' class='combo' title='' ><option selected  value='1'>Default</option>
</select>
</span>
</td>
</tr>
</table>
</td></tr>
</table></center>
<br></div></td></tr></table></center>
<br><center><button class="ajaxsubmit" type="submit" aspect='default'  name="ProcessOrder"  id="ProcessOrder" value="Place Order" title='Check entered data and save document'><img src='../themes/default/images/ok.gif' height='12' alt=''><span>Place Order</span></button>
&nbsp;&nbsp;<button class="ajaxsubmit" type="submit" name="CancelOrder"  id="CancelOrder" value="Cancel Order" title='Cancels document entry or removes sales order when editing an old document'><span>Cancel Order</span></button>
</center><input type="hidden" name="_focus" value="customer_id"><input type="hidden" name="_modified" value="0"><input type="hidden" name="_token" value="2fd45e63dfcd23f69f46762f7882246bb037f3dc0c4c20bc5d561f7f2826f12f"></form>
<center><center><table width='20%' cellpadding='2' cellspacing='0'>
<tr>
<td align=center><a href='javascript:goBack();'>Back</a></td>
</tr>
</table></center>
</center><br></div></td></tr></table>
<table class='bottomBar2'>
<tr><td class='bottomBarCell'>04/12/2016 | 11:48 am</td>
<td id='hotkeyshelp'>F2 - Customers; F3 - Branches; F4 - Items</td></tr></table>
</td></tr> </table>
<table align='center' id='footer'>
<tr>
<td align='center' class='footer'><a target='_blank' href='http://frontaccounting.com' tabindex='-1'><font color='#ffffff'>FrontAccounting 2.3.25 - Theme: default - </font></a></td>
</tr>
<tr>
<td align='center' class='footer'><a target='_blank' href='http://frontaccounting.com' tabindex='-1'><font color='#ffff00'>FrontAccounting</font></a></td>
</tr>
</table><br><br>
<script type='text/javascript'>
		_focus = 'customer_id';
		_validate = [  ];
		var editors = { "113": [ "..\/sales\/manage\/customers.php?debtor_no=", "customer_id", "900", "500" ], "114": [ "..\/sales\/manage\/customer_branches.php?SelectedBranch=", "branch_id", "900", "700" ], "115": [ "..\/inventory\/manage\/items.php?stock_id=", "stock_id", "800", "600" ] };
	</script>
<script type="text/javascript"><!--
_validate._processing=null;_validate._processing='Entered data has not been saved yet.\nDo you want to abandon changes?';function openWindow(url, title)
{
 var left = (screen.width - 900) / 2;
 var top = (screen.height - 500) / 2;
 return window.open(url, title, 'width=900,height=500,left='+left+',top='+top+',screenX='+left+',screenY='+top+',status=no,scrollbars=yes');
}
_validate.CancelOrder=function(){ return confirm('You are about to void this Document.\nDo you want to continue?');};
var user = {
theme: '../themes/default/',
loadtxt: 'Requesting data...',
date: '04/12/2016',
datesys: 0,
datefmt: 0,
datesep: '/',
ts: ',',
ds: '.',
pdec : 2}

--></script>
</body></html>
