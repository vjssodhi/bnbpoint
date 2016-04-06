<?php 

class delucksLoveButtonSuggest extends WP_Widget {

	function delucksLoveButtonSuggest() {
		$this->loveButton = new delucksLoveButton(true);
		parent::__construct( false, __( 'New & Loved Articles', $this->loveButton->pluginHook ), array('description' => __( 'Shows the newest articles sorted by the number of hits on the love button', $this->loveButton->pluginHook )) );
	}

	function widget( $args, $instance ) {
		$articles = $this->getSuggest($instance['numDisplay'], $instance['range']);

		if(count($articles)){
			echo '<div class="widget LoveButtonSuggest">';
			if(isset($instance['title']) && strlen($instance['title'])){
				echo '<h2 class="widgettitle">'.$instance['title'].'</h2>';
			}
				
			echo '<ul>';
			if(count($articles)){
				foreach($articles as $article){
					echo '<li><a href="'.$article['url'].'">'.$article['post_title'].'</a></li>';
				}
			}
			echo '</ul>';
			echo '</div>';
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['numDisplay'] = strip_tags( $new_instance['numDisplay'] );
		$instance['range'] = strip_tags( $new_instance['range'] );
		return $instance;
	}

	function form( $instance ) {
		?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			
			<p>
			<label for="<?php echo $this->get_field_id( 'numDisplay' ); ?>"><?php _e( 'Number of articles, beeing displayed in frontend:', $this->loveButton->pluginHook ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'numDisplay' ); ?>" name="<?php echo $this->get_field_name( 'numDisplay' ); ?>" type="text" value="<?php echo esc_attr($instance['numDisplay']); ?>" size="1" />
			</p>
			
			<p>
			<label for="<?php echo $this->get_field_id( 'range' ); ?>"><?php _e( 'Space of time, where articles will be selected:', $this->loveButton->pluginHook ); ?></label><br/> 
			<?php _e( 'The last', $this->loveButton->pluginHook ); ?> <input id="<?php echo $this->get_field_id( 'range' ); ?>" name="<?php echo $this->get_field_name( 'range' ); ?>" type="text" value="<?php echo esc_attr($instance['range']); ?>" size="1" /> <?php _e( 'days', $this->loveButton->pluginHook ); ?>
			</p>
		<?php 
	}
	
	function filter_where($where = '') {
		$range = $this->range;
		$today = date('Y-m-d', current_time( 'timestamp' ));
		$dateRange = strtotime ( '-'.($range-1).' day' , strtotime ( $today ) ) ;
		$dateRange = date('Y-m-d', $dateRange);
		$where .= " AND post_date >= '" . $dateRange . "'";
		return $where;
	}
	
	/*
	 * get the suggest articles
	 * */
	function getSuggest($limit, $range){
		$arr = array();
		global $wpdb;
		$wpPrefix = $wpdb->get_blog_prefix(1);
		
		$this->range = $range;
		add_filter('posts_where', array($this, 'filter_where'));
		query_posts($query_string . 'showposts=100&post_status=publish');
		
		if (have_posts()) : while (have_posts()) : the_post();
			$posts[get_the_ID()] = get_post( get_the_ID(), ARRAY_A );
			$urls[] = post_permalink(get_the_ID());
			$urls[] = str_replace(get_bloginfo( 'wpurl' ),'',post_permalink(get_the_ID()));
		endwhile; endif;
		remove_filter('posts_where', array($this, 'filter_where'));
		
		wp_reset_query();
		
		$sql = "SELECT `id` FROM `".$wpPrefix.$this->loveButton->dbTable."` WHERE `url` IN ('".implode("','", $urls)."')";
		if($res = $wpdb->get_results($sql)){
			$ids = array();
			foreach($res as $row){
				$ids[] = $row->id;
			}
		}

		$sql = "SELECT COUNT(`network`) AS `total`, `id` FROM `".$wpPrefix.$this->loveButton->dbTableStatistics."` WHERE `id` IN ('".implode("','", $ids)."') AND `date` BETWEEN DATE_SUB( CONCAT( CURDATE( ) , ' CURTIME( )' ) , INTERVAL ".($range -1)." DAY ) AND NOW() GROUP BY `id` ORDER BY `total` DESC";

		if($res = $wpdb->get_results($sql)){
			$i = 0;
			$havePosts = array();
			foreach($res as $row){
				$url = $wpdb->get_var("SELECT `url` FROM `".$wpPrefix.$this->loveButton->dbTable."` WHERE `id` = " . $row->id);
				$postId = url_to_postid($url);
				$havePosts[] = $postId;
				$post = get_post( $postId, ARRAY_A );

				if($post && $post['post_status'] == 'publish' && strlen($post['post_title'])){
					$arr[$i] = $post;
					$arr[$i]['url'] = $url;
					$arr[$i]['count'] = $row->total;
					$i++;

					if($i == $limit){
						break;
					}
				}	
			}
			
			if(count($havePosts)){
				foreach($havePosts as $k => $v){
					unset($posts[$v]);
				}
			}

			if(count($posts)){
				foreach($posts as $k => $v){
					if($i == $limit){
						break;
					}
					$arr[$i] = $v;
					$arr[$i]['url'] = post_permalink($v['ID']);
					$arr[$i]['count'] = 0;
					$i++;
				}
			}
			return $arr;
		}
		return false;
	}

}

?>