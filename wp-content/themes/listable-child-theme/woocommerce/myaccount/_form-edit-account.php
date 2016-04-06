<?php
error_reporting(0);
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly 
}
?> 
  
  <?php
  $countries = array(
			"AF"    =>  "Afghanistan",
			"AL"    =>  "Albania",
			"DZ"    =>  "Algeria",
			"AS"    =>  "American Samoa",
			"AD"    =>  "Andorra",
			"AG"    =>  "Angola",
			"AI"    =>  "Anguilla",
			"AG"    =>  "Antigua &amp; Barbuda",
			"AR"    =>  "Argentina",
			"AA"    =>  "Armenia",
			"AW"    =>  "Aruba",
			"AU"    =>  "Australia",
			"AT"    =>  "Austria",
			"AZ"    =>  "Azerbaijan",
			"BS"    =>  "Bahamas",
			"BH"    =>  "Bahrain",
			"BD"    =>  "Bangladesh",
			"BB"    =>  "Barbados",
			"BY"    =>  "Belarus",
			"BE"    =>  "Belgium",
			"BZ"    =>  "Belize",
			"BJ"    =>  "Benin",
			"BM"    =>  "Bermuda",
			"BT"    =>  "Bhutan",
			"BO"    =>  "Bolivia",
			"BL"    =>  "Bonaire",
			"BA"    =>  "Bosnia &amp; Herzegovina",
			"BW"    =>  "Botswana",
			"BR"    =>  "Brazil",
			"BC"    =>  "British Indian Ocean Territory",
			"BN"    =>  "Brunei",
			"BG"    =>  "Bulgaria",
			"BF"    =>  "Burkina Faso",
			"BI"    =>  "Burundi",
			"KH"    =>  "Cambodia",
			"CM"    =>  "Cameroon",
			"CA"    =>  "Canada",
			"IC"    =>  "Canary Islands",
			"CV"    =>  "Cape Verde",
			"KY"    =>  "Cayman Islands",
			"CF"    =>  "Central African Republic",
			"TD"    =>  "Chad",
			"CD"    =>  "Channel Islands",
			"CL"    =>  "Chile",
			"CN"    =>  "China",
			"CI"    =>  "Christmas Island",
			"CS"    =>  "Cocos Island",
			"CO"    =>  "Colombia",
			"CC"    =>  "Comoros",
			"CG"    =>  "Congo",
			"CK"    =>  "Cook Islands",
			"CR"    =>  "Costa Rica",
			"CT"    =>  "Cote D'Ivoire",
			"HR"    =>  "Croatia",
			"CU"    =>  "Cuba",
			"CB"    =>  "Curacao",
			"CY"    =>  "Cyprus",
			"CZ"    =>  "Czech Republic",
			"DK"    =>  "Denmark",
			"DJ"    =>  "Djibouti",
			"DM"    =>  "Dominica",
			"DO"    =>  "Dominican Republic",
			"TM"    =>  "East Timor",
			"EC"    =>  "Ecuador",
			"EG"    =>  "Egypt",
			"SV"    =>  "El Salvador",
			"GQ"    =>  "Equatorial Guinea",
			"ER"    =>  "Eritrea",
			"EE"    =>  "Estonia",
			"ET"    =>  "Ethiopia",
			"FA"    =>  "Falkland Islands",
			"FO"    =>  "Faroe Islands",
			"FJ"    =>  "Fiji",
			"FI"    =>  "Finland",
			"FR"    =>  "France",
			"GF"    =>  "French Guiana",
			"PF"    =>  "French Polynesia",
			"FS"    =>  "French Southern Territory",
			"GA"    =>  "Gabon",
			"GM"    =>  "Gambia",
			"GE"    =>  "Georgia",
			"DE"    =>  "Germany",
			"GH"    =>  "Ghana",
			"GI"    =>  "Gibraltar",
			"GB"    =>  "Great Britain",
			"GR"    =>  "Greece",
			"GL"    =>  "Greenland",
			"GD"    =>  "Grenada",
			"GP"    =>  "Guadeloupe",
			"GU"    =>  "Guam",
			"GT"    =>  "Guatemala",
			"GN"    =>  "Guinea",
			"GY"    =>  "Guyana",
			"HT"    =>  "Haiti",
			"HW"    =>  "Hawaii",
			"HN"    =>  "Honduras",
			"HK"    =>  "Hong Kong",
			"HU"    =>  "Hungary",
			"IS"    =>  "Iceland",
			"IN"    =>  "India",
			"ID"    =>  "Indonesia",
			"IA"    =>  "Iran",
			"IQ"    =>  "Iraq",
			"IE"    =>  "Ireland",
			"IM"    =>  "Isle of Man",
			"IL"    =>  "Israel",
			"IT"    =>  "Italy",
			"JM"    =>  "Jamaica",
			"JP"    =>  "Japan",
			"JO"    =>  "Jordan",
			"KZ"    =>  "Kazakhstan",
			"KE"    =>  "Kenya",
			"KI"    =>  "Kiribati",
			"NK"    =>  "Korea North",
			"KR"    =>  "Korea South",
			"KW"    =>  "Kuwait",
			"KG"    =>  "Kyrgyzstan",
			"LA"    =>  "Laos",
			"LV"    =>  "Latvia",
			"LB"    =>  "Lebanon",
			"LS"    =>  "Lesotho",
			"LR"    =>  "Liberia",
			"LY"    =>  "Libya",
			"LI"    =>  "Liechtenstein",
			"LT"    =>  "Lithuania",
			"LU"    =>  "Luxembourg",
			"MO"    =>  "Macau",
			"MK"    =>  "Macedonia",
			"MG"    =>  "Madagascar",
			"MY"    =>  "Malaysia",
			"MW"    =>  "Malawi",
			"MV"    =>  "Maldives",
			"ML"    =>  "Mali",
			"MT"    =>  "Malta",
			"MH"    =>  "Marshall Islands",
			"MQ"    =>  "Martinique",
			"MR"    =>  "Mauritania",
			"MU"    =>  "Mauritius",
			"ME"    =>  "Mayotte",
			"MX"    =>  "Mexico",
			"MI"    =>  "Midway Islands",
			"MD"    =>  "Moldova",
			"MC"    =>  "Monaco",
			"MN"    =>  "Mongolia",
			"MS"    =>  "Montserrat",
			"MA"    =>  "Morocco",
			"MZ"    =>  "Mozambique",
			"MM"    =>  "Myanmar",
			"NA"    =>  "Nambia",
			"NU"    =>  "Nauru",
			"NP"    =>  "Nepal",
			"AN"    =>  "Netherland Antilles",
			"NL"    =>  "Netherlands",
			"NV"    =>  "Nevis",
			"NC"    =>  "New Caledonia",
			"NZ"    =>  "New Zealand",
			"NI"    =>  "Nicaragua",
			"NE"    =>  "Niger",
			"NG"    =>  "Nigeria",
			"NW"    =>  "Niue",
			"NF"    =>  "Norfolk Island",
			"NO"    =>  "Norway",
			"OM"    =>  "Oman",
			"PK"    =>  "Pakistan",
			"PW"    =>  "Palau Island",
			"PS"    =>  "Palestine",
			"PA"    =>  "Panama",
			"PG"    =>  "Papua New Guinea",
			"PY"    =>  "Paraguay",
			"PE"    =>  "Peru",
			"PH"    =>  "Philippines",
			"PO"    =>  "Pitcairn Island",
			"PL"    =>  "Poland",
			"PT"    =>  "Portugal",
			"PR"    =>  "Puerto Rico",
			"QA"    =>  "Qatar",
			"RE"    =>  "Reunion",
			"RO"    =>  "Romania",
			"RU"    =>  "Russia",
			"RW"    =>  "Rwanda",
			"NT"    =>  "St Barthelemy",
			"EU"    =>  "St Eustatius",
			"HE"    =>  "St Helena",
			"KN"    =>  "St Kitts-Nevis",
			"LC"    =>  "St Lucia",
			"MB"    =>  "St Maarten",
			"PM"    =>  "St Pierre &amp; Miquelon",
			"VC"    =>  "St Vincent &amp; Grenadines",
			"SP"    =>  "Saipan",
			"SO"    =>  "Samoa",
			"AS"    =>  "Samoa American",
			"SM"    =>  "San Marino",
			"ST"    =>  "Sao Tome &amp; Principe",
			"SA"    =>  "Saudi Arabia",
			"SN"    =>  "Senegal",
			"SC"    =>  "Seychelles",
			"SL"    =>  "Sierra Leone",
			"SG"    =>  "Singapore",
			"SK"    =>  "Slovakia",
			"SI"    =>  "Slovenia",
			"SB"    =>  "Solomon Islands",
			"OI"    =>  "Somalia",
			"ZA"    =>  "South Africa",
			"ES"    =>  "Spain",
			"LK"    =>  "Sri Lanka",
			"SD"    =>  "Sudan",
			"SR"    =>  "Suriname",
			"SZ"    =>  "Swaziland",
			"SE"    =>  "Sweden",
			"CH"    =>  "Switzerland",
			"SY"    =>  "Syria",
			"TA"    =>  "Tahiti",
			"TW"    =>  "Taiwan",
			"TJ"    =>  "Tajikistan",
			"TZ"    =>  "Tanzania",
			"TH"    =>  "Thailand",
			"TG"    =>  "Togo",
			"TK"    =>  "Tokelau",
			"TO"    =>  "Tonga",
			"TT"    =>  "Trinidad &amp; Tobago",
			"TN"    =>  "Tunisia",
			"TR"    =>  "Turkey",
			"TU"    =>  "Turkmenistan",
			"TC"    =>  "Turks &amp; Caicos Is",
			"TV"    =>  "Tuvalu",
			"UG"    =>  "Uganda",
			"UA"    =>  "Ukraine",
			"AE"    =>  "United Arab Emirates",
			"GB"    =>  "United Kingdom",
			"US"    =>  "United States of America",
			"UY"    =>  "Uruguay",
			"UZ"    =>  "Uzbekistan",
			"VU"    =>  "Vanuatu",
			"VA"    =>  "Vatican City State",
			"VE"    =>  "Venezuela",
			"VN"    =>  "Vietnam",
			"VB"    =>  "Virgin Islands (Brit)",
			"VA"    =>  "Virgin Islands (USA)",
			"WF"    =>  "Wallis &amp; Futana Is",
			"YE"    =>  "Yemen",
			"ZR"    =>  "Zaire",
			"ZM"    =>  "Zambia",
			"ZW"    =>  "Zimbabwe"
	);
  
  
  ?>
  
  
<?php
       global $userdata,$wpdb,$post;
       get_currentuserinfo();
       $current_user = wp_get_current_user();
	   $user_current_id = $current_user->ID;	   
	    //$results = $wpdb->get_results("SELECT * FROM wp_dmfw_usercare where user_current_id = '".$user_current_id."'", OBJECT );
	   	$results = get_user_meta($user_current_id, $key, $single);                
      	if(isset($_POST['save_account_details'])){
      		if(isset($_FILES['file'])){      			
		      	if ( ! function_exists( 'wp_handle_upload' ) ) {
				    require_once( ABSPATH . 'wp-admin/includes/file.php' );
				}

				$uploadedfile = $_FILES['file'];

				$upload_overrides = array( 'test_form' => false );

				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

				if ( $movefile && ! isset( $movefile['error'] ) ) {				
					update_user_meta( $user_current_id, 'user_image', $movefile['url'], $prev_value );
				} else {
				    /**
				     * Error generated by _wp_handle_upload()
				     * @see _wp_handle_upload() in wp-admin/includes/file.php
				     */
				    //echo $movefile['error'];
				}
			}
    		foreach ($_POST['user_meta'] as $key => $value) {
				if($key == 'carertags'){				
					$ctags = implode(',', $value);				
					update_user_meta( $user_current_id, $key, $ctags, $prev_value );
				}elseif($key == 'parentags'){
					$ptags = implode(',', $value);				
					update_user_meta( $user_current_id, $key, $ptags, $prev_value );
				} else{
					update_user_meta( $user_current_id, $key, $value, $prev_value );					
				}
    		}    		
    	}

    	if (!empty($_POST)) {
		    // do stuff
		    header("Location: $_SERVER[PHP_SELF]");
		}
	global $wp_roles;
	
?>


<h3 class="password-change-title"><?php _e( 'Profile Verification', 'woocommerce' ); ?></h3>
<p><?php _e( 'Complete all point to earn Irishcare Seal of Approval on you Account.', 'woocommerce' ); ?></p>
<p class="form-row form-row-half">
<h3 class="password-change-title"><?php _e( 'Only For Care Givers &nbsp;50%', 'woocommerce' ); ?></br>
<table border="1">
	<tr>
		<th>10%</th>
		<th>20%</th>
		<th>30%</th>
		<th>40%</th>
		<th>50%</th>
		<th>60%</th>
		<th>70%</th>
		<th>80%</th>
		<th>90%</th>
		<th>100%</th>
	</tr>
	<tr style="background:#fff;border:1px solid;">
        <p style="width:<?= 'here'?>%;background:green;">
            <?= 'here'?>    
        </p>		
   </tr>
   </table>
</h3>

<ul>
<li>1.&nbsp;Complete Your Profile &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($userid == 20){ echo "Done!";}else
	{
		
		echo '<p>Awaiting</p>';
		
	}
?>
</b></li>
<li>2.&nbsp;Connect Your Social Profile &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($phone == 20){ echo "Done!";}else
	{
		
		echo "Awaiting";
		
	}
?></b></li>
<li>3.&nbsp;Complete Your Tags &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($userid == 20){ echo "Done!";}else
	{
		
		echo "Awaiting";
		
	}
?></b></li>
<li>4.&nbsp;Upload Your Photo ID &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($phone == 20){ echo "Done!";}else
	{
		
		echo "Awaiting";
		
	}
?></b></li>
<li>5.&nbsp;Garda Clearnce Certificate &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($phone == 20){ echo "Done!";}else
	{
		
		echo "Awaiting";
		
	}
?></b></li>

</ul>
</p>



<p class="form-row form-row-half">
<h3 class="password-change-title"><?php _e( 'Only For Parents &nbsp;100%', 'woocommerce' ); ?></h3>
<ul>
<li>1.&nbsp;Complete Your Profile &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($userid == 20){ echo "Appoved";}else
	{
		
		echo '<p>Awaiting</p>';
		
	}
?>
</b></li>
<li>2.&nbsp;Connect Your Social Profile &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($phone == 20){ echo "Appoved";}else
	{
		
		echo "Awaiting";
		
	}
?></b></li>
<li>3.&nbsp;Complete Your Tags &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($userid == 20){ echo "Appoved";}else
	{
		
		echo "Awaiting";
		
	}
?></b></li>
<li>4.&nbsp;Upload Your Photo ID &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($phone == 20){ echo "Appoved";}else
	{
		
		echo "Awaiting";
		
	}
?></b></li>
<li>5.&nbsp;Upload Profe of Address &nbsp;<b>+<?php echo "&nbsp;20%&nbsp;"; if($phone == 20){ echo "Appoved";}else
	{
		
		echo "Awaiting";
		
	}
?></b></li>

</ul>
</p>
<?php wc_print_notices(); ?>
<form class="account_carer" action="" method="post" enctype="multipart/form-data">
	<?php //do_action( 'woocommerce_edit_account_form_start' ); ?>	 
	<h3 class="password-change-title"><?php _e( 'My Profile', 'woocommerce' ); ?></h3>
	<p class="form-row form-row-half">
		<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>		
		<input type="text" class="carer-input-text" name="user_meta[first_name]" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
	</p>
	<p class="form-row form-row-half">
		<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="user_meta[last_name]" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
	</p>
	<div class="clear"></div>
     <p class="form-row form-row-half">
		<label for="account_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" value="<?php echo esc_attr( $user->user_login ); ?>" readonly />
	</p>
	<p class="form-row form-row-half">
		<label for="account_email"><?php _e( 'Email Address', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="email" class="carer-input-text" value="<?php echo esc_attr( $user->user_email ); ?>" readonly />
	</p>	
    <div class="servicetype">
		<label>I am*</label></br>

       	<input type="radio" id='id_radio1' name="user_meta[usertype]" value="services_provider" <?php if($results['usertype']['0'] == 'services_provider'){ echo 'checked'; } ?>/> a provider of care services<br>
       	<input type="radio" id='id_radio2' name="user_meta[usertype]" value="looking_services" <?php if($results['usertype']['0'] == 'looking_services'){ echo 'checked'; } ?>/> a looking for care services</br>
	   	<input type="radio" id='id_radio3' name="user_meta[usertype]" value="dual" <?php if($results['usertype']['0'] == 'dual'){ echo 'checked'; } ?>/>a dual account (Used for care services provider & parent looking for care services)</br>
   </div>
	   </br></br>
	   <div class="clear"></div>
	   
	   <div class="id_radio1" style="display: none;">
		   <p class="form-row form-row-wide">
			<label for="account_requirement"><?php _e( 'I am a registing as', 'woocommerce' ); ?>  <span class="required">*</span></label></br>
			<input type="radio"  name="user_meta[servicetype]" value="individual" <?php if($results['servicetype']['0'] == 'individual'){ echo 'checked'; } ?>/>An individual</br>
			<input type="radio" name="user_meta[servicetype]" value="company" <?php if($results['servicetype']['0'] == 'company'){ echo 'checked'; } ?>/>A Company</br>
		   
			</p>
		</div>
			 </br>
			 <div class="clear"></div>
		<div class="id_radio22" style="display:none;">
			<p class="form-row form-row-wide">
			<label for="account_requirement"><?php _e( 'I am a registing as', 'woocommerce' ); ?>  <span class="required">*</span></label></br>
			
			<input type="radio" name="user_meta[servicetype]" value="dualParentcaree">An individual Parent and carer<br>
			<input type="radio" name="user_meta[servicetype]" value="dualCompany" > A Company<br><br>
			
			</p>
		</div>
		<div class="clear"></div>
		<p class="form-row form-row-wide">
		<label for="account_requirement"><?php _e( 'Gender', 'woocommerce' ); ?></label></br>
		<input type="radio" name="user_meta[gendersex]" value="male" checked /> Male<br>
        <input type="radio" name="user_meta[gendersex]" value="female" > Female<br><br>
	    </p>
		<div class="clear"></div>
        <p class="form-row form-row-half">
		<label for="account_address"><?php _e( 'Address', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="user_meta[address]" id="account_address" value="<?php echo esc_attr( $results['address']['0']); ?>" />
	      </p>
	     <p class="form-row form-row-half">
		<label for="account_town"><?php _e( 'Town', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="user_meta[town]" id="account_town" value="<?php echo esc_attr( $results['town']['0']); ?>" />
	    </p>
	    <div class="clear"></div>
         <p class="form-row form-row-half">
		<label for="account_country"><?php _e( 'Country', 'woocommerce' ); ?> <span class="required">*</span></label>
		<select class="carer-input-text" name="user_meta[country]">	
			<?php foreach($countries as $key => $value){				
				echo '<option value="'.$key.'" '.($key == $results['country']['0'] ? 'selected=selected':'').'>'.$value.'</option>';
			};?>	
		</select>
	</p>
	<p class="form-row form-row-half">
		<label for="account_dob"><?php _e( 'Date Of Birth', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="user_meta[date-of-birth]" id="datepicker" required="true" value="<?php echo esc_attr( $results['date-of-birth']['0']); ?>"/>
	</p>
    <p class="form-row form-row-half">
		<label for="account_Mobile"><?php _e( 'Mobile Number', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="user_meta[mobilenumber]" maxlength="10" id="account_mobile" value="<?php echo esc_attr( $results['mobilenumber']['0']); ?>" />
	</p>
	<p class="form-row form-row-half">
		<label for="account_homenumber"><?php _e( 'Home phone Number', 'woocommerce' ); ?></label>
		<input type="text" class="carer-input-text" name="user_meta[homenumber]" maxlength="10" id="account_homenumber" value="<?php echo esc_attr( $results['homenumber']['0']); ?>" />
	</p>
	<div class="clear"></div>		
	<p class="form-row form-row-half">
		<label for="account_marital"><?php _e( 'Marital Satus', 'woocommerce' ); ?> <span class="required">*</span></label>
		<select class="carer-input-text" name="user_meta[marital]">		
	      	<option value="Single" <?php if($results['marital']['0'] == 'Single'){ echo 'checked'; }?>>Single</option> 
         	<option value="Married" <?php if($results['marital']['0'] == 'Married'){ echo 'selected'; }?>>Married</option>
       </select>
	</p>
	<p class="form-row form-row-half">
		<label for="account_smoke"><?php _e( 'Do you Smoke?', 'woocommerce' ); ?> <span class="required">*</span></label>
		<select class="carer-input-text" name="user_meta[smoke]">
	       	<option value="yes" <?php if($results['smoke']['0'] == 'yes'){ echo 'selected'; }?>>Yes</option> 
         	<option value="no" <?php if($results['smoke']['0'] == 'no'){ echo 'selected'; }?>>No</option>
        </select>
	</p>
	<div class="clear"></div>
	<p class="form-row form-row-half">
		<label for="account_ownchildren"><?php _e( 'Your Own Children', 'woocommerce' ); ?> <span class="required">*</span></label>
		<select class="carer-input-text" name="user_meta[childrenstatus]">
	       	<option value="yes" <?php if($results['childrenstatus']['0'] == 'yes'){ echo 'selected'; }?>>Yes</option> 
         	<option value="no" <?php if($results['childrenstatus']['0'] == 'yes'){ echo 'selected'; }?>>No</option>
        </select>
	</p>
	<p class="form-row form-row-half">
		<label for="account_document"><?php _e( 'Upload Document For a review', 'woocommerce' ); ?> <span class="required">*</span></label>
		<?php
		echo '<pre>';
		if($results['user_image']['0']){
			echo '<img src="'.$results['user_image']['0'].'" width="100px"/>';
		}
		echo '</pre>';
		?>
		<input class="carer-input-text" type="file" name="file">
	</p>
	<div class="clear"></div></br>
	   	<p class="form-row form-row-wide">
			<label for="account_aboutme"><?php _e( 'About me', 'woocommerce' ); ?> </label>		
			<textarea name="user_meta[aboutme]"><?= $results['aboutme']['0']; ?></textarea>
	    </p>
		<div class="clear"></div>
		<p class="form-row form-row-wide">
			<label for="account_requirement"><?php _e( 'My care Requirements', 'woocommerce' ); ?> </label>
			<textarea name="user_meta[requirement]"><?= $results['requirement']['0']; ?></textarea>
	    </p>
	    <div class="clear"></div>
	    <div class="id_radio1" style="display: none;">
			<p class="form-row form-row-wide">
			<label for="account_requirement"><?php _e( 'Select <b>Tages</b> That are relevant to the services you are offering as a carer', 'woocommerce' ); ?>  <span class="required">*</span></label></br>
			<?php
			 $defaults = array( 'taxonomy' => 'job_listing_category' );
			    $args = wp_parse_args( $args, $defaults );			 
			    $taxonomy = $args['taxonomy'];			 
			    /**
			     * Filter the taxonomy used to retrieve terms when calling {@see get_categories()}.
			     *
			     * @since 2.7.0
			     *
			     * @param string $taxonomy Taxonomy to retrieve terms from.
			     * @param array  $args     An array of arguments. See {@see get_terms()}.
			     */
			    $taxonomy = apply_filters( 'get_categories_taxonomy', $taxonomy, $args );
			 
			    // Back compat
			    if ( isset($args['type']) && 'link' == $args['type'] ) {
			        /* translators: 1: "type => link", 2: "taxonomy => link_category" alternative */
			        _deprecated_argument( __FUNCTION__, '3.0',
			            sprintf( __( '%1$s is deprecated. Use %2$s instead.' ),
			                '<code>type => link</code>',
			                '<code>taxonomy => link_category</code>'
			            )
			        );
			        $taxonomy = $args['taxonomy'] = 'link_category';
			    }			 
			    $categories = (array) get_terms( $taxonomy, $args );
			    $ctags_ = explode(',', $results['carertags']['0']);
				foreach ($categories as $key => $value) { ?>
					<input type="checkbox" name="user_meta[carertags][]" value="<?= $value->term_id ?>" <?php if(in_array($value->term_id, $ctags_)){ echo "checked"; } ?>><?= $value->name ?>;
				<?php } ?>			
		    </p>
	    </div>
		<div class="clear"></div>
	    <div class="id_radio2" style="display: none;">
			<p class="form-row form-row-wide">
			<label for="account_requirement"><?php _e( 'Select <b>Tages</b> That are relevant to the services you are offering as Parent', 'woocommerce' ); ?>  <span class="required">*</span></label></br>
			<?php
			$ptags_ = explode(',', $results['parentags']['0']);
			foreach ($categories as $key => $value) { ?>				
				<input type="checkbox" name="user_meta[parentags][]" value="<?= $value->term_id ?>" <?php if(in_array($value->term_id, $ptags_)){ echo "checked"; } ?>><?= $value->name ?>;
			<?php } ?>
			
		    </p>
		</div>
		<div class="clear"></div>			
		<p class="form-row form-row-wide">
			<input type="checkbox" name="user_meta[newsletter]" required="true" 
			<?php if($results['newsletter']['0']){ echo 'checked'; } ?>
			><span>I Would like to Subscribe to Irishcare Newsletter.</span>
		</p>		
	<?php //do_action( 'woocommerce_edit_account_form' ); ?>
	<p>
		<?php //wp_nonce_field( 'save_account_details' ); ?>
		<input type="submit" class="button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="save_account_details" />
	</p>
	<?php //do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<script type="text/javascript">
	$(document).ready(function(){
		$( "#datepicker" ).datepicker();
		$(".servicetype input").click(function(){			
			$(".id_radio1, .id_radio2, .id_radio22").hide()
			//$("."+$(this).attr('id')).toggle()
			if($(this).attr('id') == 'id_radio1'){
				$(".id_radio1").show()
			}
			if($(this).attr('id') == 'id_radio2'){
				$(".id_radio2").show()
			}
			if($(this).attr('id') == 'id_radio3'){
				$(".id_radio22").show()
				$(".id_radio2").show()
			}
		})
	})
</script>

       
   