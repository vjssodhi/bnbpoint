<?php
/**

template name:profile


***/

get_header(); ?>



<?php

global $wpdb;


                if(isset($_POST['s_add'])){
				
				 $dest = $_FILES['ins_image']['name'];
                $e_upd_img =$_FILES['ins_image']['tmp_name'];
                $path2="images/".$dest;
                 if(move_uploaded_file($e_upd_img,$path2))
                {
                echo "Updated Image succesfully<br>";
                }
                else
                {
                echo "Fail to update file";
                } 
				
  }
  
  
		?>
<div id="primary" class="content-area">
	
	<h3>Slider Management</h3>
     <form name="slider" method="POST" enctype="multipart/form-data" action="">     

         <ul>
             <li><label for="ftitle">Enter the Title </label>
             <input id="ftitle" maxlength="45" size="30" name="ins_title" value="" /></li>   
             
              
              
             <li><label for="ftitle">Add New Slide </label>
             <input id="fslide" type="file" name="ins_image"  value="" /></li> 
             

              <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;<input class=’button-primary’ type="Submit" name="s_add" value="Add"/></td>   

               </tr>    
              
     </ul>
   </form> 
	
	
</div><!-- #primary -->
<?php
get_sidebar();
get_footer();

