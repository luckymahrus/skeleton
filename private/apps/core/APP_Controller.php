<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

 
class APP_Controller extends MY_Controller
{
    protected $languages = array();

    protected $baselang = 'english';

    protected $custom_css_files = array();

    protected $custom_js_files = array();

    protected $globalConf;

    protected $themes   = 'default';

    /**
     * Initialise the controller, tie into the CodeIgniter superobject
     * and try to autoload the models and helpers
     */
    public function __construct()
    {
        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        //$this->data['themes']               = $this->themes   = (($this->config->item('themes')) ? $this->config->item('themes').'/' : 'default/');
        $webthemes                      = $this->webthemes->get_by(array('status'=>1));
        $this->session->set_userdata('themes',((isset($webthemes->webthemes_name)) ? $webthemes->webthemes_name : 'default'));
        $this->data['themes']           = $this->themes   = $this->session->userdata('themes').'/';
        $this->data['allow_add']        = $this->custom_auth->is_allowed_to($this->router->class,'add');
        $this->data['allow_detail']     = $this->custom_auth->is_allowed_to($this->router->class,'detail');
        $this->data['allow_edit']       = $this->custom_auth->is_allowed_to($this->router->class,'edit');
        $this->data['allow_delete']     = $this->custom_auth->is_allowed_to($this->router->class,'delete');
        $this->data['module_detail']    = get_module_detail($this->router->class,$this->router->method);

        if($this->session->flashdata('message'))
        {
            $this->data['message']    = $this->session->flashdata('message');
        }

        $this->early_check();

        $this->_load_languages('global');
        $this->_load_languages($this->router->class);
        $this->_load_languages($this->router->method);
    }
    
    /* --------------------------------------------------------------
     * LANGUAGE LOADING
     * ------------------------------------------------------------ */

    /**
     * Load languages based on the $this->languages array
     */
    protected function _load_languages($lang=NULL)
    {
        if(is_array($lang))
        {
            $i = 0;
            foreach ($lang as $language)
            {
                if($this->_language_source($language) == true)
                {
                    $this->lang->load($language, $this->baselang);    
                }
            }
        }
        else
        {
            if($this->_language_source($lang) == true)
            {
                $this->lang->load($lang, $this->baselang); 
            }
        }
    }

    /**
     * Returns the loadable language name
     */
    private function _language_source($language)
    {
        $arrmodules = $this->config->item('modules_locations');
        if(!empty($arrmodules) && is_array($arrmodules))    $modules    = array_keys($arrmodules);

        if(isset($modules))
        {
            foreach($modules as $module)
            {
                if(file_exists($module.$this->router->class.'/language/'.$this->baselang.'/'.$language.'_lang.php'))  return true;
                else if(file_exists($module.$this->router->class.'/language/'.$this->baselang.'/'.$this->router->class.'_'.$language.'_lang.php'))    return true;
                else if(file_exists(APPPATH.'language/'.$this->baselang.'/'.$language.'_lang.php'))   return true;
                else if(file_exists(APPPATH.'language/'.$this->baselang.'/'.$this->router->class.'_'.$language.'_lang.php'))  return true;
            }
        }
        else
        {
            if(file_exists(APPPATH.'language/'.$this->baselang.'/'.$language.'_lang.php'))    return true;
            else if(file_exists(APPPATH.'language/'.$this->baselang.'/'.$this->router->class.'_'.$language.'_lang.php'))  return true;
        }

        return false;
    }

    /**
     * Automatically load the view and any other things that related with the view,
     * allowing the developer to override if he or she wishes, otherwise being conventional.
     */
    protected function _load_view()
    {
        $this->data['themes']   = $themes  = $this->config->item('themes');

        $arrmodules     = $this->config->item('modules_locations');
        if(!empty($arrmodules) && is_array($arrmodules))    $modules    = array_keys($arrmodules);

        $custom_style   = (!empty($this->view)) ? $this->view.'_style'  : "";
        $custom_script  = (!empty($this->view)) ? $this->view.'_script' : "";

        if ($this->view !== FALSE)
        {
            $data   = array();

            $this->get_theme_config();
            $this->_load_css_links();
            $this->_load_js_links();

            if(isset($modules))
            {
                foreach($modules as $module)
                {
                    if(($custom_style != "" && (file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_style.'.php') || file_exists($module.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_style.'.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$custom_style.'.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_style.'.php'))))
                    {
                        $style = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_style; break;
                    }
                    else if((file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->method.'_style.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->method.'_style.php')))
                    {
                        $style = $this->router->class . '/' . ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->method . '_style'; break;
                    }
                    else
                    {
                        $style = FALSE; break;
                    }
                }
            }
            else
            {
                $style = (($custom_style != "" && (file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$custom_style.'.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_style.'.php'))) ? $custom_style : ((file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->method.'_style.php')) ? (((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class . '/' . $this->router->method.'_style.php') : FALSE));
            }

            if(isset($modules))
            {
                foreach($modules as $module)
                {
                    if(($custom_script != "" && (file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_script.'.php') || file_exists($module.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_script.'.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$custom_script.'.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_script.'.php'))))
                    {
                        $script = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_script; break;
                    }
                    else if((file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->method.'_script.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->method.'_script.php')))
                    {
                        $script = $this->router->class . '/' . ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->method . '_script'; break;
                    }
                    else
                    {
                        $script = FALSE; break;
                    }
                }
            }
            else
            {
                $script = (($custom_script != "" && (file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$custom_script.'.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_script.'.php'))) ? $custom_script : ((file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->method.'_script.php')) ? (((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class . '/' . $this->router->method.'_script.php') : FALSE));
            }

            if ($style != FALSE)
            {
                $this->data['yield_style'] = $this->load->view($style, $this->data, TRUE);
            }
            
            if ($script != FALSE)
            {
                $this->data['yield_script'] = $this->load->view($script, $this->data, TRUE);
            }

            if (!empty($this->asides))
            {
                $this->_load_languages($this->asides);

                foreach ($this->asides as $name)
                {
                    if(isset($modules))
                    {
                        foreach($modules as $module)
                        {
                            if(file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/components/'.$name.'.php'))
                            {
                                $this->data['yield_'.$name] = $this->load->view($this->router->class.'/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/components/'.$name, $this->data, TRUE); break;
                            }
                            else if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/components/'.$name.'.php'))
                            {
                                $this->data['yield_'.$name] = $this->load->view(((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/components/'.$name, $this->data, TRUE); break;
                            }
                            else if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$name.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$name.'.php'))
                            {
                                $this->data['yield_'.$name] = $this->load->view(((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$name, $this->data, TRUE); break;
                            }
                            else if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$name.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$name.'.php'))
                            {
                                $this->data['yield_'.$name] = $this->load->view(((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$name, $this->data, TRUE); break;
                            }
                        }
                    }
                    else if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/components/'.$name.'.php'))
                    {
                        $this->data['yield_'.$name] = $this->load->view(((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/components/'.$name, $this->data, TRUE); break;
                    }
                    else if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$name.'.php'))
                    {
                        $this->data['yield_'.$name] = $this->load->view(((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$name, $this->data, TRUE); break;
                    }
                    else if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$name.'.php'))
                    {
                        $this->data['yield_'.$name] = $this->load->view(((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$name, $this->data, TRUE); break;
                    }
                }
            }

            $custom_view = (!empty($this->view)) ? $this->view : "";

            if(isset($modules))
            {
                foreach($modules as $module)
                {
                    if(($custom_view != "" && (file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_view.'.php') || file_exists($module.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_view.'.php'))))
                    {
                        $view   = $this->router->class . '/' . ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "") . $custom_view; break;
                    }
                    else if(($custom_view != "" && (file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_view.'.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_view.'.php'))))
                    {
                        $view   = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "") . $this->router->class . '/' . $custom_view; break;
                    }
                    else if(file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->method.'.php'))
                    {
                        $view   = $this->router->class . '/' . ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "") . $this->router->method; break;
                    }
                    else if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->method.'.php'))
                    {
                        $view   = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "") . $this->router->class . '/' . $this->router->method; break;
                    }
                    else
                    {
                        $view   = FALSE;
                    }
                }

            }
            else
            {
                $view   = (($custom_view != "" && (file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$custom_view.'.php') || file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_view.'.php'))) ? ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$custom_view : ((file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->method.'.php')) ? (((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class . '/' . $this->router->method) : FALSE));
            }

            if ($view != FALSE)
            {
                $data['yield'] = $this->load->view($view, $this->data, TRUE);
            }
        
            $data   = array_merge($this->data, $data);
            $layout = FALSE;

            if (!isset($this->layout))
            {
                if(isset($modules))
                {
                    foreach($modules as $module)
                    {
                        if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/application.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/application.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'application.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/application';  break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/layout.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/layout.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/layout';   break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->class.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->class.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->class;    break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->router->class.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->router->class.'.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->router->class;  break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/application.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/application.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/application';    break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/layout.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/layout.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/layout'; break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class; break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'application.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'application.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'application';    break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layout.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layout.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layout'; break;
                        }
                        else
                        {
                            $layout = FALSE;
                        }
                    }
                }
                else
                {
                    if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/application.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/application';
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/layout.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/layout';
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->class.'.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->router->class;
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->router->class.'.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->router->class;
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/application.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/application';
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/layout.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/layout';
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class;
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'application.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'application';
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layout.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layout';
                    }
                    else
                    {
                        $layout = FALSE;
                    }
                }
            }
            else if ($this->layout !== FALSE)
            {
                if(isset($modules))
                {
                    foreach($modules as $module)
                    {
                        if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->layout.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->layout.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->layout.'.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->layout;  break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->layout.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->layout.'.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->layout;  break;
                        }
                        elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->layout.'.php') || file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->layout.'.php'))
                        {
                            $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->layout; break;
                        }
                        else
                        {
                            $layout = FALSE;
                        }
                    }
                }
                else
                {
                    if(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->layout.'.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/'.$this->layout;
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->layout.'.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'layouts/'.$this->layout;
                    }
                    elseif(file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->layout.'.php'))
                    {
                        $layout = ((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->layout;
                    }
                    else
                    {
                        $layout = FALSE;
                    }
                }
                //$layout = $this->layout;
            }

            if ($layout == FALSE)
            {
                if(isset($data['yield']))   $this->output->set_output($data['yield']);
            }
            else
            {
                $this->load->view($layout, $data);
            }
        }
    }

    protected function _load_css_links()
    {
        $cssTotal   = count($this->custom_css_files);
//echo "<br>cssTotal = ".$cssTotal;
        if($cssTotal > 0)
        {
            $this->data['custom_css_links'] = '';
            foreach ($this->custom_css_files as $key)
            {
                $this->data['custom_css_links'] .= '<link rel="stylesheet" type="text/css" media="screen" href="'.assets_url().'themes/'.((isset($this->data['themes']) && $this->data['themes'] <> "" && !empty($this->data['themes'])) ? $this->data['themes']."/" : "").$key.'">';
            }
        }

        return;
    }

    protected function _load_js_links()
    {
        $jsTotal   = count($this->custom_js_files);
//echo "<br>jsTotal = ".$jsTotal;exit;
        if($jsTotal > 0)
        {
            $this->data['custom_js_links'] = '';
            foreach ($this->custom_js_files as $key)
            {
                $this->data['custom_js_links'] .= '<script src="'.assets_url().'themes/'.((isset($this->data['themes']) && $this->data['themes'] <> "" && !empty($this->data['themes'])) ? $this->data['themes']."/" : "").$key.'"></script>';
            }
        }

        return;
    }

    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    protected function early_check()
    {
        $this->custom_auth->checkPermission();
        if($this->ion_auth->logged_in())  $this->data['menu']   = $this->custom_auth->generateNavigationData();
    }

    protected function dumpdata($data,$title='')
    {
        echo "<pre><strong>";print_r($title);echo "</strong><br>";print_r($data);echo "<br>";var_dump($data);echo "</pre><br>";
    }

    protected function ajax_json_response($response=array(),$http_code=200)
    {
        $this->view     = FALSE;
        $this->layout   = FALSE;

        $this->output
             ->set_content_type('application/json')
             ->set_status_header($http_code)
             ->set_output(json_encode($response));
    }

    protected function columns_filter($cols=array())
    {
        $filtered_data = $cols;
        $columns = $this->db->list_fields($cols);
        $field  = '';

        if(!is_array($filtered_data))
        {
            $filtered_data  = explode(',', $filtered_data);
        }

        foreach ($columns as $column)
        {
            if (!in_array($column, $filtered_data))
                $field  .= $column.',';
        }
        return rtrim($field, ',');
    }

    protected function get_theme_config()
    {
        $arrmodules = $this->config->item('modules_locations');
        if(!empty($arrmodules) && is_array($arrmodules))    $modules    = array_keys($arrmodules);

        if(isset($modules))
        {
            foreach($modules as $module)
            {
                if(file_exists($module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'config.json'))
                {
                    $config_file = $module.$this->router->class.'/views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").'config.json';
                }
                else
                {
                    $config_file = ((file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/config.json')) ? APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/config.json' : FALSE);
                }
            }
        }
        else
        {
            $config_file = ((file_exists(APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/config.json')) ? APPPATH.'views/'.((isset($this->themes) && $this->themes <> "" && !empty($this->themes)) ? $this->themes : "").$this->router->class.'/config.json' : FALSE);
        }

        if($config_file)
        {
            $config = json_decode(file_get_contents($config_file), true);

            $this->custom_js_files  = @$config[$this->router->method]['custom_js_files'];
            $this->custom_css_files = @$config[$this->router->method]['custom_css_files'];
            $this->asides           = @$config[$this->router->method]['asides'];
            if(isset($config[$this->router->method]['layout']))
            {
                $this->layout           = ((isset($config[$this->router->method]['layout'])) ? (($config[$this->router->method]['layout'] == "FALSE" || $config[$this->router->method]['layout'] == FALSE || $config[$this->router->method]['layout'] == 0) ? FALSE : $config[$this->router->method]['layout']) : TRUE);
            }
        }
    }

}