/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	
	
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    
    config.enterMode = CKEDITOR.ENTER_BR;
    
   config.filebrowserBrowseUrl = '/public/kcfinder/browse.php?type=files&dir=files';
    config.filebrowserImageBrowseUrl = '/public/kcfinder/browse.php?type=images&dir=images';
    config.filebrowserFlashBrowseUrl = '/public/kcfinder/browse.php?type=flash&dir=flash';
    config.filebrowserUploadUrl = '/public/kcfinder/upload.php?type=files&dir=files';
    config.filebrowserImageUploadUrl = '/public/kcfinder/upload.php?type=images&dir=images';
    config.filebrowserFlashUploadUrl = '/public/kcfinder/upload.php?type=flash&dir=flash';
};
