(function() {
    tinymce.create('tinymce.plugins.dontshareimage', {
        init : function(ed, url) {
            ed.addButton('dontshareimage', {
                title : 'Make this image not shareable to social media',
                image : url+'/../../images/editor-button-dontshareimage.png',
                onclick : function() {
                	if(ed.selection.getContent() == ''){
                		alert('Please select an image!');
                		return;
                	}
                	
                	var dontShareClass = 'social-network-dont-share';
                	temp = document.createElement('div');
                	temp.innerHTML = ed.selection.getContent();
                	var images = temp.getElementsByTagName( 'img' );
                	
                	if(images.length > 1){
                		alert('Please select only one image!');
                	} else {
	                	for( var i = 0; i < images.length; i++ ) {
	                		if(images[i].className.match(dontShareClass)){
	                			images[i].className = images[i].className.replace(dontShareClass, ''); //remove class
	                			images[i].style.border = 'none';
	                		} else {
	                			images[i].className += ' '+dontShareClass; //add class
	                			images[i].style.border = 'solid 2px red';
	                		}
	                	}
	                	ed.selection.setContent(temp.innerHTML);
                	}
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('dontshareimage', tinymce.plugins.dontshareimage);
})();