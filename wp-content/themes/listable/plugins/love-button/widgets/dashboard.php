<?php 

class delucksLoveButtonDashboardWidget extends WP_Widget {

	function delucksLoveButtonDashboardWidget($loveButton) {
		$this->loveButton = $loveButton;
	}

	/**
	 * Add the widget to the dashboard
	 **/
	function addDashboardWidget(){
		wp_add_dashboard_widget('love-button-dashboard-widget', __('Love Button - Visual Overview', $this->loveButton->pluginHook), array($this, 'widget'));
		add_action('admin_print_scripts-index.php', array($this, 'addJavascript'));
		add_action('admin_head-index.php', array($this, 'addHeadData'));
	}
	
	/**
	 * Add the scripts to the admin
	 **/
	function addJavascript(){
		echo "<script type='text/javascript' src='https://www.google.com/jsapi'></script>\n";
		echo '<script type="text/javascript">';
		echo 'google.load("visualization", "1", {packages:["corechart"]});';
		echo '</script>';
	}
	
	/**
	 * Add the Head Data to the top
	 **/
	function addHeadData(){
		echo "<link rel='stylesheet' href='".plugins_url( '/love-button/be/style.css', __FILE__ )."' type='text/css' />\n";
	?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				if(typeof(google) != 'undefined'){
					jQuery.ajax({ url: loveButtonAjaxUrl+'/?delucksAjax[method]=getPieTotals&delucksAjax[params][dashboard]=true', dataType: 'json', success: function(delucksLoveButtonPieTotals){
						var pieData = [];
						var sliceOptions = [];
						pieData.push(['Netzwerk', 'Klicks']);
						jQuery.ajax({ url: loveButtonAjaxUrl+'/?delucksAjax[method]=getAvailableNetworks', success: function(delucksAvailableNetworks){
							jQuery(delucksAvailableNetworks).each(function(nk, network){
								jQuery('.loveButtonStatistics thead tr').append('<th class="'+network+'"></th>');
								pieData.push([network, delucksLoveButtonPieTotals[network]]);
								sliceOptions.push({ color: jQuery('.loveButtonStatistics thead th.'+network).css('backgroundColor') });
							});

							var data = google.visualization.arrayToDataTable(pieData);
							var options = { 
								slices: sliceOptions,
								backgroundColor: 'none',
							    is3D: true
							};
							var chart = new google.visualization.PieChart(document.getElementById('loveButtonDashboardWidgetTitle_chart_div'));
							chart.draw(data, options);
						}, dataType: 'json' });
					}});
				}
			});
		</script>
	<?php }

	function widget( $args, $instance ) {
		echo '<p class="loveButtonDashboardWidgetTitle">'.__('Visual overview of the last 7 days', $this->loveButton->pluginHook).'</p>';
		echo '<p><a href="/wp-admin/options-general.php?page=delucks-love-button">'.__('View statistics', $this->loveButton->pluginHook).'</a></p>';
		echo '<div id="loveButtonDashboardWidgetTitle_chart_div" style="width: 600px; height: 350px;"></div>';
		echo '<table class="loveButtonStatistics" style="display: none;"><thead><tr></tr></thead></table>';
	}

}

add_action('wp_dashboard_setup', array(new delucksLoveButtonDashboardWidget($loveButton), 'addDashboardWidget'));

?>