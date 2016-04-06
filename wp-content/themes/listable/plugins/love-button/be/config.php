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
?>
<div id="delucks_loveButtonSettings" class="wrap">
	<div class="icon32"></div>
	<h2 class="title"><?php _e('Love Button', $this->pluginHook); ?></h2>
	<form action="options.php" method="post">
		<?php settings_fields($this->optionKey); ?>
		<div class="tabs">
			<div class="tabMenu">
				<div class="entry statistics" title="<?php echo _e('Statistics', $this->pluginHook);?>">&nbsp;</div>
				<div class="entry settings" title="<?php echo _e('Settings', $this->pluginHook);?>">&nbsp;</div>
			</div>
			<div class="tabContent">
				<div class="entry">
					<div class="container heading" style="width: 75%;"><?php echo _e('Statistics', $this->pluginHook);?></div>
					<div class="containerClear"></div>
					<div class="statisticsSettings">
						<?php echo _e('Show', $this->pluginHook);?>
						<select name="<?php echo ($this->optionKey)?>[stats][range]" class="statsRange">
							<option value="" <?php echo ($this->options['stats']['range'] == '' ? 'selected="selected"' : '')?>><?php echo _e('Total', $this->pluginHook);?></option>
							<option value="today" <?php echo ($this->options['stats']['range'] == 'today' ? 'selected="selected"' : '')?>><?php echo _e('Today', $this->pluginHook);?></option>
							<option value="yesterday" <?php echo ($this->options['stats']['range'] == 'yesterday' ? 'selected="selected"' : '')?>><?php echo _e('Yesterday', $this->pluginHook);?></option>
							<option value="currentWeek" <?php echo ($this->options['stats']['range'] == 'currentWeek' ? 'selected="selected"' : '')?>><?php echo _e('Current week', $this->pluginHook);?></option>
							<option value="lastWeek" <?php echo ($this->options['stats']['range'] == 'lastWeek' ? 'selected="selected"' : '')?>><?php echo _e('Last Week', $this->pluginHook);?></option>
							<option value="currentMonth" <?php echo ($this->options['stats']['range'] == 'currentMonth' ? 'selected="selected"' : '')?>><?php echo _e('Current Month', $this->pluginHook);?></option>
							<option value="lastMonth" <?php echo ($this->options['stats']['range'] == 'lastMonth' ? 'selected="selected"' : '')?>><?php echo _e('Last Month', $this->pluginHook);?></option>
							<option value="currentYear" <?php echo ($this->options['stats']['range'] == 'currentYear' ? 'selected="selected"' : '')?>><?php echo _e('Current Year', $this->pluginHook);?></option>
							<option value="lastYear" <?php echo ($this->options['stats']['range'] == 'lastYear' ? 'selected="selected"' : '')?>><?php echo _e('Last Year', $this->pluginHook);?></option>
						</select>
						<?php echo _e('From', $this->pluginHook);?>
						<select name="<?php echo ($this->optionKey)?>[stats][from]" class="statsFrom">
						<?php 
							echo '<option value="" '.($this->options['stats']['from'] == '' ? 'selected="selected"' : '').'>-</option>';
							for($i = 0; $i <= 23; $i++){
								echo '<option value="'.date('H:i', mktime($i, 0, 0)).'" '.($this->options['stats']['from'] == date('H:i', mktime($i, 0, 0)) ? 'selected="selected"' : '').'>'.date('H:i', mktime($i, 0, 0)).'</option>';
								echo '<option value="'.date('H:i', mktime($i, 30, 0)).'" '.($this->options['stats']['from'] == date('H:i', mktime($i, 30, 0)) ? 'selected="selected"' : '').'>'.date('H:i', mktime($i, 30, 0)).'</option>';
							}
						?>
						</select>
						<?php echo _e('to', $this->pluginHook);?>
						<select name="<?php echo ($this->optionKey)?>[stats][to]" class="statsTo">
						<?php 
							echo '<option value="" '.($this->options['stats']['to'] == '' ? 'selected="selected"' : '').'>-</option>';
							for($i = 0; $i <= 23; $i++){
								echo '<option value="'.date('H:i', mktime($i, 0, 0)).'" '.($this->options['stats']['to'] == date('H:i', mktime($i, 0, 0)) ? 'selected="selected"' : '').'>'.date('H:i', mktime($i, 0, 0)).'</option>';
								echo '<option value="'.date('H:i', mktime($i, 30, 0)).'" '.($this->options['stats']['to'] == date('H:i', mktime($i, 30, 0)) ? 'selected="selected"' : '').'>'.date('H:i', mktime($i, 30, 0)).'</option>';
							}
						?>
						</select>
						<?php echo _e('Limit', $this->pluginHook);?> <input size="1" type="text" name="<?php echo ($this->optionKey)?>[stats][limit]" value="<?php echo ($this->options['stats']['limit'])?>" />
						
						
						<?php echo _e('Hide empty', $this->pluginHook);?> 
						<input type="checkbox" name="<?php echo ($this->optionKey)?>[stats][hideEmpty]" value="1" <?php echo ($this->options['stats']['hideEmpty'] == '1' ? 'checked="checked"' : '')?>/>
                        <p class="submit top">
          					<input type="submit" class="button-primary" value="<?php _e("Save Options", $this->pluginHook); ?>"/>
          					<input type="reset" class="button-secondary" value="<?php _e("Cancel", $this->pluginHook); ?>"/>
        				</p>
					</div>
                    <div class="chart_heading"><?php echo _e('Visual Overview', $this->pluginHook);?></div><div id="chart_div" style="width: 600px; height: 350px;"></div>
					<div class="stats_heading"><?php echo _e('In Numbers', $this->pluginHook);?></div>
					<table class="statistics">
						<thead>
							<th class="url"><?php echo _e('Page', $this->pluginHook);?></th>
							<?php 
								foreach($this->availableNetworks as $k => $v){
									$statisticTotal = $this->getStatisticTotal($v);
									echo '<th class="'.$v.'"><span class="icon">'.($statisticTotal ? $statisticTotal : '0').'</span></th>';
								}
							?>
							<th class="internal"><span class="icon"><?php echo ($this->getStatisticTotal('internal') ? $this->getStatisticTotal('internal') : '0')?></span></th>
							<th class="total"><span class="icon"><?php echo ($this->getStatisticTotal('total') ? $this->getStatisticTotal('total') : '0')?></span></th>
						</thead>
						<tbody>
							<?php 
								foreach($this->statistic as $row){
									echo '<tr class="'.($i++ % 2 ? 'even' : 'odd').'">';
									echo '<td class="url"><a target="_blank" href="http://'.$_SERVER['HTTP_HOST'].$row['totals']->url.'">'.$row['totals']->url.'</a></td>';
									foreach($this->availableNetworks as $k => $v){
										$total = $row['range'][$v];
										echo '<td class="'.($total ? '' : 'empty').'">'.($total ? $total : '0').'</td>';
									}
									$internal = $row['range']['internal'];
									echo '<td class="'.($internal ? '' : 'empty').'">'.($internal ? $internal : '0').'</td>';
									
									$total = $row['range']['total'];
									echo '<td class="'.($total ? '' : 'empty').'">'.($total ? $total : '0').'</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="entry">
					<div class="container heading"><?php echo _e('Style', $this->pluginHook);?></div>
					<div class="container heading"><?php echo _e('Channels', $this->pluginHook);?></div>
					<div class="container heading"><?php echo _e('Placement', $this->pluginHook);?></div>
					<div class="containerClear"></div>
					<div class="container content style">
						<div class="theme">
							<div class="option">
								<div class="label"><?php echo _e('Style', $this->pluginHook);?></div>
								<input type="radio" name="<?php echo ($this->optionKey)?>[theme]" value="bright" <?php echo ($this->options['theme'] == 'bright' ? 'checked="checked"' : '')?>/> <span><?php echo _e('bright', $this->pluginHook);?></span><br/>
								<input type="radio" name="<?php echo ($this->optionKey)?>[theme]" value="dark" <?php echo ($this->options['theme'] == 'dark' ? 'checked="checked"' : '')?>/> <span><?php echo _e('dark', $this->pluginHook);?></span><br/>
							</div>
						</div>
						<div class="containerClear"></div>			
						<div class="option"><input type="checkbox" name="<?php echo ($this->optionKey)?>[displayVerb]" value="1" <?php echo ($this->options['displayVerb'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Display verb', $this->pluginHook);?></span></div>
						<div class="option"><span class="label"><?php echo _e('Verb', $this->pluginHook);?></span> <input class="verb" title="<?php echo _e('Verb', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[verb]" value="<?php echo ($this->options['verb'])?>" /></div>
						<div class="option"><span class="label"><?php echo _e('Verb CSS-Class', $this->pluginHook);?></span> <input class="verbClass" title="<?php echo _e('Verb CSS-Class', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[verbClass]" value="<?php echo ($this->options['verbClass'])?>" /> <span class="premiumFeature">*</span></div>
						<div class="option"><input type="checkbox" name="<?php echo ($this->optionKey)?>[removeBackgrounds]" value="1" <?php echo ($this->options['removeBackgrounds'] ? 'checked="checked"' : '')?>/> <span class="label tooltip" title=""><?php echo _e('Remove Popup-Backgrounds', $this->pluginHook);?></span> <span class="premiumFeature">*</span></div>
						<div class="option"><input type="checkbox" name="<?php echo ($this->optionKey)?>[heartless]" value="1" <?php echo ($this->options['heartless'] ? 'checked="checked"' : '')?>/> <span class="label tooltip" title="<?php echo _e('No love button is visible. Only sharing buttons are visible', $this->pluginHook);?>"><?php echo _e('Heartless Version', $this->pluginHook);?></span> <span class="premiumFeature">*</span></div>
						<input type="radio" name="<?php echo ($this->optionKey)?>[style]" value="59x16" <?php echo ($this->options['style'] == '59x16' ? 'checked="checked"' : '')?>/> <?php echo do_shortcode('[love-button style="59x16" align="none" marginTop="0" marginRight="0" marginBottom="0" marginLeft="0" position="relative" positionTop="0" positionRight="0" positionBottom="0" positionLeft="0"]');?><br/><br/>
						<input type="radio" name="<?php echo ($this->optionKey)?>[style]" value="75x20" <?php echo ($this->options['style'] == '75x20' ? 'checked="checked"' : '')?>/> <?php echo do_shortcode('[love-button style="75x20" align="none" marginTop="0" marginRight="0" marginBottom="0" marginLeft="0" position="relative" positionTop="0" positionRight="0" positionBottom="0" positionLeft="0"]');?><br/><br/>
						<input type="radio" name="<?php echo ($this->optionKey)?>[style]" value="91x24" <?php echo ($this->options['style'] == '91x24' ? 'checked="checked"' : '')?>/> <?php echo do_shortcode('[love-button style="91x24" align="none" marginTop="0" marginRight="0" marginBottom="0" marginLeft="0" position="relative" positionTop="0" positionRight="0" positionBottom="0" positionLeft="0"]');?><br/><br/>
						<input type="radio" name="<?php echo ($this->optionKey)?>[style]" value="52x60" <?php echo ($this->options['style'] == '52x60' ? 'checked="checked"' : '')?>/> <?php echo do_shortcode('[love-button style="52x60" align="none" marginTop="0" marginRight="0" marginBottom="0" marginLeft="0" position="relative" positionTop="0" positionRight="0" positionBottom="0" positionLeft="0"]');?><br/><br/>
						<div class="option">
							<input type="radio" name="<?php echo ($this->optionKey)?>[style]" value="custom" <?php echo ($this->options['style'] == 'custom' ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Custom', $this->pluginHook);?></span> <span class="premiumFeature">*</span><br/>
							<input class="customImageUrl" title="<?php echo _e('Paste image URL', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[customImageUrl]" value="<?php echo ($this->options['customImageUrl'])?>" /><br/>
							<span class="label hint"><?php echo _e('The custom sharing image<br/>is without a visible counter.', $this->pluginHook);?></span>
						</div>
					</div>
					<div class="container content functions">
						<?php foreach($this->sortedNetworks as $network){ ?>
							<div class="network"><input type="checkbox" name="<?php echo ($this->optionKey)?>[networks][]" value="<?php echo $network['name']?>" <?php echo ($network['active'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e($network['name'], $this->pluginHook);?></span>
								<?php if(isset($this->networkSettings[$network['name']])) : ?>
								<div class="networkSettings">
									<?php foreach($this->networkSettings[$network['name']] as $k => $setting){ ?>
									<div class="row<?php echo (isset($setting['tooltip']) && !empty($setting['tooltip']) ? ' tooltip' : ''); ?>"<?php echo (isset($setting['tooltip']) && !empty($setting['tooltip']) ? ' title="'.$setting['tooltip'].'"' : ''); ?>>
										<span class="settingName"><?php echo $setting['label'];?>:</span>
										<span class="settingInput"><?php echo $this->getInput($setting, $network['name']);?></span>
									</div>
									<?php } ?>
								</div>
								<?php endif; ?>	
							</div>
						<?php } ?>
					</div>
					<div class="container content placement">
						<div class="option">
							<input type="radio" name="<?php echo ($this->optionKey)?>[placement][type]" value="1" <?php echo ($this->options['placement']['type'] == '1' ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Blog views, posts and pages', $this->pluginHook);?></span><br/>
							<input type="radio" name="<?php echo ($this->optionKey)?>[placement][type]" value="2" <?php echo ($this->options['placement']['type'] == '2' ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Posts and pages', $this->pluginHook);?></span><br/>
							<input type="radio" name="<?php echo ($this->optionKey)?>[placement][type]" value="3" <?php echo ($this->options['placement']['type'] == '3' ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Posts', $this->pluginHook);?></span><br/>
							<input type="radio" name="<?php echo ($this->optionKey)?>[placement][type]" value="0" <?php echo ($this->options['placement']['type'] == '0' ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Only use shortcode', $this->pluginHook);?></span><br/>
							<textarea class="shortcode"><?php echo "<?php echo do_shortcode('[love-button]');?>" ?></textarea>
						</div>
						<select name="<?php echo ($this->optionKey)?>[placement][align]" class="align">
							<option value="right" <?php echo ($this->options['placement']['align'] == 'right' ? 'selected="selected"' : '')?>><?php echo _e('Right align', $this->pluginHook);?></option>
							<option value="left" <?php echo ($this->options['placement']['align'] == 'left' ? 'selected="selected"' : '')?>><?php echo _e('Left align', $this->pluginHook);?></option>
						</select>
						<select name="<?php echo ($this->optionKey)?>[placement][filter]" class="filter">
							<option value="above" <?php echo ($this->options['placement']['filter'] == 'above' ? 'selected="selected"' : '')?>><?php echo _e('Above content', $this->pluginHook);?></option>
							<option value="below" <?php echo ($this->options['placement']['filter'] == 'below' ? 'selected="selected"' : '')?>><?php echo _e('Below content', $this->pluginHook);?></option>
							<option value="date" <?php echo ($this->options['placement']['filter'] == 'date' ? 'selected="selected"' : '')?>><?php echo _e('Date', $this->pluginHook);?></option>
						</select>
						<div class="positionContainer">
							<div class="position">
								<span><?php echo _e('Position', $this->pluginHook);?></span>
								<input class="tooltip" title="<?php echo _e('Top', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[placement][position-data][top]" value="<?php echo ($this->options['placement']['position-data']['top'])?>" /> <input class="tooltip" title="<?php echo _e('Right', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[placement][position-data][right]" value="<?php echo ($this->options['placement']['position-data']['right'])?>" /> <input type="text" class="tooltip" title="<?php echo _e('Bottom', $this->pluginHook);?>" name="<?php echo ($this->optionKey)?>[placement][position-data][bottom]" value="<?php echo ($this->options['placement']['position-data']['bottom'])?>" /> <input class="tooltip" title="<?php echo _e('Left', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[placement][position-data][left]" value="<?php echo ($this->options['placement']['position-data']['left'])?>" />
								<select name="<?php echo ($this->optionKey)?>[placement][position]" class="position">
									<option value="relative" <?php echo ($this->options['placement']['position'] == 'relative' ? 'selected="selected"' : '')?>><?php echo _e('Relative', $this->pluginHook);?></option>
									<option value="absolute" <?php echo ($this->options['placement']['position'] == 'absolute' ? 'selected="selected"' : '')?>><?php echo _e('Absolute', $this->pluginHook);?></option>
									<option value="fixed" <?php echo ($this->options['placement']['position'] == 'fixed' ? 'selected="selected"' : '')?>><?php echo _e('Fixed', $this->pluginHook);?></option>
								</select>
							</div>
							<div class="margin">
								<span><?php echo _e('Margin', $this->pluginHook);?></span>
								<input class="tooltip" title="<?php echo _e('Top', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[placement][margin][top]" value="<?php echo ($this->options['placement']['margin']['top'])?>" /> <input class="tooltip" title="<?php echo _e('Right', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[placement][margin][right]" value="<?php echo ($this->options['placement']['margin']['right'])?>" /> <input class="tooltip" title="<?php echo _e('Bottom', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[placement][margin][bottom]" value="<?php echo ($this->options['placement']['margin']['bottom'])?>" /> <input class="tooltip" title="<?php echo _e('Left', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[placement][margin][left]" value="<?php echo ($this->options['placement']['margin']['left'])?>" /><br/>
							</div>
						</div>
					</div>
					<div class="containerClear"></div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div class="container heading"><?php echo _e('Popup', $this->pluginHook);?></div>
					<div class="container heading"><?php echo _e('Behavior', $this->pluginHook);?></div>
					<div class="container heading"><?php echo _e('License', $this->pluginHook);?></div>
					<div class="containerClear"></div>
					<div class="container content popup">
						<div class="option"><input type="checkbox" name="<?php echo ($this->optionKey)?>[showDataPrivacy]" value="1" <?php echo ($this->options['showDataPrivacy'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Show data privacy', $this->pluginHook);?></span></div>
						<div class="option"><input type="checkbox" name="<?php echo ($this->optionKey)?>[showDataPrivacyTextByDefault]" value="1" <?php echo ($this->options['showDataPrivacyTextByDefault'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Show data privacy text by default', $this->pluginHook);?></span></div>
						<div class="option">
							<nobr>
							<span class="label" style="width: 135px;"><?php echo _e('Popup v-position', $this->pluginHook);?></span>
							<select name="<?php echo ($this->optionKey)?>[popup][position-y]" class="position">
								<option value="auto" <?php echo ($this->options['popup']['position-y'] == 'auto' ? 'selected="selected"' : '')?>><?php echo _e('Auto', $this->pluginHook);?></option>
								<option value="above" <?php echo ($this->options['popup']['position-y'] == 'above' ? 'selected="selected"' : '')?>><?php echo _e('Above button', $this->pluginHook);?></option>
								<option value="below" <?php echo ($this->options['popup']['position-y'] == 'below' ? 'selected="selected"' : '')?>><?php echo _e('Below button', $this->pluginHook);?></option>
							</select>
							</nobr>
						</div>
						
						<div class="option">
							<nobr>
							<span class="label" style="width: 135px;"><?php echo _e('Popup h-position', $this->pluginHook);?></span>
							<select name="<?php echo ($this->optionKey)?>[popup][position-x]" class="position">
								<option value="auto" <?php echo ($this->options['popup']['position-x'] == 'auto' ? 'selected="selected"' : '')?>><?php echo _e('Auto', $this->pluginHook);?></option>
								<option value="left" <?php echo ($this->options['popup']['position-x'] == 'left' ? 'selected="selected"' : '')?>><?php echo _e('Left', $this->pluginHook);?></option>
								<option value="right" <?php echo ($this->options['popup']['position-x'] == 'right' ? 'selected="selected"' : '')?>><?php echo _e('Right', $this->pluginHook);?></option>
							</select>
							</nobr>
						</div>
						
						<div class="option">
							<span class="label" style="width: 135px;"><?php echo _e('Popup columns', $this->pluginHook);?></span>
							<input size="1" type="text" name="<?php echo ($this->optionKey)?>[popup][columns]" value="<?php echo ($this->options['popup']['columns'])?>" />
						</div>
					</div>
					<div class="container content behavior">
						<div class="tooltip" title="<?php echo _e('Recommended for post based sharing. if deactivated, the<br/>button would share the URL. Deactivation<br/>makes sense, if you only want to use one (global) love<br/>button for your frontpage, category pages and<br/>archive pages.', $this->pluginHook);?>">
							<div class="option">
								<input type="checkbox" name="<?php echo ($this->optionKey)?>[shareBasedOnId]" value="1" <?php echo ($this->options['shareBasedOnId'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Share based on ID', $this->pluginHook);?></span>
							</div>
						</div>
						<div class="tooltip" title="<?php echo _e('If enabled, the plugin will remove all OpenGraph image tags from the html output and then create new tags for all images in the source which have a dimension of minimum [width]x[height] pixels.<br/>You can disallow to share an image by mark up as "unshareable" with the editor button.', $this->pluginHook);?>">
							<div class="option">
								<input type="checkbox" name="<?php echo ($this->optionKey)?>[useOgImage]" value="1" <?php echo ($this->options['useOgImage'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Proceed OpenGraph images', $this->pluginHook);?></span><br/>
								<span class="label"><?php echo _e('Minimum width', $this->pluginHook);?></span> <input size="1" type="text" name="<?php echo ($this->optionKey)?>[useOgImageWidth]" value="<?php echo ($this->options['useOgImageWidth'])?>" /> px / <span class="label"><?php echo _e('height', $this->pluginHook);?></span> <input size="1" type="text" name="<?php echo ($this->optionKey)?>[useOgImageHeight]" value="<?php echo ($this->options['useOgImageHeight'])?>" /> px
							</div> 
						</div>						
						<div class="tooltip" title="<?php echo _e('Set this image to the first shareable OpenGraph image.', $this->pluginHook);?>">
							<div class="option">
								<span class="label"><?php echo _e('First OpenGraph image: ', $this->pluginHook);?></span>
								<input class="ogImage" title="<?php echo _e('Paste image URL', $this->pluginHook);?>" type="text" name="<?php echo ($this->optionKey)?>[ogImage]" value="<?php echo ($this->options['ogImage'])?>" />
							</div>
						</div>
					</div>
					<div class="container content license">
						<div class="option">
							<span class="label"><?php echo _e('Premium license key', $this->pluginHook);?></span> <input type="text" style="width: 235px;" name="<?php echo ($this->optionKey)?>[license]" value="<?php echo ($this->options['license'])?>" />
						</div>
						<span class="label hint premiumFeature">* <?php echo  _e('You can purchase a premium license key to enable premium features. Please visit', $this->pluginHook);?> <a target="_blank" href="<?php echo ($this->licenseServer)?>">love.delucks.com</a></span><br/>
						<div class="option">
							<input type="checkbox" name="<?php echo ($this->optionKey)?>[showBranding]" value="1" <?php echo ($this->options['showBranding'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Show love button branding', $this->pluginHook);?></span>
						</div>
					</div>
					<div class="containerClear"></div>
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<div class="container heading"><?php echo _e('Counting', $this->pluginHook);?></div>
					<div class="containerClear"></div>
					<div class="container content counting">
						<div class="option">
							<span class="label" style="width: 135px;"><?php echo _e('Only count clicks for this groups', $this->pluginHook);?></span>
							<nobr>
							<select name="<?php echo ($this->optionKey)?>[counting][countGroups][]" multiple="multiple" size="<?php echo (count($this->getRoles()->role_names)+1)?>">
								<option value="guest" <?php echo (isset($this->options['counting']['countGroups']) && is_array($this->options['counting']['countGroups']) && in_array('guest', $this->options['counting']['countGroups']) ? 'selected="selected"' : '')?>><?php echo _e('Guest', $this->pluginHook);?></option>
								<?php foreach($this->getRoles()->role_names as $k => $v) { ?>
									<option value="<?php echo ($k)?>" <?php echo (isset($this->options['counting']['countGroups']) && is_array($this->options['counting']['countGroups']) && in_array($k, $this->options['counting']['countGroups']) ? 'selected="selected"' : '')?>><?php echo ($v)?></option>
								<?php } ?>
							</select>
							</nobr>
						</div>
						<div class="tooltip" title="<?php echo _e('Recommended. If deactivated, the click on the love<br/>button itself would not be counted as a click.', $this->pluginHook);?>">
							<div class="option">
								<input type="checkbox" name="<?php echo ($this->optionKey)?>[countInternalLike]" value="1" <?php echo ($this->options['countInternalLike'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Count Love Button clicks', $this->pluginHook);?></span>
							</div>
						</div>
						<div class="option">
							<input type="checkbox" name="<?php echo ($this->optionKey)?>[showCounters]" value="1" <?php echo ($this->options['showCounters'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Show button counter', $this->pluginHook);?></span>
						</div>
						<div class="option">
							<input type="checkbox" name="<?php echo ($this->optionKey)?>[showCountersPopup]" value="1" <?php echo ($this->options['showCountersPopup'] ? 'checked="checked"' : '')?>/> <span class="label"><?php echo _e('Show popup counters', $this->pluginHook);?></span>
						</div>

					</div>
					<div class="containerClear"></div>
					<p class="submit">
			        	<input type="submit" class="button-primary" value="<?php _e("Save Options", $this->pluginHook); ?>"/>
			        	<input type="submit" class="button-primary resetCounter" name="loveButtonResetCounter" value="<?php _e("Reset counter", $this->pluginHook); ?>"/>
			        	<input type="reset" class="button-secondary" value="<?php _e("Cancel", $this->pluginHook); ?>"/>
			        </p>
				</div>
			</div>
		</div>
        <div class="loveButtonFooter"></div>
 	</form>
</div>