<style>
        #blink {
            transition: 0.5s;
        }
    </style>
<div class="record_form_design">

	<h3 class="ui top attached header">
  		SALES REPORT
	</h3>
	<div class="ui attached segment">
	<div class="ui equal width grid">
	
		<div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/sales_invoice_book/search');?>" target="_blank">SALES INVOICE REGISTER</a>
				<div class="sub header">Any Date | Detailed Report</div>
			</div>
		</h4>
	  </div>


	  <div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/big_dia_small_dia_wise_sales');?>" target="_blank">SALES BY BIG & SMALL DIAMETER</a>
				<div class="sub header">Month as Row | Diameter As Column</div>
			</div>
		</h4>
	  </div>
	  
	  <div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/print_type_wise_sales');?>" target="_blank">SALES BY PRINT TYPE</a>
				<div class="sub header">Month as Row | Print Type As Column</div>
			</div>
		</h4>
	  </div>

	  <div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/dia_wise_sales');?>" target="_blank">SALES BY DIAMETER</a>
				<div class="sub header">Dia as Row | Print Type As Column</div>
			</div>
		</h4>
	  </div>


	  <div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/top_customer_sales_diawise');?>" target="_blank">SALES BY TOP CUSTOMER</a>
				<div class="sub header">Customer as Row | Print & Dia as Column | Order By Quantity</div>
			</div>
		</h4>
	  </div>


	</div>

	<br/>
	<br/>
	<div class="ui equal width grid">

		<div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/sales_five_year_monthwise');?>" target="_blank">SALES 5 YEAR BY MONTHWISE</a>
				<div class="sub header">Month as Row | 5 Year As Column</div>
			</div>
		</h4>
	    </div>

	    <div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/sales_five_year_print_type_wise');?>" target="_blank">SALES 5 YEAR BY PRINT TYPE</a>
				<div class="sub header">Year As Row | Print Type As Column</div>
			</div>
		</h4>
	    </div>

	    <div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/dashboard_sales');?>" target="_blank">SALES DASHBOARD</a>
				<div class="sub header"></div>
			</div>
		</h4>
	  	</div>

	  	<div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/domestic_export_sales');?>" target="_blank">SALES DOMESTIC & EXPORT</a>
				<div class="sub header">Month as Row | Domestic/Export As Column</div>
			</div>
		</h4>
	  	</div>

	  
	  	<div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">

	  			<a href="<?php echo base_url('index.php/Sales_top_product');?>" target="_blank">SALES TOP PRODUCT</a>
	  			
				<div class="sub header">Customer as Row | Contribution As Column</div>
			</div>
		</h4>
	  	</div>


	  <div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/avg_dia');?>" target="_blank">SALES AVG DIA</a>
	  			<div class="ui green horizontal label" id="blink">NEW</div>
				<div class="sub header">Dia as Row | Quantity as Column</div>
			</div>
		</h4>
	  </div>

	</div>

	</div>
	
	<h3 class="ui top attached header">
  		ORDER REPORT
	</h3>

	<div class="ui attached segment">
		<div class="ui equal width grid">

			<div class="column ui label">
		  	<h4 class="ui image header">
		  		<i class="file outline icon"></i>
		  		<div class="content">
		  			<a href="<?php echo base_url('index.php/sales_order_book/search');?>" target="_blank">ORDER BOOK</a>
					<div class="sub header">Any Date | Detailed Report</div>
				</div>
			</h4>
		  	</div>

		  	<div class="column ui label">
		  	<h4 class="ui image header">
		  		<i class="file outline icon"></i>
		  		<div class="content">
		  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/print_type_wise_sales_order');?>" target="_blank">TOTAL ORDERS  RECEIVED BY PRINT TYPE</a>
					<div class="sub header">Month as Row | Print Type As Column</div>
				</div>
			</h4>
		  	</div>

		  	<div class="column ui label">
		  	<h4 class="ui image header">
		  		<i class="file outline icon"></i>
		  		<div class="content">
		  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/total_order_received_by_customer');?>" target="_blank">TOTAL ORDERS  RECEIVED BY CUSTOMER ON APPROVAL DATE</a>
		  			
					<div class="sub header">Customer as Row | Print Type As Column</div>
				</div>
			</h4>
		  	</div>

			
		  </div>
	</div>

	<h3 class="ui top attached header">
  		PENDING ORDER REPORT ON APPROVAL DATE
	</h3>

	<div class="ui attached segment">
		<div class="ui equal width grid">

			<div class="column ui label">
		  	<h4 class="ui image header">
		  		<i class="file outline icon"></i>
		  		<div class="content">
		  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/pending_sales_order_monthwise');?>" target="_blank">PENDING ORDERS BY PRINT TYPE</a>
					<div class="sub header">Month as Row | Print Type as Column</div>
				</div>
			</h4>
		  	</div>

		  	<div class="column ui label">
		  	<h4 class="ui image header">
		  		<i class="file outline icon"></i>
		  		<div class="content">
		  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/pending_sales_order_by_diameter');?>" target="_blank">PENDING ORDERS BY DIAMETER </a>
					<div class="sub header">Diameter as Column | Print Type as Column </div>
				</div>
			</h4>
		  	</div>

		  	<div class="column ui label">
		  	<h4 class="ui image header">
		  		<i class="file outline icon"></i>
		  		<div class="content">
		  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/pending_sales_order_by_customer');?>" target="_blank">PENDING ORDERS BY CUSTOMER </a>
					<div class="sub header">Customer as Row | Print Type as Column </div>
				</div>
			</h4>
		  	</div>

		  	<div class="column ui label">
		  	<h4 class="ui image header">
		  		<i class="file outline icon"></i>
		  		<div class="content">
		  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/pending_sales_order_on_delivery_date');?>" target="_blank">PENDING ORDERS BY DELIVERY DATE </a>
					<div class="sub header">Month as Row | Print Type as Column </div>
				</div>
			</h4>
		  	</div>

		  	

		</div>
	</div>

	<h3 class="ui top attached header">
  		PRODUCTION REPORT
	</h3>


	<div class="ui attached segment">
	 <div class="ui equal width grid">

	  	<div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/production_monthwise');?>" target="_blank">PRODUCTION</a>
				<div class="sub header">MOTHWISE BREAKUP,ANY DATE</div>
			</div>
		</h4>
	  	</div>

	  	<div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/trackmyorder');?>" target="_blank">SPRING PRODUCTION</a>
	  			
	  			<div class="ui red horizontal label">NEW</div>
				<div class="sub header">ORDER TRACKING,ANY DATE</div>
			</div>
		</h4>
	  	</div>

	 </div>
	</div>

	<h3 class="ui top attached header">
  		CAP REPORT
	</h3>


	<div class="ui attached segment">
	 <div class="ui equal width grid">

	  	<div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/cap_forecast_by_cap_code');?>" target="_blank">CAP FORECAST</a>
				<div class="sub header">CAP CODE,ANY DATE</div>
			</div>
		</h4>
	  	</div>

	  	<div class="column ui label">
	  	<h4 class="ui image header">
	  		<i class="file outline icon"></i>
	  		<div class="content">
	  			<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/cap_forecast_by_customer');?>" target="_blank">CAP FORECAST</a>
				<div class="sub header">CUSTOMER,ANY DATE</div>
			</div>
		</h4>
	  	</div>

	 </div>
	</div>


	<!--
	<div class="ui column centered grid">
	    <div class="ui label column">
	    	<table class="ui very basic collapsing celled table">
			  <thead>
			  		<tr  class="center aligned">
			  			<th colspan='2'>SALES</th>
			  		</tr>
			  		<tr>
			  				<th>

			  					<h4 class="ui image header">
						          <i class="file outline icon"></i>
							          <div class="content">
							            <a href="<?php echo base_url('index.php/sales_invoice_book/search');?>" target="_blank">INVOICE REGISTER</a>
							            <div class="sub header">ANY DATE
							          </div>
						        	</div>
						      	</h4>

			  				</th>

			  				<th>

			  					<h4 class="ui image header">
						          <i class="file outline icon"></i>
							          <div class="content">
							            <a href="<?php echo base_url('index.php/sales_order_book/search');?>" target="_blank">ORDER BOOK</a>
							            <div class="sub header">ANY DATE
							          </div>
						        	</div>
						      	</h4>

			  				</th>
			  		</tr>
			  </thead>
			  <tbody>
			    <tr>
			    	<td>
			    		<h4 class="ui image header">
				          <i class="file outline icon"></i>
					          <div class="content">
					            <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/big_dia_small_dia_wise_sales');?>" target="_blank">BIG & SMALL DIAMETER</a>
					            <div class="sub header">MONTH WISE, DIA
					          </div>
				        	</div>
				      	</h4>
				    </td>
				    <td>
				    	<h4 class="ui image header">
				          <i class="file outline icon"></i>
					          <div class="content">
					            <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/pending_sales_order');?>" target="_blank">PENDING ORDER</a>
					            <div class="sub header">ANY DATE, DIA VS PRINT TYPE 
					          </div>
				        	</div>
				      	</h4>
				    </td>
			    </tr>
			    <tr>
			    	<td>
			    		<h4 class="ui image header">
				          <i class="file outline icon"></i>
					          <div class="content">
					            <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/print_type_wise_sales');?>" target="_blank">PRINT TYPE</a>
					            <div class="sub header">MONTH WISE, PRINT TYPE
					          </div>
				        	</div>
				      	</h4>
			    	</td>
			    </tr>

			    <tr>
			    	<td>
			    		<h4 class="ui image header">
				          <i class="file outline icon"></i>
					          <div class="content">
					            <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/top_customer_sales');?>" target="_blank">TOP CUSTOMER</a>
					            <div class="sub header">LARGE TO SMALL BY QUANTITY
					          </div>
				        	</div>
				      	</h4>
			    	</td>
			    </tr>
			    
			   
			  </tbody>
			</table>
		</div>
	</div>-->
</div>


<script type="text/javascript">
        var blink = document.getElementById('blink');
        setInterval(function() {
            blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
        }, 500);
    </script>