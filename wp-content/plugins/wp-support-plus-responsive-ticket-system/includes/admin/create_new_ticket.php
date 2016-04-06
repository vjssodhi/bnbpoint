<?php 
global $wpdb;
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>
<h2>Report a Problem</h2>
<form id="frmCreateNewTicket">
     <div class="box">
     <div class="half">
    <div style="display:none;">
	  <span class="label label-info" style="font-size: 13px;">Subject</span><br>
	  <input value="user new ticket" type="text" id="create_ticket_subject" name="create_ticket_subject" maxlength="80" style="width: 95%; margin-top: 10px;"/><br><br>
	</div>
	<div>
		
		<label>Report a User</label><br>
		<select id="create_ticket_category" name="create_ticket_category" style="margin-top: 10px;">
			<?php 
			foreach ($categories as $category){
				echo '<option value="'.$category->id.'">'.$category->name.'</option>';
			}
			?>
		</select><br>
	</div>
	<div class="select_user">
	  
		<label>username of your abuser</label><br>
		<select id="create_ticket_category1" name="create_ticket_category1" style="margin-top: 10px;">
		<?php $user_queries = new WP_User_Query( array( 'exclude' => array( 1 ) ) ); //print('<pre>'); print_r($user_queries->results); print('</pre>');
		  echo '<option value="_none">Select</option>';
		 foreach($user_queries->results as $user_query){
			//print('<pre>'); print_r($user_query); print('</pre>');
		   echo '<option value="'.$user_query->data->ID.'">'.$user_query->data->display_name.'</option>';
		 }
		 ?>
		 </select><br>
	</div>
	<div class="complaint" style="display:none;">
	    <label>Choose Options</label><br>
	  	<select id="create_ticket_category2" name="create_ticket_category2" style="margin-top: 10px;">
			  <?php $user_queries = new WP_User_Query( array( 'exclude' => array( 1 ) ) ); //print('<pre>'); print_r($user_queries->results); print('</pre>');
		 
		  ?>
		  <option value="1">I am not getting Setisfactory service</option>
		  <option value="2">I have not received reply from my query</option>
		  <option value="3">Others</option>
		 </select><br>
	</div> 
	<div class="account_issue" style="display:none;">
	    <label>Choose Options</label><br>
		<select id="create_ticket_category3" name="create_ticket_category3" style="margin-top: 10px;">
			  <?php $user_queries = new WP_User_Query( array( 'exclude' => array( 1 ) ) ); //print('<pre>'); print_r($user_queries->results); print('</pre>');
		 
		  ?>
		  <option value="1">I notice a bug</option>
		  <option value="2">I can not log in</option>
		  <option value="3">I unable to book care providers</option>
		  <option value="4">I unable to contact parents</option>
		  <option value="4">Others</option>
	  </select><br>
	</div> 
	 <label>please provide us detail in the box below:</label><br>
	
	<textarea id="create_ticket_body" name="create_ticket_body" style="margin-top: 10px; width: 95%; overflow-y:hidden;" onkeyup='this.rows = (this.value.split("\n").length||1);'></textarea><br><br>
	<div style="display:none;">
		<span class="label label-info" style="font-size: 13px;">Priority</span><br>
		<select id="create_ticket_priority" name="create_ticket_priority" style="margin-top: 10px;">
			<option value="normal">Normal</option>
			<option value="high">High</option>
			<option value="medium">Medium</option>
			<option value="low">Low</option>
		</select>
	</div>
	<div style="display:none;">
		<span class="label label-info" style="font-size: 13px;">Attach File(s)</span><br>
		<input style="margin-top: 10px;" type="file" name="attachment[]" multiple>
	</div>
	<input type="hidden" name="action" value="createNewTicket">
	<input type="hidden" name="user_id" value="<?php echo $current_user->ID;?>">
	<input type="hidden" name="type" value="user">
	<input type="hidden" name="guest_name" value="">
	<input type="hidden" name="guest_email" value="">
	<input type="submit" class="btn btn-success" value="Submit Ticket">
	<input type="button" class="btn btn-success" value="Reset Form" onClick="this.form.reset()" />
	</div></div>
</form>
<?php global $wpdb;
/* wpdb class should not be called directly.global $wpdb variable is an instantiation of the class already set up to talk to the WordPress database */ 

$results = $wpdb->get_results( "SELECT id FROM wp_dmfw_wpsp_ticket ORDER BY id DESC");  
//print('<pre>'); print_r($result); print('</pre>');?>
  <div class="last_bx">
    <div class="box_content">
    <h3>Reported problems</h3>
    <h6>No problem reported yet!</h6>
    <div class="table_bx">
    <ul>
	<?php foreach($results as $result){ ?>
    <li><span>Issue</span> <?php echo $result->id; ?> (raised a dispute)</li>
    <?php } ?>
    </ul>    
    </div>
    
    <div class="half">
     <a href="#"><p>Load all issues below</p></a>
     </div>
     </div>
    <div class="icon">
    <img src="wp-content/themes/listable/images/arrow.jpg" alt="arrow-img"><br>
    <br>
    <a href="#">New cases on top</a>
    </div>
    </div>

<script> 
jQuery.noConflict();
   jQuery('#create_ticket_category').change(function() { 
		var aa = jQuery(this).val();
		if(aa == 5){
			jQuery('.complaint').show();
			jQuery('.select_user').hide();
			jQuery('.account_issue').hide();
		}else if(aa == 4){
			jQuery('.complaint').hide();
			jQuery('.select_user').hide();
			jQuery('.account_issue').show();
		}else{
			jQuery('.account_issue').hide();
		    jQuery('.complaint').hide();
			jQuery('.select_user').show();	
		}
        jQuery('#' + jQuery(this).val()).show();
 });

</script>