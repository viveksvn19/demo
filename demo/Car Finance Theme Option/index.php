<?php
/*
Plugin Name: Car Finance Theme Option 
Description: Custom wp plugin for Auto Finance Lending 
Version: 1.0
Author: reinforce.developers
*/
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! defined( 'MSDP' ) ){
define('MSDP', plugin_dir_path(__FILE__));
}
if ( ! defined( 'MSDU' ) ){
define('MSDU', plugin_dir_url(__FILE__));
}
if ( ! defined( 'MSTABLE' ) ){
define('MSTABLE', 'Financedata_translate');
}
if(is_admin()){
	include( MSDP .'inc/front-options.php' );
	include( MSDP .'inc/quote-list.php' );
}
class Financedata{
	function __construct(){
		add_action('admin_enqueue_scripts', array($this,'add_Financedatascripts'));
		add_action('wp_ajax_msdata', array($this,'msdata_callback'));
		add_action('wp_ajax_nopriv_msdata',array($this,'msdata_callback'));
		add_shortcode('carfin-description',array($this,'carfin_description'));
	}
	public function add_Financedatascripts(){
		wp_enqueue_script( 'Financedata-script', MSDU . '/js/multiscript.js', array('jquery') );
		wp_enqueue_style( 'Financedata-style', MSDU .'/css/msstyle.css');
 		$localize_scriptms = array(
			 'ajax_url' => admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'Financedata-script', 'myajax', $localize_scriptms);
	}
	public function msdata_callback(){
		$table_name = "wp_getquote";
		global $wpdb;
		$filters = array_merge($_GET, $_POST);
		$filters['table'] = $table_name;
		$filters['aSelectionColumns'] = array('tbl.borrow','tbl.finance','tbl.title','tbl.first_name','tbl.last_name','tbl.email','tbl.dob_number','tbl.phone_number','tbl.gender','tbl.email_by','tbl.sms_by','tbl.time_month','tbl.emp_time_month','tbl.postal_code','tbl.emp_name','tbl.emp_occupation','tbl.emp_monincome','tbl.emp_status','tbl.residen_address','tbl.driv_lice','tbl.term_con','tbl.submission_date');
		$filters['aColumns'] = array('borrow','finance','title','first_name','last_name','phone_number','email','dob_number','gender','email_by','sms_by','time_month','emp_time_month','postal_code','emp_name','emp_occupation','emp_monincome','emp_status','residen_address','driv_lice','term_con','submission_date');
		//$filters['custom_search_filter'] = array(
		//			'where' => array('tbl.uid' => $this->dx_auth->get_user_id(),'tbl.type'=>'surf')
		//);
		$output = $this->get_data_ms($filters);
		echo json_encode($output);
		die;
	}
	public function get_data_ms($filters){
		global $wpdb;
		$searchFields = isset($filters['custom_search_filter'])?$filters['custom_search_filter']:'';

		$tbl = isset($filters['table']) && $filters['table'] ? $filters['table'] . "  tbl ":'';
		
		if(!$tbl){return false;}
		
		$joins = isset($filters['joins']) && $filters['joins'] ?  $filters['joins'] :'';

		$aSelectionColumns = isset($filters['aSelectionColumns']) && $filters['aSelectionColumns'] ? $filters['aSelectionColumns']:array();
		$aColumns = isset($filters['aColumns']) && $filters['aColumns'] ? $filters['aColumns']:array();
		
		$pk = isset($filters['index_column']) && $filters['index_column'] ? $filters['index_column'] :'tbl.id';
		
		$sql = 'SELECT '.$pk." as DT_RowId, ".implode(',',$aSelectionColumns) . ' FROM '.$tbl;
		/*
		 * Joins
		 */
		 $sJoin = '';
		if($joins){
			foreach($joins as $join){
				$jtype = isset($join['type']) && $join['type']? $join['type'] :'left';
				if(isset($join['alias']) && $join['alias']){
					$sJoin .=  $jtype . " JOIN  " . $join['table'] . " as " . $join['alias'] . " ON " . $join['on'];
				} else {
					$sJoin .=  $jtype . " JOIN  " . $join['table'] . " ON " . $join['on'];
				}
			}
		}
		/*
		 * Ordering
		 */
		 $sOrder = "";
		if ( isset( $filters['order'] ) ){
			
			foreach ( $filters['order'] as $ok => $ov ){
					$sOrder .= " " . $aColumns[$ov['column']]." ". ( $ov['dir'] ) .",";
			}
			$sOrder = rtrim($sOrder,",");
		}
		if($sOrder){
			$sOrder = ' ORDER BY ' . $sOrder;
		}
		$sWhere = '';
		if(isset($searchFields['where']) && $searchFields['where'] ){
				foreach($searchFields['where'] as $k => $v){
					if($sWhere){
						$sWhere .= ' AND ' . $k .' = "'.$v.'"';
					} else {
						$sWhere .= $k .' = "'.$v.'"';
					}
				}
		}
		if(isset($searchFields['where_in']) && $searchFields['where_in'] ){
				foreach($searchFields['where_in'] as $k => $v){
					if($sWhere){
						$sWhere .= ' AND ' . $k .' IN("'.implode('","',$v).'")';
					} else {
						$sWhere .= $k .' IN("'.implode('","',$v).'")';
					}
				}
		}
		
		$sLikes = '';
		if($filters['search']['value']){
			$cnt = 0;
			foreach($filters['columns'] as $sk => $sv){
				if($sv['searchable'] == "true"){
					$clmn_name = isset($aColumns[$sk]) ? $aColumns[$sk] : '';
					if($clmn_name){
					if($sLikes){
							$sLikes .= ' OR ' . $aColumns[$sk] .' like  "%'.$filters['search']['value'].'%"';
						} else {
							$sLikes .= ' ' . $aColumns[$sk] .' like  "%'.$filters['search']['value'].'%"';
						}
					}
				}
				$cnt++;
			}
		}
		/* 
		 * Paging
		 */
		 $sLimit = '';
		if ( isset( $filters['length'] ) && $filters['length'] ){
			$sLimit .= ' LIMIT ' . $filters['start']. ', ' .$filters['length'];
		}
		
		if($sLikes){
			if($sWhere){
				$sWhere .= ' AND (' . $sLikes . ')';
			} else {
				$sWhere = $sLikes;
			}
			
		}
		if($sWhere){
			$sWhere = ' WHERE ' . $sWhere;
		}
		$iTotal = $wpdb->get_results('SELECT count(*) as cnt FROM ' . $tbl);
		$iTotal = $iTotal[0]->cnt;
		$iFilteredTotal = $wpdb->get_results('SELECT count(*) as cnt FROM ' . $tbl . $sJoin . $sWhere);
		$iFilteredTotal = $iFilteredTotal[0]->cnt;
		$sql = $sql . $sJoin. $sWhere . $sOrder . $sLimit;
		$restult = $wpdb->get_results($sql);
		$output = array( 
			"draw" => intval($filters['draw']),
			"recordsTotal" => $iTotal,
			"recordsFiltered" => $iFilteredTotal,
			"data" => $restult
		);
		return $output;	
	}
	public function carfin_description(){
		$desc = get_option( 'us_partners_desc' );
		return $desc;
	}
}
global $Financedata;
$Financedata = new Financedata();
?>