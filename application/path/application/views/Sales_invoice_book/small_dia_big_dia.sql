SELECT 
MONTH(ar_invoice_master.invoice_date) as month_no,
YEAR( ar_invoice_master.invoice_date ) as sales_year, 
MONTHNAME( ar_invoice_master.invoice_date) as sales_month, 

SUM(if(ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM', ar_invoice_details.arid_qty /100,0) )AS SMALL_DIA,



SUM(if(ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM', ar_invoice_details.arid_qty /100,0 ))AS BIG_DIA,


SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM', ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM', ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate*ar_invoice_details.arid_qty/100, 0 ) )  AS SMALL_DIA_VALUE
					
FROM  ar_invoice_master
INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
WHERE ar_invoice_master.archive <>1
AND ar_invoice_master.cancel_invoice <>1
AND ar_invoice_master.inv_type IN ( 1, 2, 8, 11 ) 
AND ar_invoice_details.sleeve_dia<>''

GROUP BY 
MONTH( ar_invoice_master.invoice_date ), 
YEAR( ar_invoice_master.invoice_date)
					
ORDER BY 
ar_invoice_master.invoice_date desc, 
MONTH( ar_invoice_master.invoice_date ) asc

LIMIT 0,150







SELECT 
MONTH(ar_invoice_master.invoice_date) as month_no,
YEAR( ar_invoice_master.invoice_date ) as sales_year, 
MONTHNAME( ar_invoice_master.invoice_date) as sales_month, 

SUM(if(ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM', ar_invoice_details.arid_qty /100,0) )AS SMALL_DIA,

SUM(if(ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM', ar_invoice_details.arid_qty /100,0 ))AS BIG_DIA,

SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM', ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_details.sleeve_dia='19 MM' OR ar_invoice_details.sleeve_dia='22 MM' OR ar_invoice_details.sleeve_dia='22.6 MM' OR ar_invoice_details.sleeve_dia='25 MM' OR ar_invoice_details.sleeve_dia='30 MM', ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS SMALL_DIA_VALUE,


SUM( IF( ar_invoice_master.for_export<>1 AND ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM', ar_invoice_details.arid_qty/100*ar_invoice_details.selling_price/100, 0 ) )+SUM( IF( ar_invoice_master.for_export=1 AND ar_invoice_details.sleeve_dia='35 MM' OR ar_invoice_details.sleeve_dia='40 MM' OR ar_invoice_details.sleeve_dia='50 MM', ar_invoice_details.calc_sell_price*ar_invoice_master.exchange_rate/100*ar_invoice_details.arid_qty/100, 0 ) )  AS BIG_DIA_VALUE

					
FROM  ar_invoice_master
INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
WHERE ar_invoice_master.archive <>1
AND ar_invoice_master.cancel_invoice <>1
AND ar_invoice_master.inv_type IN ( 1, 2, 8,11 ) 
AND ar_invoice_details.sleeve_dia<>''

GROUP BY 
MONTH( ar_invoice_master.invoice_date ), 
YEAR( ar_invoice_master.invoice_date)
					
ORDER BY 
ar_invoice_master.invoice_date desc, 
MONTH( ar_invoice_master.invoice_date ) asc

LIMIT 0,150





