$(function(){
	var $write = $('#word'),
		shift = false,
		capslock = false;
	
	$('.keyboard li').click(function(){

		var $this = $(this),
			character = $this.html();
        // Delete
		if ($this.hasClass('delete')) {
			var html = $write.html();
            $write.val(html.substr(0, html.length - 1));
			$write.html(html.substr(0, html.length - 1));
			return false;
		}
       $write.val($write.val()+character);
       $write.html($write.html() + character);		
		// Code for processing the key.
	});
});