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
       global $userdata,$wpdb,$post;
       get_currentuserinfo();

       $current_user = wp_get_current_user();
	   $user_current_id = $current_user->ID;


          
 
		          $usertype = $_POST["usertype"];
		          $servicetype = $_POST["servicetype"];
				  $gender = $_POST["gendersex"];
                  $address = $_POST["address"];
                  $town = $_POST["town"];
                  $country = $_POST["country"];
                  $dateofbirth = $_POST["date-of-birth"];
				  $mobilenumber = $_POST["mobilenumber"];
                  $homenumber = $_POST["homenumber"];
				  $maritalstatus = $_POST["marital"];
				  $smoke = $_POST["smoke"];
				  $childrenstatus = $_POST["childrenstatus"];
				  $aboutme = $_POST["aboutme"];
				  $requirement = $_POST["requirement"];
				  $tags = $_POST['tags'];
				   
                  $chk="";  
                  foreach($tags as $chk1)  
                   {  
                   $chk.= $chk1.",";  
                     }
				  


             
			  
      $results = $wpdb->get_results("SELECT * FROM wp_dmfw_usercare where user_current_id = '".$user_current_id."'", OBJECT );
                
				 print_r($results);
				 $sql = $wpdb->query("INSERT INTO `wp_dmfw_usercare`(user_current_id,usertype,servicetype,gender,address,town,country,dateofbirth,mobilenumber,homenumber,maritalstatus,smoke,childrenstatus,aboutme,carerequirement,tags)VALUES('$user_current_id','$usertype','$servicetype','$gender','$address','$town','$country','$dateofbirth','$mobilenumber','$homenumber','$maritalstatus','$smoke','$childrenstatus','$aboutme','$requirement','$chk')");                

     $res = $wpdb->query($sql);
				 

if (count ($results) > 0) {
	$row = current($results);
	$wpdb->query("UPDATE `wp_dmfw_usercare` SET usertype='$usertype',servicetype='$servicetype',gender='$gender',address=$address,town=$town,country='$country',dateofbirth='$dateofbirth',mobilenumber=$mobilenumber,homenumber='$homenumber',maritalstatus='$maritalstatus',smoke='$smoke',childrenstatus='$childrenstatus',aboutme='$aboutme',carerequirement='$requirement',tags='$chk' WHERE user_current_id = '".$user_current_id."'");
	
	echo "greater";
} else {
echo "low";
 $sql = $wpdb->query("INSERT INTO `wp_dmfw_usercare`(user_current_id,usertype,servicetype,gender,address,town,country,dateofbirth,mobilenumber,homenumber,maritalstatus,smoke,childrenstatus,aboutme,carerequirement,tags)VALUES('$user_current_id','$usertype','$servicetype','$gender','$address','$town','$country','$dateofbirth','$mobilenumber','$homenumber','$maritalstatus','$smoke','$childrenstatus','$aboutme','$requirement','$chk')");                

     $res = $wpdb->query($sql);
	 
 echo "<script type='text/javascript'>
        window.location=document.location.href="/my-account/";
        </script>";
		
		
		echo "<h2>Sucessfully Updated</h3>";
		
		  }
	 


?>


<?php wc_print_notices(); ?>

<form class="account_carer" action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
<h3 class="password-change-title"><?php _e( 'My Profile', 'woocommerce' ); ?></h3>
	<p class="form-row form-row-half">
		<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
	</p>
	<p class="form-row form-row-half">
		<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
	</p>
	<div class="clear"></div>
     <p class="form-row form-row-half">
		<label for="account_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="account_username" id="account_first_name" value="<?php echo esc_attr( $user->user_login ); ?>" readonly />
	</p>
	<p class="form-row form-row-half">
		<label for="account_email"><?php _e( 'Email Address', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="email" class="carer-input-text" name="account_email" id="account_last_name" value="<?php echo esc_attr( $user->user_email ); ?>" readonly />
	</p>
	
	
	    <fieldset>
		<label>I am*</label></br>
		
       <input type="radio" id='id_radio1' name="usertype" value="services_provider" checked> a provider of care services<br>
       <input type="radio" id='id_radio2' name="usertype" value="looking_services" > a looking for care services</br>
	   <input type="radio" id='id_radio3' name="usertype" value="dual" >a dual account (Used for care services provider & parent looking for care services)</br>
	   </fieldset></br></br>
	   <div class="clear"></div>
	   <div id="services_provider">
	   <p class="form-row form-row-wide">
		<label for="account_requirement"><?php _e( 'I am a registing as', 'woocommerce' ); ?>  <span class="required">*</span></label></br>
		
		
		<input type="radio"  name="servicetype" value="individual" />An individual</br>
		<input type="radio" name="servicetype" value="Company" />A Company</br>
       
	    </p>
		     </div></br>
			 <div class="clear"></div>
		<div id="dual">
		<p class="form-row form-row-wide">
		<label for="account_requirement"><?php _e( 'I am a registing as', 'woocommerce' ); ?>  <span class="required">*</span></label></br>
		
		<input type="radio" name="servicetype" value="dualParentcaree">An individual Parent and carer<br>
        <input type="radio" name="servicetype" value="dualCompany" > A Company<br><br>
		
	    </p>
		</div>
		<div class="clear"></div>
		<p class="form-row form-row-wide">
		<label for="account_requirement"><?php _e( 'Gender', 'woocommerce' ); ?></label></br>
		<input type="radio" name="gendersex" value="male" checked /> Male<br>
        <input type="radio" name="gendersex" value="female" > Female<br><br>
	    </p>
		<div class="clear"></div>
        <p class="form-row form-row-half">
		<label for="account_address"><?php _e( 'Address', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="address" id="account_address" />
	      </p>
	     <p class="form-row form-row-half">
		<label for="account_town"><?php _e( 'Town', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="town" id="account_town" />
	    </p>
	    <div class="clear"></div>
         <p class="form-row form-row-half">
		<label for="account_country"><?php _e( 'Country', 'woocommerce' ); ?> <span class="required">*</span></label>
		<select class="carer-input-text" name="country">
	
	<option value="AF">Afghanistan</option>
	<option value="AX">Åland Islands</option>
	<option value="AL">Albania</option>
	<option value="DZ">Algeria</option>
	<option value="AS">American Samoa</option>
	<option value="AD">Andorra</option>
	<option value="AO">Angola</option>
	<option value="AI">Anguilla</option>
	<option value="AQ">Antarctica</option>
	<option value="AG">Antigua and Barbuda</option>
	<option value="AR">Argentina</option>
	<option value="AM">Armenia</option>
	<option value="AW">Aruba</option>
	<option value="AU">Australia</option>
	<option value="AT">Austria</option>
	<option value="AZ">Azerbaijan</option>
	<option value="BS">Bahamas</option>
	<option value="BH">Bahrain</option>
	<option value="BD">Bangladesh</option>
	<option value="BB">Barbados</option>
	<option value="BY">Belarus</option>
	<option value="BE">Belgium</option>
	<option value="BZ">Belize</option>
	<option value="BJ">Benin</option>
	<option value="BM">Bermuda</option>
	<option value="BT">Bhutan</option>
	<option value="BO">Bolivia, Plurinational State of</option>
	<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
	<option value="BA">Bosnia and Herzegovina</option>
	<option value="BW">Botswana</option>
	<option value="BV">Bouvet Island</option>
	<option value="BR">Brazil</option>
	<option value="IO">British Indian Ocean Territory</option>
	<option value="BN">Brunei Darussalam</option>
	<option value="BG">Bulgaria</option>
	<option value="BF">Burkina Faso</option>
	<option value="BI">Burundi</option>
	<option value="KH">Cambodia</option>
	<option value="CM">Cameroon</option>
	<option value="CA">Canada</option>
	<option value="CV">Cape Verde</option>
	<option value="KY">Cayman Islands</option>
	<option value="CF">Central African Republic</option>
	<option value="TD">Chad</option>
	<option value="CL">Chile</option>
	<option value="CN">China</option>
	<option value="CX">Christmas Island</option>
	<option value="CC">Cocos (Keeling) Islands</option>
	<option value="CO">Colombia</option>
	<option value="KM">Comoros</option>
	<option value="CG">Congo</option>
	<option value="CD">Congo, the Democratic Republic of the</option>
	<option value="CK">Cook Islands</option>
	<option value="CR">Costa Rica</option>
	<option value="CI">Côte d'Ivoire</option>
	<option value="HR">Croatia</option>
	<option value="CU">Cuba</option>
	<option value="CW">Curaçao</option>
	<option value="CY">Cyprus</option>
	<option value="CZ">Czech Republic</option>
	<option value="DK">Denmark</option>
	<option value="DJ">Djibouti</option>
	<option value="DM">Dominica</option>
	<option value="DO">Dominican Republic</option>
	<option value="EC">Ecuador</option>
	<option value="EG">Egypt</option>
	<option value="SV">El Salvador</option>
	<option value="GQ">Equatorial Guinea</option>
	<option value="ER">Eritrea</option>
	<option value="EE">Estonia</option>
	<option value="ET">Ethiopia</option>
	<option value="FK">Falkland Islands (Malvinas)</option>
	<option value="FO">Faroe Islands</option>
	<option value="FJ">Fiji</option>
	<option value="FI">Finland</option>
	<option value="FR">France</option>
	<option value="GF">French Guiana</option>
	<option value="PF">French Polynesia</option>
	<option value="TF">French Southern Territories</option>
	<option value="GA">Gabon</option>
	<option value="GM">Gambia</option>
	<option value="GE">Georgia</option>
	<option value="DE">Germany</option>
	<option value="GH">Ghana</option>
	<option value="GI">Gibraltar</option>
	<option value="GR">Greece</option>
	<option value="GL">Greenland</option>
	<option value="GD">Grenada</option>
	<option value="GP">Guadeloupe</option>
	<option value="GU">Guam</option>
	<option value="GT">Guatemala</option>
	<option value="GG">Guernsey</option>
	<option value="GN">Guinea</option>
	<option value="GW">Guinea-Bissau</option>
	<option value="GY">Guyana</option>
	<option value="HT">Haiti</option>
	<option value="HM">Heard Island and McDonald Islands</option>
	<option value="VA">Holy See (Vatican City State)</option>
	<option value="HN">Honduras</option>
	<option value="HK">Hong Kong</option>
	<option value="HU">Hungary</option>
	<option value="IS">Iceland</option>
	<option value="IN">India</option>
	<option value="ID">Indonesia</option>
	<option value="IR">Iran, Islamic Republic of</option>
	<option value="IQ">Iraq</option>
	<option value="IE">Ireland</option>
	<option value="IM">Isle of Man</option>
	<option value="IL">Israel</option>
	<option value="IT">Italy</option>
	<option value="JM">Jamaica</option>
	<option value="JP">Japan</option>
	<option value="JE">Jersey</option>
	<option value="JO">Jordan</option>
	<option value="KZ">Kazakhstan</option>
	<option value="KE">Kenya</option>
	<option value="KI">Kiribati</option>
	<option value="KP">Korea, Democratic People's Republic of</option>
	<option value="KR">Korea, Republic of</option>
	<option value="KW">Kuwait</option>
	<option value="KG">Kyrgyzstan</option>
	<option value="LA">Lao People's Democratic Republic</option>
	<option value="LV">Latvia</option>
	<option value="LB">Lebanon</option>
	<option value="LS">Lesotho</option>
	<option value="LR">Liberia</option>
	<option value="LY">Libya</option>
	<option value="LI">Liechtenstein</option>
	<option value="LT">Lithuania</option>
	<option value="LU">Luxembourg</option>
	<option value="MO">Macao</option>
	<option value="MK">Macedonia, the former Yugoslav Republic of</option>
	<option value="MG">Madagascar</option>
	<option value="MW">Malawi</option>
	<option value="MY">Malaysia</option>
	<option value="MV">Maldives</option>
	<option value="ML">Mali</option>
	<option value="MT">Malta</option>
	<option value="MH">Marshall Islands</option>
	<option value="MQ">Martinique</option>
	<option value="MR">Mauritania</option>
	<option value="MU">Mauritius</option>
	<option value="YT">Mayotte</option>
	<option value="MX">Mexico</option>
	<option value="FM">Micronesia, Federated States of</option>
	<option value="MD">Moldova, Republic of</option>
	<option value="MC">Monaco</option>
	<option value="MN">Mongolia</option>
	<option value="ME">Montenegro</option>
	<option value="MS">Montserrat</option>
	<option value="MA">Morocco</option>
	<option value="MZ">Mozambique</option>
	<option value="MM">Myanmar</option>
	<option value="NA">Namibia</option>
	<option value="NR">Nauru</option>
	<option value="NP">Nepal</option>
	<option value="NL">Netherlands</option>
	<option value="NC">New Caledonia</option>
	<option value="NZ">New Zealand</option>
	<option value="NI">Nicaragua</option>
	<option value="NE">Niger</option>
	<option value="NG">Nigeria</option>
	<option value="NU">Niue</option>
	<option value="NF">Norfolk Island</option>
	<option value="MP">Northern Mariana Islands</option>
	<option value="NO">Norway</option>
	<option value="OM">Oman</option>
	<option value="PK">Pakistan</option>
	<option value="PW">Palau</option>
	<option value="PS">Palestinian Territory, Occupied</option>
	<option value="PA">Panama</option>
	<option value="PG">Papua New Guinea</option>
	<option value="PY">Paraguay</option>
	<option value="PE">Peru</option>
	<option value="PH">Philippines</option>
	<option value="PN">Pitcairn</option>
	<option value="PL">Poland</option>
	<option value="PT">Portugal</option>
	<option value="PR">Puerto Rico</option>
	<option value="QA">Qatar</option>
	<option value="RE">Réunion</option>
	<option value="RO">Romania</option>
	<option value="RU">Russian Federation</option>
	<option value="RW">Rwanda</option>
	<option value="BL">Saint Barthélemy</option>
	<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
	<option value="KN">Saint Kitts and Nevis</option>
	<option value="LC">Saint Lucia</option>
	<option value="MF">Saint Martin (French part)</option>
	<option value="PM">Saint Pierre and Miquelon</option>
	<option value="VC">Saint Vincent and the Grenadines</option>
	<option value="WS">Samoa</option>
	<option value="SM">San Marino</option>
	<option value="ST">Sao Tome and Principe</option>
	<option value="SA">Saudi Arabia</option>
	<option value="SN">Senegal</option>
	<option value="RS">Serbia</option>
	<option value="SC">Seychelles</option>
	<option value="SL">Sierra Leone</option>
	<option value="SG">Singapore</option>
	<option value="SX">Sint Maarten (Dutch part)</option>
	<option value="SK">Slovakia</option>
	<option value="SI">Slovenia</option>
	<option value="SB">Solomon Islands</option>
	<option value="SO">Somalia</option>
	<option value="ZA">South Africa</option>
	<option value="GS">South Georgia and the South Sandwich Islands</option>
	<option value="SS">South Sudan</option>
	<option value="ES">Spain</option>
	<option value="LK">Sri Lanka</option>
	<option value="SD">Sudan</option>
	<option value="SR">Suriname</option>
	<option value="SJ">Svalbard and Jan Mayen</option>
	<option value="SZ">Swaziland</option>
	<option value="SE">Sweden</option>
	<option value="CH">Switzerland</option>
	<option value="SY">Syrian Arab Republic</option>
	<option value="TW">Taiwan, Province of China</option>
	<option value="TJ">Tajikistan</option>
	<option value="TZ">Tanzania, United Republic of</option>
	<option value="TH">Thailand</option>
	<option value="TL">Timor-Leste</option>
	<option value="TG">Togo</option>
	<option value="TK">Tokelau</option>
	<option value="TO">Tonga</option>
	<option value="TT">Trinidad and Tobago</option>
	<option value="TN">Tunisia</option>
	<option value="TR">Turkey</option>
	<option value="TM">Turkmenistan</option>
	<option value="TC">Turks and Caicos Islands</option>
	<option value="TV">Tuvalu</option>
	<option value="UG">Uganda</option>
	<option value="UA">Ukraine</option>
	<option value="AE">United Arab Emirates</option>
	<option value="GB">United Kingdom</option>
	<option value="US">United States</option>
	<option value="UM">United States Minor Outlying Islands</option>
	<option value="UY">Uruguay</option>
	<option value="UZ">Uzbekistan</option>
	<option value="VU">Vanuatu</option>
	<option value="VE">Venezuela, Bolivarian Republic of</option>
	<option value="VN">Viet Nam</option>
	<option value="VG">Virgin Islands, British</option>
	<option value="VI">Virgin Islands, U.S.</option>
	<option value="WF">Wallis and Futuna</option>
	<option value="EH">Western Sahara</option>
	<option value="YE">Yemen</option>
	<option value="ZM">Zambia</option>
	<option value="ZW">Zimbabwe</option>
     </select>
	</p>
	<p class="form-row form-row-half">
		<label for="account_dob"><?php _e( 'Date Of Birth', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="date-of-birth" id="datepicker" required="true"/>
	</p>
		
		
		     <p class="form-row form-row-half">
		<label for="account_Mobile"><?php _e( 'Mobile Number', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="mobilenumber" id="account_mobile" />
	</p>
	<p class="form-row form-row-half">
		<label for="account_homenumber"><?php _e( 'Home phone Number', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="carer-input-text" name="homenumber" id="account_homenumber" />
	</p>
	<div class="clear"></div>
		
		 <p class="form-row form-row-half">
		<label for="account_marital"><?php _e( 'Marital Satus', 'woocommerce' ); ?> <span class="required">*</span></label>
		<select class="carer-input-text" name="marital">
	      <option value="Single" selected>Single</option> 
         <option value="Married">Married</option>
       </select>
	</p>
	<p class="form-row form-row-half">
		<label for="account_smoke"><?php _e( 'Do you Smoke?', 'woocommerce' ); ?> <span class="required">*</span></label>
		<select class="carer-input-text" name="smoke">
	       <option value="yes" selected>Yes</option> 
         <option value="no">No</option>
         </select>
	</p>
	<div class="clear"></div>
	<p class="form-row form-row-half">
		<label for="account_ownchildren"><?php _e( 'Your Own Children', 'woocommerce' ); ?> <span class="required">*</span></label>
		<select class="carer-input-text" name="childrenstatus">
	       <option value="yes" selected>Yes</option> 
         <option value="no">No</option>
         </select>
	</p>
	<p class="form-row form-row-half">
		<label for="account_document"><?php _e( 'Upload Document For a review', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input class="carer-input-text" type="file" name="file">
	</p>
	<div class="clear"></div></br>
	   <p class="form-row form-row-wide">
		<label for="account_aboutme"><?php _e( 'About me', 'woocommerce' ); ?> </label>
		
		<textarea name="aboutme">
		
		</textarea>
	    </p>
			<div class="clear"></div>
			<p class="form-row form-row-wide">
		<label for="account_requirement"><?php _e( 'My care Requirements', 'woocommerce' ); ?> </label>
		<textarea name="requirement">
		</textarea>
	    </p>
	    <div class="clear"></div>
		<p class="form-row form-row-wide">
		<label for="account_requirement"><?php _e( 'Select <b>Tages</b> That are relevant to the services you are offering as a carer', 'woocommerce' ); ?>  <span class="required">*</span></label></br>
		
		<input type="checkbox" name="tags[]" value="aupair">Au Pair
		<input type="checkbox" name="tags[]" value="schoolnanny">After school Nanny
		<input type="checkbox" name="tags[]" value="babbysitter">Babaysitter</br>
		<input type="checkbox" name="tags[]" value="fulltime_nanny">Full Time Nanny
		<input type="checkbox" name="tags[]" value="housekeeper">House Keeper
		<input type="checkbox" name="tags[]" value="liveinnanny">Live in nanny</br>
		<input type="checkbox" name="tags[]" value="liveoutnanny">Live out nanny
		<input type="checkbox" name="tags[]" value="maternitynurse">Maternity Nurse
		<input type="checkbox" name="tags[]" value="motherhelp">Mother Help</br>
		<input type="checkbox" name="tags[]" value="nannyshare">Nanny Share
		<input type="checkbox" name="tags[]" value="nightnany">Night Nanny
		<input type="checkbox" name="tags[]" value="nursery">Nursery</br>
		<input type="checkbox" name="tags[]" value="parttimenanny">Part Time Nanny
		<input type="checkbox" name="tags[]" value="privatemidwife">Private Midewife
		<input type="checkbox" name="tags[]" value="privatetutor">Private Tutor</br>
		<input type="checkbox" name="tags[]" value="registerchilminder">Register childMinder
		<input type="checkbox" name="tags[]" value="specialneedsassistance">Special Needs Assistance
		
	    </p>
		
		<div class="clear"></div>
			<p class="form-row form-row-wide">
		
		<input type="checkbox" name="gender" required="true"><span>I Would like to Subscribe to Irishcare Newsletter.</span>
		</p>
		
		
	<?php //do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php //wp_nonce_field( 'save_account_details' ); ?>
		<input type="submit" class="button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php //do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>

