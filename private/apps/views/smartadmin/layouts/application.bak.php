<!DOCTYPE html>
<html lang="nl-nl" dir="ltr" class="uk-height-1-1">
    <head>
        <meta charset="utf-8">
        <title><?=@$page_title?><?=@$page_title_separator?><?=@$site_apps?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="<?=@$site_description?>">
        <meta name="keyword" content="<?=@$site_keyword?>">
        <meta name="author" content="Lucky Mahrus | mahrus.lukmanhakim@gmail.com | http://webdev-lucky.com">

        <!-- URL Theme Color for Chrome, Firefox OS, Opera and Vivaldi -->
        <meta name="theme-color" content="#ff7700" />
        <!-- URL Theme Color for iOS Safari -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="#ff7700" />

        <link rel="apple-touch-icon-precomposed" href="<?=assets_url(@$themes.'/images/icons/favicon.ico')?>">
        <link rel="shortcut icon" href="<?=assets_url(@$themes.'/images/icons/favicon.ico')?>" type="image/x-icon">
        <link rel="icon" href="<?=assets_url(@$themes.'/images/icons/favicon.ico')?>" type="image/x-icon">

        <link rel="apple-touch-icon" sizes="57x57" href="<?=assets_url(@$themes.'/images/icons/apple-icon-57x57.png')?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?=assets_url(@$themes.'/images/icons/apple-icon-60x60.png')?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?=assets_url(@$themes.'/images/icons/apple-icon-72x72.png')?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?=assets_url(@$themes.'/images/icons/apple-icon-76x76.png')?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=assets_url(@$themes.'/images/icons/apple-icon-114x114.png')?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=assets_url(@$themes.'/images/icons/apple-icon-120x120.png')?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?=assets_url(@$themes.'/images/icons/apple-icon-144x144.png')?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=assets_url(@$themes.'/images/icons/apple-icon-152x152.png')?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?=assets_url(@$themes.'/images/icons/apple-icon-180x180.png')?>">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?=assets_url(@$themes.'/images/icons/android-icon-192x192.png')?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?=assets_url(@$themes.'/images/icons/favicon-32x32.png')?>">
        <link rel="icon" type="image/png" sizes="96x96" href="<?=assets_url(@$themes.'/images/icons/favicon-96x96.png')?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?=assets_url(@$themes.'/images/icons/favicon-16x16.png')?>">
        <link rel="manifest" href="<?=assets_url(@$themes.'/images/icons/manifest.json')?>">
        <!-- URL Theme Color for Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#ff7700" />
        <meta name="msapplication-TileColor" content="#ff7700">
        <meta name="msapplication-TileImage" content="<?=assets_url(@$themes.'/images/icons/ms-icon-144x144.png')?>">

        <link href="<?=assets_url(@$themes.'/less/uikit.less')?>" rel="stylesheet/less" type="text/css">
        
        <?=((isset($custom_css_links)) ? $custom_css_links : '')?>

        <?=@$yield_style?>

        <link href="<?=assets_url(@$themes.'/less/style.less')?>" rel="stylesheet/less" type="text/css">

        <script src="<?=assets_url(@$themes.'/vendor/less.js')?>"></script>
        <script src="<?=assets_url(@$themes.'/vendor/jquery.js')?>"></script>
        <script src="<?=assets_url(@$themes.'/vendor/jquery.cookie.js')?>"></script>
        <script src="<?=assets_url(@$themes.'/js/plugin/jquery-sprintf/jquery.sprintf.js')?>"></script>
        <script src="<?=assets_url(@$themes.'/js/uikit.min.js')?>"></script>
        <script type="text/javascript">
            $.getScript("<?=assets_url(@$themes.'/js/components/form-password.min.js')?>", function(){});
            $.getScript("<?=assets_url(@$themes.'/js/components/datepicker.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/grid.min.js')?>", function(){});
            $.getScript("<?=assets_url(@$themes.'/js/components/notify.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/sticky.min.js')?>", function(){});
            $.getScript("<?=assets_url(@$themes.'/js/components/tooltip.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/accordion.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/autocomplete.min.js')?>", function(){});
            $.getScript("<?=assets_url(@$themes.'/js/components/form-select.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/grid-parallax.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/htmleditor.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/lightbox.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/nestable.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/pagination.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/parallax.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/search.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/slider.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/slideset.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/slideshow-fx.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/slideshow.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/sortable.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/timepicker.min.js')?>", function(){});
            //$.getScript("<?=assets_url(@$themes.'/js/components/upload.min.js')?>", function(){});
            function dayName(day)
            {
                switch (day)
                {
                    case 'Sunday'   : day = '<?=$this->lang->line('Sunday')?>'; break;
                    case 'Sun'      : day = '<?=$this->lang->line('Sun')?>'; break;
                    case 'Monday'   : day = '<?=$this->lang->line('Monday')?>'; break;
                    case 'Mon'      : day = '<?=$this->lang->line('Mon')?>'; break;
                    case 'Tuesday'  : day = '<?=$this->lang->line('Tuesday')?>'; break;
                    case 'Tue'      : day = '<?=$this->lang->line('Tue')?>'; break;
                    case 'Wednesday': day = '<?=$this->lang->line('Wednesday')?>'; break;
                    case 'Wed'      : day = '<?=$this->lang->line('Wed')?>'; break;
                    case 'Thursday' : day = '<?=$this->lang->line('Thursday')?>'; break;
                    case 'Thu'      : day = '<?=$this->lang->line('Thu')?>'; break;
                    case 'Friday'   : day = '<?=$this->lang->line('Friday')?>'; break;
                    case 'Fri'      : day = '<?=$this->lang->line('Fri')?>'; break;
                    case 'Saturday' : day = '<?=$this->lang->line('Saturday')?>'; break;
                    case 'Sat'      : day = '<?=$this->lang->line('Sat')?>'; break;
                }                           
                return day;
            }
            function monthName(month)
            {
                switch (month)
                {
                    case 'January'      : month = '<?=$this->lang->line('January')?>'; break;
                    case 'Jan'          : month = '<?=$this->lang->line('Jan')?>'; break;
                    case 'February'     : month = '<?=$this->lang->line('February')?>'; break;
                    case 'Feb'          : month = '<?=$this->lang->line('Feb')?>'; break;
                    case 'March'        : month = '<?=$this->lang->line('March')?>'; break;
                    case 'Mar'          : month = '<?=$this->lang->line('Mar')?>'; break;
                    case 'April'        : month = '<?=$this->lang->line('April')?>'; break;
                    case 'Apr'          : month = '<?=$this->lang->line('Apr')?>'; break;
                    case 'May'          : month = '<?=$this->lang->line('May')?>'; break;
                    case 'May'          : month = '<?=$this->lang->line('May')?>'; break;
                    case 'June'         : month = '<?=$this->lang->line('June')?>'; break;
                    case 'Jun'          : month = '<?=$this->lang->line('Jun')?>'; break;
                    case 'July'         : month = '<?=$this->lang->line('July')?>'; break;
                    case 'Jul'          : month = '<?=$this->lang->line('Jul')?>'; break;
                    case 'August'       : month = '<?=$this->lang->line('August')?>'; break;
                    case 'Aug'          : month = '<?=$this->lang->line('Aug')?>'; break;
                    case 'September'    : month = '<?=$this->lang->line('September')?>'; break;
                    case 'Sep'          : month = '<?=$this->lang->line('Sep')?>'; break;
                    case 'October'      : month = '<?=$this->lang->line('October')?>'; break;
                    case 'Oct'          : month = '<?=$this->lang->line('Oct')?>'; break;
                    case 'November'     : month = '<?=$this->lang->line('November')?>'; break;
                    case 'Nov'          : month = '<?=$this->lang->line('Nov')?>'; break;
                    case 'December'     : month = '<?=$this->lang->line('December')?>'; break;
                    case 'Dec'          : month = '<?=$this->lang->line('Dec')?>'; break;
                }                           
                return month;
            }
        </script>
        <script src="<?=assets_url(@$themes.'/js/app.js')?>"></script>
    </head>
    <body id="app-zat412">
        <?=@$yield_header?>

        <?=@$yield?>

        <?=@$yield_footer?>

        <?=@$custom_js_links?>
        
        <?=@$yield_script?>

        <script>
            $(document).ready(function()
            {
                var ukactive = $('#main_navigation li.uk-active');
                var ukparent = ukactive.closest('.uk-parent');
                ukparent.addClass('uk-active');
                var text = ukparent.find('span.menu-item-parent').text();
                text = (text.length > 0) ? text : 'Dashboard';
                $('.uk-breadcrumb li:first-child a').text(text);

                $('span#boundary[data-uk-dropdown]').on('show.uk.dropdown', function () {
                    var boundary = $( "#boundary" );
                    var position = boundary.position();
                    var LoggedUser = $('a#LoggedUser');
                    var profileLinks = $('.uk-dropdown.profileLinks');
                    var LoggedUserWidth = LoggedUser.outerWidth();
                    var profileLinksWidth = profileLinks.outerWidth();
                    profileLinks.attr('style', 'top: '+position.top+'px !important');
                    profileLinks.attr('style', 'left: '+(position.left - ((profileLinksWidth - LoggedUserWidth) / 2))+'px !important');
                    console.log("outerWidth: " + $('.uk-dropdown.profileLinks').outerWidth());
                });
            });
        </script>
    </body>
</html>
<?php
/* End of file application.php */
/* Location: private/apps/views/layouts/application.php */
?>
