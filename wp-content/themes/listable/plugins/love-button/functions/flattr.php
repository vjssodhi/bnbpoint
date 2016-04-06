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
<?php 

	$sett = $this->options['networkSettings']['flattr'];
	if(!isset($sett['username']) || !strlen(trim($sett['username']))) {
		return false;
	}
	
	return '<a title="'.__('share on Flattr', $this->pluginHook).'" target="_blank" href="https://flattr.com/submit/auto?user_id='.trim($sett['username']).'&url='.$this->shareUrl.'&title='.$this->shareTitle.'&amp;description='.$this->shareDescription.'"><span class="delucksShareButton flattr"><span class="counter">0</span></span></a>';
	
?>