<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;} /*exit if direct access*/
if( !class_exists( 'Nicacowfw_Function' ) ) {
	/**
	* WooReport_COG_Order_Profit_Report
	*/
	class Nicacowfw_Function {
		 /**
		 * Class constructor.
		 *
		 */
		public function __construct(){
		}
		/*
	     * get_wooreport_cog_post_meta
		 * get cost of goods meta
		 * @param int $post_id default = "0"
		 * @param array() $meta_key default =  array()
		 * @return data $new_row_cog
		 *
		 */
		/*
	     * get_request
		 * handle all request
		 * @param string $name
		 * @param string $default  =NULL
		 * @param bool $set default =  false
		 * @return $default
		 *
		 */
		
		
		function get_single_request($name, $default=''){
			$single_request = sanitize_text_field(isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default);
			return $single_request ;
				
		}
		function get_settings($name, $default=''){
			$option_value = '';
			$nioacowfw_options = get_option("nioacowfw_options",array());
			$option_value = isset($nioacowfw_options[$name])?$nioacowfw_options[$name]: $default;
			return $option_value;
		}
		function get_short_code(){
			$short_code= array();
			$short_code['product_name']  = '{{product_name}}';
			$short_code['product_url']  = '{{product_url}}';
			$short_code['product_price']  = '{{product_price}}';
			$short_code['product_sku']  = '{{product_sku}}';
			$short_code['product_category']  = '{{product_category}}';
			return $short_code;
		}
		/*
	     * prettyPrint
		 * handle all request
		 * @param array $ar
		 * @param bool $display  =true
		 *
		 */
		function prettyPrint($ar,$display = true) {
			if($ar){
				$output = "<pre>";
				$output .= print_r($ar,true);
				$output .= "</pre>";
			
			if($display){
				echo balanceTags($output,true);
			}else{
				return $output;
				}
			}
		}
		/*
	     * ExportToCsv
		 * Export To CSV
		 * @param string $filename
		 * @param array $rows
		 * @param array $columns
		 * @param string $format , default = "CSV"
		 *
		 */
		function ExportToCsv($filename = 'export.csv',$rows,$columns,$format="csv"){				
			global $wpdb;
			$csv_terminated = "\n";
			$csv_separator = ",";
			$csv_enclosed = '"';
			$csv_escaped = "\\";
			$fields_cnt = count($columns); 
			$schema_insert = '';
			
			if($format=="xls"){
				$csv_terminated = "\r\n";
				$csv_separator = "\t";
			}
				
			foreach($columns as $key => $value):
				$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $value) . $csv_enclosed;
				$schema_insert .= $l;
				$schema_insert .= $csv_separator;
			endforeach;// end for
		 
		   $out = trim(substr($schema_insert, 0, -1));
		   $out .= $csv_terminated;
			
			//printArray($rows);
			
			for($i =0;$i<count($rows);$i++){
				
				//printArray($rows[$i]);
				$j = 0;
				$schema_insert = '';
				foreach($columns as $key => $value){
						
						
						 if ($rows[$i][$key] == '0' || $rows[$i][$key] != ''){
							if ($csv_enclosed == '')
							{
								$schema_insert .= $rows[$i][$key];
							} else
							{
								$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $rows[$i][$key]) . $csv_enclosed;
							}
						 }else{
							$schema_insert .= '';
						 }
						
						
						
						if ($j < $fields_cnt - 1)
						{
							$schema_insert .= $csv_separator;
						}
						$j++;
				}
				$out .= $schema_insert;
				$out .= $csv_terminated;
			}
			
			if ( function_exists( 'gc_enable' ) ) {
                gc_enable();
            }
            if ( function_exists( 'apache_setenv' ) ) {
                @apache_setenv( 'no-gzip', 1 ); // @codingStandardsIgnoreLine
            }
            @ini_set( 'zlib.output_compression', 'Off' ); // @codingStandardsIgnoreLine
            @ini_set( 'output_buffering', 'Off' ); // @codingStandardsIgnoreLine
            @ini_set( 'output_handler', '' ); // @codingStandardsIgnoreLine
            ignore_user_abort( true );
            wc_set_time_limit( 0 );
            wc_nocache_headers();
			
			if($format=="csv"){
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Length: " . strlen($out));	
				header("Content-type: text/x-csv");
				header("Content-type: text/csv");
				header("Content-type: application/csv");
				header("Content-Disposition: attachment; filename=$filename");
			}elseif($format=="xls"){
				
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Length: " . strlen($out));
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=$filename");
				header("Pragma: no-cache");
				header("Expires: 0");
			}
			print_r(  chr( 239 ) . chr( 187 ) . chr( 191 ) .$out);
            exit;
		 
		}
		/*
	     * get_country_name
		 * Country name by country code
		 * @param string $code
		 * @return $name
		 */
		function get_country_name($code){
				$name = "";
				if (strlen($code)>0){
					$name= WC()->countries->countries[ $code];	
					$name  = isset($name) ? $name : $code;
				}
				return $name;
		}
		/*
	     * get_all_request
		 * convert request into hiiden text field
		 * @param string $code
		 * @return $name
		 */
		function get_all_request($request = array()){
			//$input_type = "text";
			$input_type = "hidden";
			foreach($request as $key=>$value){
				if (is_array($value)){
					 $value =  implode("','", $value);
				} 
			?>
			<input type="<?php echo esc_attr($input_type); ?>" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>" />
			<?php	
			}
		
		}
		/*
	     * get_simple_product
		 * simple product query
		 * @return $simple_product
		 */
		function get_simple_product(){
			global $wpdb;
			$simple_product =  array();
			$query  = "";
			$query .=" SELECT    ";
			$query .=" post.ID as product_id ";
			$query .=", post.post_title as product_name ";
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=post.ID ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_taxonomy as term_taxonomy ON term_taxonomy.term_taxonomy_id=relationships.term_taxonomy_id ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}terms as terms ON terms.term_id=term_taxonomy.term_id ";
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product'";
			$query .=" AND post.post_status='publish'";
			$query .=" AND terms.name='simple'";
			$query .=" ORDER BY post.post_title  ";
			
			$row = $wpdb->get_results( $query);	
			foreach($row as $key=>$value){
				$simple_product[$value->product_id] = $value->product_name;
			}
			return $simple_product;
		}
		/*
	     * get_variable_product
		 * variable product query
		 * @return $simple_product
		 */
		function get_variable_product(){
			global $wpdb;
			$variable_product =  array();
			$query  = "";
			$query .=" SELECT    ";
			$query .=" post.ID as product_id ";
			$query .=", post.post_title as product_name ";
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=post.ID ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}term_taxonomy as term_taxonomy ON term_taxonomy.term_taxonomy_id=relationships.term_taxonomy_id ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}terms as terms ON terms.term_id=term_taxonomy.term_id ";
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product'";
			$query .=" AND post.post_status='publish'";
			$query .=" AND terms.name='variable'";
			$query .=" ORDER BY post.post_title  ";
			
			$row = $wpdb->get_results( $query);	
			foreach($row as $key=>$value){
				$variable_product[$value->product_id] = $value->product_name;
			}
			
		
			
			return $variable_product;
		}
		/*
	     * get_variation_product
		 * variation product query
		 * @return $simple_product
		 */
		function get_variation_product(){
			global $wpdb;
			$row               =  array();
			$variation_product =  array();
			$query  = "";
			$query .=" SELECT    ";
			$query .=" post.ID as variation_id ";
			$query .=", post.post_parent as post_parent_id ";
			$query .=", post.post_title as product_name ";
			$query .=", posts_parent.post_title as parent_product_name ";
			$query .=" FROM {$wpdb->prefix}posts as post  ";
			
			$query .=" LEFT JOIN {$wpdb->prefix}posts as posts_parent ON posts_parent.ID=post.post_parent ";
			
		
			
			$query .=" WHERE 1=1 ";
			$query .=" AND post.post_type='product_variation'";
			$query .=" AND post.post_status='publish'";
			$query .=" ORDER BY post.post_title  ";
			
			$row = $wpdb->get_results( $query);	
			
			foreach($row as $key=>$value){
				$variation_product[$value->variation_id] = $value->product_name;
			}
			return $variation_product;
		}
		/*
	     * wooreport_cog_pagination
		 * @param int $total_row
		 * @param int $per_page
		 * @param int $page
		 * @param string $url
		 * @return string $pagination
		 */
		
		

		function get_nipagination($total_row,$per_page=10,$page=1,$url='?'){   
			$total = $total_row;
			$adjacents = "2"; 
			  
			$prevlabel = esc_html__("&lsaquo; Prev",'wooreportcogpro');
			$nextlabel = esc_html__("Next &rsaquo;",'wooreportcogpro');
			$lastlabel = esc_html__("Last &rsaquo;&rsaquo;",'wooreportcogpro');
			$pagelabel = esc_html__("Page",'wooreportcogpro');
			  
			$page = ($page == 0 ? 1 : $page);  
			$start = ($page - 1) * $per_page;                               
			  
			$prev = $page - 1;                          
			$next = $page + 1;
			  
			$lastpage = ceil($total/$per_page);
			  
			$lpm1 = $lastpage - 1; // //last page minus 1
			  
			$pagination = "";
			if($lastpage > 1){   
				$pagination .= "<ul class='wooreport_pagination'>";
				$pagination .= "<li class='page_info'>{$pagelabel} {$page} of {$lastpage}</li>";
					  
					if ($page > 1) $pagination.= "<li><a data-page={$prev} href='{$url}page={$prev}'>{$prevlabel}</a></li>";
					  
				if ($lastpage < 7 + ($adjacents * 2)){   
					for ($counter = 1; $counter <= $lastpage; $counter++){
						if ($counter == $page)
						
							$pagination.= "<li><span class='current'>{$counter}</span></li>";
						else
							$pagination.= "<li><a data-page={$counter} href='{$url}page={$counter}'>{$counter}</a></li>";                    
					}
				  
				} elseif($lastpage > 5 + ($adjacents * 2)){
					  
					if($page < 1 + ($adjacents * 2)) {
						  
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
							if ($counter == $page)
							
								$pagination.= "<li><span class='current'>{$counter}</span></li>";
							else
								$pagination.= "<li><a data-page={$counter}  href='{$url}page={$counter}'>{$counter}</a></li>";                    
						}
						$pagination.= "<li class='dot'>...</li>";
						$pagination.= "<li><a data-page={$lpm1} href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li><a data-page={$lastpage} href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
							  
					} elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
						  
						$pagination.= "<li><a data-page=1 href='{$url}page=1'>1</a></li>";
						$pagination.= "<li><a data-page=2 href='{$url}page=2'>2</a></li>";
						$pagination.= "<li class='dot'>...</li>";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
							if ($counter == $page)
							
								$pagination.= "<li><span class='current'>{$counter}</span></li>";
							else
								$pagination.= "<li><a data-page={$counter} href='{$url}page={$counter}'>{$counter}</a></li>";                    
						}
						$pagination.= "<li class='dot'>..</li>";
						$pagination.= "<li><a data-page={$lpm1} href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li><a data-page={$lastpage} href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
						  
					} else {
						  
						$pagination.= "<li><a data-page=1 href='{$url}page=1'>1</a></li>";
						$pagination.= "<li><a data-page=2 href='{$url}page=2'>2</a></li>";
						$pagination.= "<li class='dot'>..</li>";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
							if ($counter == $page)
								
								$pagination.= "<li><span class='current'>{$counter}</span></li>";
							else
								$pagination.= "<li><a data-page={$counter} href='{$url}page={$counter}'>{$counter}</a></li>";                    
						}
					}
				}
				  
					if ($page < $counter - 1) {
						$pagination.= "<li><a data-page={$next} href='{$url}page={$next}'>{$nextlabel}</a></li>";
						$pagination.= "<li><a data-page={$lastpage} href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
					}
				  
				$pagination.= "</ul>";        
			}
			  
			return $pagination;
		}
		
		
		
		/*
	     * get_billing_country
		 * billing query
		 */
		function get_billing_country(){
			global $wpdb;
			$billing_country = array();
			$query = "";
			$query .= " SELECT billing_country.meta_value as billing_country";
			$query .= "	FROM {$wpdb->prefix}posts as posts		";
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID ";
			
			$query .= "	WHERE 1 = 1 ";
			$query .= " AND posts.post_status NOT IN ('auto-draft','inherit')";
			$query .= " AND posts.post_type ='shop_order'";
			
			$query .= " AND billing_country.meta_key = '_billing_country'";	 
			 
			$query .= " group By billing_country.meta_value";	
			
			$row = $wpdb->get_results( $query);	
			foreach($row as $key=>$value){
				$billing_country[$value->billing_country] =  $this->get_country_name($value->billing_country); 
			}	
		//	$this->prettyPrint($billing_country);
			return $billing_country;
			
		}
		
		/*
	     * get_wooreport_price
		 * get format price
		 * @param string $price default = "0"
		 * @param bool $display default =true
		 * @return data $new_price
		 */
		function get_wooreport_price($price= "0", $display =true){
			if($display){
				echo wc_price($price);
			}else{
				return wc_price($price);
			}
		}
		/*
	     * get_product_parent
		 * get parent product query
		 * @return data $post_parent_array
		 */
		function get_product_parent(){
		    global $wpdb;
			$query = "";
			$query = " SELECT ";
			$query .= " posts.post_parent as post_parent ";
			$query .= " FROM  {$wpdb->prefix}posts as posts			";
			$query .= "	WHERE 1 = 1";
			$query .= "	AND posts.post_type  IN ('product_variation') ";
			$query .=" AND posts.post_status='publish'";
			
			$query .= " GROUP BY post_parent ";
			$row = $wpdb->get_results($query);		
			
			$post_parent_array = array();
			foreach($row as $key=>$value){
				$post_parent_array[] = $value->post_parent;
			}
			return $post_parent_array;
		 }
		 
		
		 /*Caculate total at bottom
		 * @param array $rows default = array()
		 * @param array $columns default = array()
		 */	 
		 function get_report_total_table($rows = array(), $columns = array()){
			$report_total =  array();
			foreach($rows as $rkey=>$rvalue){
				 foreach($columns as $ckey=>$cvalue){	
					if (array_key_exists($ckey,$rvalue)){
						if(isset($report_total[$ckey])){
							$oldvalue = $report_total[$ckey];
							$report_total[$ckey] =$report_total[$ckey] + $rvalue->$ckey;
						}else{
							$report_total[$ckey]  =$rvalue->$ckey;
						}
					}
				}
			}
			?>
            <div class="wooreport-table-total">
            	<table class="wr-table wr-report-table">
            	 <thead>
                	<tr>
                	<?php foreach($columns as $key=>$value): ?>
                    	<th class="amount"><?php echo esc_html( $value); ?></th>
                    <?php endforeach; ?>
                	</tr>
                </thead>
                <tbody>
                	<tr>
                	<?php foreach($columns as $key=>$value): ?>
                    	<?php $total_value = isset($report_total[$key])?$report_total[$key]:0;  ?>
                    	<td class="amount"><?php echo wc_price($total_value);  ?></td>
                    <?php endforeach; ?>
                	</tr>
                </tbody>
                
            </table>
            </div>
            <?php			
		}
			
	}
}
?>
