SELECT ar.ref_ord_no, ar.article_no, ar.arid_qty, od.total_order_quantity, om.order_closed, om.trans_closed
FROM  `ar_invoice_master` am
INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
AND ar.article_no = od.article_no
WHERE ar.ref_ord_no <>  ''
AND am.invoice_date
BETWEEN  '2020-03-01'
AND  '2020-03-26'

SELECT A.ref_ord_no, A.article_no, SUM( ar_invoice_details.arid_qty ) 
FROM (

SELECT ar.ref_ord_no, ar.article_no, ar.arid_qty
FROM  `ar_invoice_master` am
INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
AND ar.article_no = od.article_no
WHERE ar.ref_ord_no <>  ''
AND am.invoice_date
BETWEEN  '2020-03-01'
AND  '2020-03-26'
)A
INNER JOIN ar_invoice_details ON ar_invoice_details.ref_ord_no = A.ref_ord_no
AND ar_invoice_details.article_no = A.article_no
GROUP BY A.ref_ord_no, A.article_no





















SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) > od.total_order_quantity,  "FULL DISPATCH",  "SHORT DISPATCH" ) AS 
STATUS , om.trans_closed, om.order_closed
FROM (

SELECT ar.ref_ord_no, ar.article_no, ar.arid_qty
FROM  `ar_invoice_master` am
INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
AND ar.article_no = od.article_no
WHERE ar.ref_ord_no <>  ''
AND am.invoice_date
BETWEEN  '2020-03-01'
AND  '2020-03-26'
AND am.cancel_invoice <>1
group by ar.ref_ord_no,ar.article_no
)A
INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
AND ar.article_no = A.article_no
LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
AND ar.article_no = od.article_no
GROUP BY A.ref_ord_no, A.article_no






SELECT A.ref_ord_no, A.article_no, SUM( ar.arid_qty ) AS dispatch_qty, od.total_order_quantity AS order_qty, IF( SUM( ar.arid_qty ) > od.total_order_quantity,  "COMPLETED",  if( (SUM(ar.arid_qty)< od.total_order_quantity) AND (om.trans_closed=1),"SHORT CLOSED","OPEN ORDER")) AS 
STATUS , om.trans_closed, om.order_closed
FROM (

SELECT ar.ref_ord_no, ar.article_no, ar.arid_qty
FROM  `ar_invoice_master` am
INNER JOIN ar_invoice_details ar ON am.ar_invoice_no = ar.ar_invoice_no
LEFT JOIN order_master om ON ar.ref_ord_no = om.order_no
LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
AND ar.article_no = od.article_no
WHERE ar.ref_ord_no <>  ''
AND am.invoice_date
BETWEEN  '2020-03-01'
AND  '2020-03-26'
AND am.cancel_invoice <>1
group by ar.ref_ord_no,ar.article_no
)A
INNER JOIN ar_invoice_details ar ON ar.ref_ord_no = A.ref_ord_no
AND ar.article_no = A.article_no
LEFT JOIN order_master om ON A.ref_ord_no = om.order_no
LEFT JOIN order_details od ON ar.ref_ord_no = od.order_no
AND ar.article_no = od.article_no
GROUP BY A.ref_ord_no, A.article_no