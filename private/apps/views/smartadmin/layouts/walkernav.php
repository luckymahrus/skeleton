<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * walkernav_helper.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2015
 * license		: http://www.luckymahrus.com/
 * file			: private/application/apps/helpers/walkernav_helper.php
 * created		: 2015 October 21th / 23:20:46
 * last edit	: 2015 October 21th / 23:20:46
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */


if ( ! function_exists('build_nav'))
{
    function build_nav($id = 'main-navigation',$arrData = array(),$activeClass='active')
    {
        $ci=& get_instance();
        $sessLang = $ci->session->lang;
        $confLang = $ci->config->item('language');
        $lang   = ((isset($sessLang)) ? $sessLang : ((empty($confLang)) ? 'english' : $confLang));

        $html  = array();
        $html[] = '<ul id="'.$id.'">';
        if(isset($arrData)) : 
        $items = $arrData;
        $root_id    = 0;
       
        foreach ( $items as $item )
                $children[$item->webmenu_parent_id][] = $item;
       
        // loop will be false if the root has no children (i.e., an empty menu!)
        $loop = !empty( $children[$root_id] );
       
        // initializing $parent as the root
        $parent = $root_id;
        $parent_stack = array();
       
        // HTML wrapper for the menu (open)
       
        while ( $loop && ( ( $option = each( $children[$parent] ) ) || ( $parent > $root_id ) ) )
        {
            $menuTitle = @unserialize(isset($option['value']->webmenu_title) ? $option['value']->webmenu_title : $option['value']['webmenu_title']);
            if($menuTitle !== false && is_array($menuTitle) && isset($menuTitle[$lang])) $menuTitle = $menuTitle[$lang];
            else $menuTitle = (isset($option['value']->webmenu_title) ? $option['value']->webmenu_title : $option['value']['webmenu_title']);

            //var_dump(is_object($option['value']));
            //var_dump(is_array($option['value']));
            //var_dump(is_object($option['value']->webmenu_icon));
            //var_dump(is_object($option['value']['webmenu_icon']));
            $menuIcon = ((is_object($option['value'])) ? $option['value']->webmenu_icon : ((is_array($option['value'])) ? $option['value']['webmenu_icon'] : NULL)) ;//$option['value']->webmenu_icon;

            if ( $option === false )
            {
                $parent = array_pop( $parent_stack );
               
                // HTML for menu item containing childrens (close)
                $html[] = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 ) . '</ul></div>';
                $html[] = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 ) . '</li>';
            }
            elseif ( !empty( $children[$option['value']->webmenu_id] ) )
            {
                $tab = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 );
               
                $html[] = sprintf(
                        '%1$s<li'.((($option['value']->webmodules_class == $ci->router->class && $option['value']->webmodules_method == $ci->router->method) || ($option['value']->webmodules_class == $ci->router->class  && $option['value']->webmodules_method == 'index' && ($ci->router->method == 'edit' || $ci->router->method == 'detail'))) ? ' class="active"' : '').'><a href="%2$s" title="%3$s">%4$s<span class="menu-item-parent">%5$s</span></a>',
                        $tab,   // %1$s = tabulation
                        '#',
                        $menuTitle,   // %3$s = title
                        ((!empty($menuIcon) && !is_null($menuIcon)) ? '<i class="'.$menuIcon.'"></i> ' : ''),   // %3$s = title
                        $menuTitle   // %3$s = title
                        //($option['value']->webmodules_class == 'user' && $option['value']->webmodules_method == 'profile') ? $ci->session->userdata('first_name').' '.$ci->session->userdata('last_name').(($ci->session->userdata('customer_id') <> '') ? ' ('.$ci->session->userdata('customer_id').')' : '') : $menuTitle   // %3$s = title
                );
                $html[] = $tab . "\t" . '<ul>';
               
                array_push( $parent_stack, $option['value']->webmenu_parent_id );
                $parent = $option['value']->webmenu_id;
            }
            else
            {
                $html[] = sprintf(
                        '%1$s<li'.((($option['value']->webmodules_class == $ci->router->class && $option['value']->webmodules_method == $ci->router->method) || ($option['value']->webmodules_class == $ci->router->class  && $option['value']->webmodules_method == 'index' && ($ci->router->method == 'edit' || $ci->router->method == 'detail'))) ? ' class="active"' : '').'><a href="%2$s" title="%3$s">%4$s<span class="menu-item-parent">%5$s</span></a>',
                        str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 ),   // %1$s = tabulation
                        ((empty($option['value']->webmodules_class) || empty($option['value']->webmodules_method)) ? '#' : (($option['value']->webmodules_class == 'dashboard' || $option['value']->webmodules_class == 'home' || $option['value']->webmodules_class == 'welcome' || $option['value']->webmodules_class == 'main') ? secure_url() : links_url(array('class'=>$option['value']->webmodules_class,'method'=>$option['value']->webmodules_method)))),
                        $menuTitle,
                        ((!empty($menuIcon) && !is_null($menuIcon)) ? '<i class="'.$menuIcon.'"></i> ' : ''),   // %3$s = title
                        //($option['value']->webmodules_class == 'user' && $option['value']->webmodules_method == 'profile') ? $ci->session->userdata('first_name').' '.$ci->session->userdata('last_name') : $menuTitle   // %3$s = title
                        $menuTitle   // %3$s = title
                );
            }
        }

        endif;
        $html[] = '</ul>';
        return (implode( "\r\n", $html ));
    }
}


/* End of file walkernav_helper.php */
/* Location: private/application/apps/helpers/walkernav_helper.php */

