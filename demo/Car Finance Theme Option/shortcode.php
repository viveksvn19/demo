<?php
add_shortcode('fina-calc','fina_calc_callback');
function fina_calc_callback(){
$data ='<div class="col-md-12 ficalc" style="">
			<form action="#">
				<div class="col-md-6">
					<div class="left">
						<div class="form-group">
							<label for="amount">Amount:</label>
							<input type="amount" class="form-control" id="samount" name="samount" value="£ 2000">
							<input type="hidden" id="principle" value="2000">
						</div>
						<div class="form-group">
							<div class="slidecontainer">
								<input type="range" min="2000" max="50000" value="2000" class="slider" id="amount">
							</div>
						</div>
						<div class="form-group">
							<label for="amount">To pay over: </label>
							<p><span id="syear"> 1 Years</span></p>
							<input type="hidden" id="months" value="1">
						</div>
						<div class="form-group">
							<div class="slidecontainer">
								<input type="range" min="1" max="8" value="1" class="slider" id="year">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-7">
							<label for="amount">Your credit profile is:</label>
							</div>
							<div class="col-md-5">
							<select class="form-control">
								 <option value="excellent" selected="selected">Excellent</option>
	                            <option value="good">Good</option>
	                            <option value="fair">Fair</option>
	                            <option value="bad">Bad</option>
							</select>
							</div>
						</div>
					</div>
					</div>
					<div class="col-md-6">
						<div class="right">
							<div class="form-group">
								<table class="tablecs" id="myTable">
							  	<tr class="clickable-row">
							    	<td>Total cost of credit</td>
							    	<th><span class="creditval">Example 2</span></th>
							  	</tr>
							   	<tr class="clickable-row">
							    	<td>Total repayment</td>
							    	<th><span class="total-payment">Example 2</span></th>
							  	</tr>
							</table>
						</div>
						<div class="form-group">
						<table class="tablecs2" id="myTable">
						  	<tr class="clickable-row">
						    	<td>Monthly payments</td>
						    	<th><span class="mon-payment">Example 2</span></th>
						  	</tr>
						</table>
						</div>
						<div class="form-group form-group-btn">
						<a href="#" class="fi-btn" >Get a quote</a>
						</div>
					</div>
				</form>
			</div>
		</div>';
		return $data;
}
// Element Class 
class vcInformationBox extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'vc_before_init', array( $this, 'vc_informationbox_mapping' ) );
        add_shortcode( 'vc_informationbox', array( $this, 'vc_informationbox_html' ) );
    }
     
    // Element Mapping
    public function vc_informationbox_mapping() {
         
	    // Stop all if VC is not enabled
	    if ( !defined( 'WPB_VC_VERSION' ) ) {
	            return;
	    }
    // Map the block with vc_map()
	    vc_map( 
	  		array(
            'name' => __('Add Finance Calculator', 'text-domain'),
            'base' => 'vc_informationbox',
            'description' => __('A Based on Finance Calculator', 'text-domain'), 
            'category' => __('content', 'text-domain'),   
            'icon' => get_template_directory_uri().'/images/SweetThemes_logo.png',            
            "params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Text", "text-domain" ),
				"param_name" => "foo",
				"value" => __( "Default param value", "text-domain" ),
				"description" => __( "Description for foo param.", "my-text-domain" )
			),
		 	array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __( "Text color", "text-domain" ),
				"param_name" => "color",
				"value" => '#FF0000', //Default Red color
				"description" => __( "Choose text color", "text-domain" )
			),
			array(
			  "type" => "textarea_html",
			  "holder" => "div",
			  "class" => "",
			  "heading" => __( "Content", "text-domain" ),
			  "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
			  "value" => __( "<p>I am test text block. Click edit button to change this text.</p>", "text-domain" ),
			  "description" => __( "Enter your content.", "text-domain" )
 			)
		 ))
  		);                                
   	}
    public function vc_informationbox_html($atts,$content = null) {
    // Params extraction
    extract(
        shortcode_atts(
            array(
                'foo'   => '',
                'color' => '#FFF',
                //'content' => '',
            ), 
            $atts
        )
    );
    // Fill $html var with data
    $content = wpb_js_remove_wpautop($content, true);
    $data = '
    <div class="vc-informationbox-wrap">
     	<h2 class="vc-informationbox-title" style="color:'.$color.'">'.$foo.'</h2>
    	<div style="color:'.$color.'">'.$content.'</div>
    </div>';      
    $data .='<div class="col-md-12 ficalc" style="">
			<form action="#">
				<div class="col-md-6">
					<div class="left">
						<div class="form-group">
							<label for="amount">Amount:</label>
							<input type="amount" class="form-control" id="samount" name="samount" value="£ 2000">
							<input type="hidden" id="principle" value="2000">
						</div>
						<div class="form-group">
							<div class="slidecontainer">
								<input type="range" min="2000" max="50000" value="2000" class="slider" id="amount">
							</div>
						</div>
						<div class="form-group">
							<label for="amount">To pay over: </label>
							<p><span id="syear"> 1 Years</span></p>
							<input type="hidden" id="months" value="1">
						</div>
						<div class="form-group">
							<div class="slidecontainer">
								<input type="range" min="1" max="8" value="1" class="slider" id="year">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-7">
							<label for="amount">Your credit profile is:</label>
							</div>
							<div class="col-md-5">
							<select class="form-control">
								 <option value="excellent" selected="selected">Excellent</option>
	                            <option value="good">Good</option>
	                            <option value="fair">Fair</option>
	                            <option value="bad">Bad</option>
							</select>
							</div>
						</div>
					</div>
					</div>
					<div class="col-md-6">
						<div class="right">
							<div class="form-group">
								<table class="tablecs" id="myTable">
							  	<tr class="clickable-row">
							    	<td>Total cost of credit</td>
							    	<th><span class="creditval">Example 2</span></th>
							  	</tr>
							   	<tr class="clickable-row">
							    	<td>Total repayment</td>
							    	<th><span class="total-payment">Example 2</span></th>
							  	</tr>
							</table>
						</div>
						<div class="form-group">
						<table class="tablecs2" id="myTable">
						  	<tr class="clickable-row">
						    	<td>Monthly payments</td>
						    	<th><span class="mon-payment">Example 2</span></th>
						  	</tr>
						</table>
						</div>
						<div class="form-group form-group-btn">
						<a href="#" class="fi-btn" >Get a quote</a>
						</div>
					</div>
				</form>
			</div>
		</div>';
		return $data;
} 
     
} // End Element Class
 
// Element Class Init
new vcInformationBox(); 
add_filter( 'vc_load_default_templates', 'my_custom_template_at_first_position' ); // Hook in
 
add_action( 'vc_load_default_templates_action','my_custom_template_for_vc' ); // Hook in
 
function my_custom_template_for_vc() {
  $data = array(); // Create new array
  $data['name'] = __( 'Custom template', 'my-text-domain' ); // Assign name for your custom template
  $data['weight'] = 0; // Weight of your template in the template list
  $data['image_path'] = preg_replace( '/\s/', '%20', plugins_url( 'images/custom_template_thumbnail.jpg', __FILE__ ) ); // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
  $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
  $data['content']  = <<<CONTENT
  [vc_row][vc_column width="1/2"][vc_single_image border_color="grey" img_link_target="_self"][vc_column_text]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/vc_column][vc_column width="1/2"][vc_message color="alert-info" style="rounded"]I am message test box. Click edit button to change this text.[/vc_message][/vc_column][/vc_row]
CONTENT;
  
  vc_add_default_templates( $data );
}

?>