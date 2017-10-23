<script>

	$(document).ready(function()
	{
	    setHeight();
	});

    $(document).resize(function()
    {
	    setHeight();
	});

    $(window).resize(function()
    {
	    setHeight();
	});

	function setHeight()
	{
	    var windowWidth 		= $(window).width();
        var windowHeight		= $(window).height();
        var footerHeight		= $('.uk-block-footer').outerHeight();
        var contentHeightLarge	= windowHeight - footerHeight;

        if(windowWidth < 768)
        {
        	var headerHeight	= $('.uk-navbar.uk-visible-small').outerHeight();
        	contentHeightLarge	= contentHeightLarge - headerHeight;
	        $('body .uk-form').css('margin-bottom',50);
        }
        else
        {
	        $('body #loginpage').css('min-height',contentHeightLarge);
	        $('body #loginpage .header-container').css('padding-bottom',30);
	        $('body .uk-block-login').css('min-height',contentHeightLarge);
	        $('body .uk-block-bg-login').css('min-height',contentHeightLarge);
	        $('body .uk-block-bg-login').css('min-height',contentHeightLarge);
        }

	}

</script>