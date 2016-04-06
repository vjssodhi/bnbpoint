jQuery(document).ready(function($) {
	$('#update-nav-menu').bind('click', function(e) {
		if ( e.target && e.target.className && -1 != e.target.className.indexOf('item-edit')) {
			$("input[value='love-button-menu-item'][type=text]").parent().parent().parent().each( function(){
				var item = $(this).attr('id').substring(19);
				// remove default fields we don't need
				$(this).children('.field-css-classes').hide();
				$(this).children('.field-xfn, .field-link-target,.field-description,.field-url').remove();
			});
		}
	});
});
