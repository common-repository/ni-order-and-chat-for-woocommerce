<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('Nicacowfw_Dashboard')){	
	
	include_once('nioacowfw-function.php');
	class Nicacowfw_Dashboard extends Nicacowfw_Function{
		var $nioacowfw_constant = array();  
		public function __construct($nioacowfw_constant = array()){
			$this->nioacowfw_constant = $nioacowfw_constant;

		}
		function page_init(){
		$today 			 				 = date_i18n("Y-m-d");
		$last_order_date 				 = $this->get_last_order_date();
		$last_order_string 				 = $this->time_elapsed_string($last_order_date);
		$status		 	 				 = $this->get_order_status($today ,$today,"wc-completed" );
	    $today_completed_order_count 	 = $this->get_order_count($today , $today, "wc-completed"  );
		
		$today_total_customer 			 = $this->get_total_today_order_customer('custom',false,$today,$today);
		$today_total_guest_customer 	 = $this->get_total_today_order_customer('custom',true,$today,$today);
		
			?>
            <style>
			
            </style>
        	<div class="container" id="nicacowfw">
            	<div class="row">
                <div class="col-md-4 col-xl-3">
                    <div class="card bg-c-blue order-card" style="padding:10px;">
                        <div class="card-block">
                            <h6 class="m-b-20"><?php esc_html_e( 'Last Orders Received', 'niwoomcr' ); ?></h6>
                            <h2 class="text-right">
                                <i class="fa fa-cart-plus f-left"></i>
                                <span>&nbsp;&nbsp;</span>
                            </h2>
                            <p class="m-b-0"> &nbsp;&nbsp;
                                <span class="f-right"><?php  echo $last_order_string; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="card bg-c-green order-card" style="padding:10px;" >
                        <div class="card-block">
                            <h6 class="m-b-20"> <?php esc_html_e( 'Today Orders Received', 'niwoomcr' ); ?> </h6>
                            <h2 class="text-right">
                                <i class="fa fa-rocket f-left"></i>
                                <span><?php echo  $today_completed_order_count; ?></span>
                            </h2>
                            <p class="m-b-0">Completed Orders
                                <span class="f-right"> &nbsp;&nbsp;</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="card bg-c-yellow order-card" style="padding:10px;">
                        <div class="card-block">
                            <h6 class="m-b-20"><?php esc_html_e( 'Today registered Customer', 'niwoomcr' ); ?> </h6>
                            <h2 class="text-right">
                                <i class="fa fa-refresh f-left"></i>
                                <span>&nbsp;&nbsp;</span>
                            </h2>
                            <p class="m-b-0">&nbsp;&nbsp;
                                <span class="f-right"><?php echo $today_total_customer; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="card bg-c-pink order-card" style="padding:10px;">
                        <div class="card-block">
                            <h6 class="m-b-20"><?php esc_html_e( 'Today GUEST Customer', 'niwoomcr' ); ?></h6>
                            <h2 class="text-right">
                                <i class="fa fa-credit-card f-left"></i>
                                <span>&nbsp;&nbsp;</span>
                            </h2>
                            <p class="m-b-0">&nbsp;&nbsp;
                                <span class="f-right"><?php  echo $today_total_guest_customer ; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            	</div>
                <div class="row">
                	<div class="col-md-6 col-xl-6">
                    	<div class="card">
                          <div class="card-header bg-c-pink text-white text-uppercase">
                            <?php esc_html_e( 'Top 10 Product Quantity Sold', 'niwoomcr' ); ?>
                          </div>
                          <div class="card-body">
                          <?php $this->get_nioacowfw_top_sold_product_quntity('quantity'); ?>
                          </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6 col-xl-6">
                    	<div class="card">
                          <div class="card-header bg-c-blue text-white text-uppercase">
                            <?php esc_html_e( 'Top 10 Product Value', 'niwoomcr' ); ?>
                          </div>
                          <div class="card-body">
                          <?php $this->get_nioacowfw_top_sold_product_quntity('line_total'); ?>
                          </div>
                        </div>
                        
                    </div>
                	
                </div>
            </div>
        <?php	
		}
		 function get_nioacowfw_top_sold_product_quntity($order_by = 'quantity'){
		 	 global $wpdb;
			  $query = " SELECT ";
			  $query .= "  SUM(qty.meta_value) as qty ";
			  $query .= " ,ROUND(SUM(line_total.meta_value),2) as line_total ";
			  $query .= " ,line_item.order_item_name as order_item_name ";
			  $query .= " FROM {$wpdb->prefix}posts as posts ";
			  $query .= " LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as line_item ON line_item.order_id=posts.ID  " ;
			  
			  $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=line_item.order_item_id  ";
			  $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=line_item.order_item_id  ";
			  
			  $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=line_item.order_item_id  ";
			  $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=line_item.order_item_id  ";
			  
			  
			  $query .= " WHERE 1=1 ";
			  $query .= " AND posts.post_type ='shop_order' ";
			  $query .= " AND qty.meta_key ='_qty' ";
			  $query .= " AND product_id.meta_key ='_product_id' ";
			   $query .= " AND variation_id.meta_key ='_variation_id' ";
			  
			  $query .= " AND line_item.order_item_type ='line_item' ";
			  $query .= " AND line_total.meta_key ='_line_total' ";
			  $query .= " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed')";
			
			  $query .= " AND  posts.post_status NOT IN ('trash')";
			  $query .= " GROUP BY product_id.meta_value, variation_id.meta_value  ";
			  
			  if ($order_by =='quantity'){
				$query .= " ORDER BY SUM(qty.meta_value) + 0 DESC ";  
			  }
			  if ($order_by =='line_total'){
				$query .= " ORDER BY SUM(line_total.meta_value) + 0 DESC ";  
			  }
			  
			  
			  $query .= " LIMIT 10 ";
			  
			 
				
			 $rows = $wpdb->get_results($query);	
			
			// $this->print_array($rows );
			
			?>
            <div style="overflow-x:auto;">
            <table  class="table table-striped  table-hover">
            	<thead>
                	<tr class="<?php echo ($order_by =='quantity')?'table-danger':'table-info';  ?>">
                    	<th><?php _e("Product Name","nidashboardreport"); ?></th>
                        <th style="text-align:right"><?php _e("Quantity","nidashboardreport"); ?></th>
                        <th style="text-align:right"><?php _e("Product Total","nidashboardreport"); ?></th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach($rows as $key=>$value): ?>
                    <tr>
                    	<td><?php echo $value->order_item_name; ?></td>
                        <td style="text-align:right"><?php echo $value->qty; ?></td>
                        <td  style="text-align:right"><?php echo wc_price($value->line_total); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php
			
			return $rows ;
		 }
		function get_order_count($start_date = NULL, $end_date =NULL, $order_status){
			global $wpdb;
			$query = "";
			$query .= " SELECT ";
			$query .= "	count(*)as 'order_count'";
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			$query .= " WHERE 1 = 1";  
			if ($start_date &&  $end_date)
			$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";
			$query .= " AND	posts.post_type ='shop_order' ";
			
			if ($order_status !=NULL){
				$query .= " AND	posts.post_status IN ('{$order_status}')";
			}
			
			
			$query .= " ORDER BY posts.post_date DESC";
			
			
			
			return $rows = $wpdb->get_var( $query );	
		}
		function get_last_order_date(){
			global $wpdb;
			$query = "";
			$query .= " SELECT ";
			$query .= "	posts.post_date as order_date";
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			$query .= " WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='shop_order' ";
			
			
			
			
			$query .= " ORDER BY posts.post_date DESC";
			
			return $rows = $wpdb->get_var( $query );
			
		}
		function get_order_status($start_date, $end_date,$order_status =''){
			global $wpdb;
			$query = "";
			$query .= " SELECT ";
			$query .= "	posts.post_status as order_status";
			
			$query .= "	,SUM(ROUND(order_total.meta_value,2)) as order_total";
			
			$query .= "	,COUNT(*) as order_count";
			
			
			$query .= "	FROM {$wpdb->prefix}posts as posts	";
			
			$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			
			$query .= " WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='shop_order' ";
			
			$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";
			$query .= " AND order_total.meta_key = '_order_total'";	
			
			if ($order_status !=NULL){
				$query .= " AND	posts.post_status IN ('{$order_status}')";
			}
			
			//$query .= " GROUP BY posts.post_status ";
			
			//$query .= " GROUP BY posts.post_status ";
			
			return $rows = $wpdb->get_results( $query );
			
		}
		function get_total_today_order_customer($type = 'total', $guest_user = false,$start_date = '',$end_date = ''){
			global $wpdb;
		
			
			$query = "SELECT ";
			if(!$guest_user){
				$query .= " users.ID, ";
			}else{
				$query .= " email.meta_value AS  billing_email,  ";
			}
			$query .= " posts.post_date
			FROM {$wpdb->prefix}posts as posts
			LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id = posts.ID";
			
			if(!$guest_user){
				$query .= " LEFT JOIN  {$wpdb->prefix}users as users ON users.ID = postmeta.meta_value";
			}else{
				$query .= " LEFT JOIN  {$wpdb->prefix}postmeta as email ON email.post_id = posts.ID";
			}
			
			$query .= " WHERE  posts.post_type = 'shop_order'";
			
			$query .= " AND postmeta.meta_key = '_customer_user'";
			
			if($guest_user){
				$query .= " AND postmeta.meta_value = 0";
				
				if($type == "today")		{$query .= " AND DATE(posts.post_date) = '{$this->today}'";}
				if($type == "yesterday")	{$query .= " AND DATE(posts.post_date) = '{$this->yesterday}'";}
				if($type == "custom")		{
						$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}' ";
				}
				
				$query .= " AND email.meta_key = '_billing_email'";
				
				$query .= " AND LENGTH(email.meta_value)>0";
			}else{
				$query .= " AND postmeta.meta_value > 0";
				if($type == "today")		{$query .= " AND DATE(users.user_registered) = '{$this->today}'";}
				if($type == "yesterday")	{$query .= " AND DATE(users.user_registered) = '{$this->yesterday}'";}
				if($type == "custom")		{
						$query .= " AND  date_format( users.user_registered, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}' ";
				}
				
				
			}
			
			if(!$guest_user){
				$query .= " GROUP BY  users.ID";
			}else{
				$query .= " GROUP BY  email.meta_value";		
			}
			
			$query .= " ORDER BY posts.post_date desc";
			
			
			$user =  $wpdb->get_results($query);
			
		
			
			$count = count($user);
			return $count;
		}
		function time_elapsed_string($datetime, $full = false) {
			$now = new DateTime;
			$ago = new DateTime($datetime);
			$diff = $now->diff($ago);
		
			$diff->w = floor($diff->d / 7);
			$diff->d -= $diff->w * 7;
		
			$string = array(
				'y' => 'year',
				'm' => 'month',
				'w' => 'week',
				'd' => 'day',
				'h' => 'hour',
				'i' => 'minute',
				's' => 'second',
			);
			foreach ($string as $k => &$v) {
				if ($diff->$k) {
					$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
				} else {
					unset($string[$k]);
				}
			}
		
			if (!$full) $string = array_slice($string, 0, 1);
			return $string ? implode(', ', $string) . ' ago' : 'just now';
		}
		function ajax_init(){
		
		}
	}
}