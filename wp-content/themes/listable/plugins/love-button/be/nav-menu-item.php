<?php 
/*
Love Button Free is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Love Button Free is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Love Button Free. If not, see <http://www.gnu.org/licenses/>.

NOTE:
Enabling the premium functions without a valid license makes this software
to another software version which is subject to the terms of http://love.delucks.com/agb
and no longer subject to the GNU/GPL.
*/

if ( !class_exists('LB_Nav_Item')) {
	class LB_Nav_Item {
		
		function __construct(){
			if(is_admin()){
				$this->admin_enqueue_scripts();
			} else {
				add_filter('wp_get_nav_menu_items', array(&$this, 'wp_get_nav_menu_items'));
			}
		}

		function admin_enqueue_scripts() {
			wp_enqueue_script('lb_nav_menu', plugins_url('js/nav-menu.js',__FILE__), array('jquery'));
		}

		function wp_get_nav_menu_items($items) {
			$new_items = array();
			foreach ($items as $key => $item) {
				$new_items[$key] = $item;
				if(count($item->classes)){
					foreach($item->classes as $k => $v){
						if($v == 'love-button-menu-item'){
							$new_items[$key]->title = '' . do_shortcode('[love-button]') . '';
						}
					}
				}
			}
			return $new_items;
		}

		public function add_nav_menu_meta_boxes() {
			add_meta_box('lb_nav_icon', __('Love Button'), array( $this, 'nav_menu_link'), 'nav-menus', 'side', 'high');
		}

        public function nav_menu_link() {
        	global $_nav_menu_placeholder, $nav_menu_selected_id;
			$_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;
        ?>
        	<div id="posttype-lb" class="posttypediv"> 
        		<div id="tabs-panel-lb" class="tabs-panel tabs-panel-active">
        			<ul id ="lb-checklist" class="categorychecklist form-no-clear">
        				<li>
        					<label class="menu-item-title">
        						<input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]" value="-1"> Love Button
        					</label>
        					<input type="hidden" value="custom" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" />
        					<input type="hidden" class="menu-item-title" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" value="Love Button">
        					<input type="hidden" class="menu-item-url" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-url]" value="#love-button">
        					<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-classes]" value="love-button-menu-item">

        				</li>
        			</ul>
        		</div>
        		<p class="button-controls">
        			<span class="add-to-menu">
        				<input type="submit" class="button-secondary submit-add-to-menu right" value="Zum Menü hinzufügen" name="add-post-type-menu-item" id="submit-posttype-lb">
        				<span class="spinner"></span>
        			</span>
        		</p>
        	</div>
        <?php }
    }
}

$custom_nav = new LB_Nav_Item;
add_action('admin_init', array($custom_nav, 'add_nav_menu_meta_boxes'));

?>