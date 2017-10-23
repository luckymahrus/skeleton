<div class="uk-block-bg-login uk-block-bg-login-zat412">
	<div class="uk-grid uk-grid-match uk-height-viewport" data-uk-grid-match>
		<div class="uk-width-medium-3-4"> </div>
	</div>
</div>

<nav class="uk-navbar uk-visible-small">
    <a href="<?=base_url()?>" class="uk-navbar-brand"></a>
</nav>
<div id="loginpage">
	<div class="header-container">
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-medium-1-1 uk-flex uk-flex-bottom">
                    <img class="uk-hidden-small" src="<?=assets_url(@$themes.'/images/logo/logo.jpg')?>">
                    <div class="header-content">
                        <h1 class="title"><strong>ZAT</strong> <em>4 tot 12 jaar</em></h1>
                        <p class="info uk-visible-small">Welkom op Zorg Beuningen 4 tot 12 jaar. Deze site is bestemd voor alle instanties die betrokken zijn bij het Zorg Advies Team. Je kunt je aanmelden met jouw persoonlijke gebruikersnaam en wachtwoord.</p>
                        <a href="<?=base_url()?>" class="uk-button uk-button-large uk-button-home uk-button-home-zat412">Naar website <i class="uk-icon uk-icon-chevron-right"></i></a>
                    </div>
                </div>
                <div class="uk-width-2-5 uk-hidden-small">
                    <div class="header-content header-content-412">
                        <p class="info">Welkom op Zorg Beuningen 4 tot 12 jaar. Deze site is bestemd voor alle instanties die betrokken zijn bij het Zorg Advies Team. Je kunt je aanmelden met jouw persoonlijke gebruikersnaam en wachtwoord.</p>
                    </div>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-4 uk-container-center uk-text-center uk-hidden-small">
                    <?=form_open(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.$code, array('class' => 'uk-form', 'id' => $this->router->class.'-'.$this->router->method, 'method' => 'post'),array('users_id'=>$users_id,'code'=>$code))?>
                        <fieldset>
				            <div class="uk-grid">
							    <div class="uk-width-1-1">
									<h3 class="page-title"><?=lang('reset_password_heading')?></h3>
							    </div>
			                </div>
							<?php if(isset($message) && isset($message['text'])) : ?>
                            <div class="uk-alert uk-alert-<?=((isset($message['status'])) ? (($message['status'] == 'error') ? 'danger' : $message['status']) : 'success')?>" data-uk-alert>
                                <p><?=((isset($message['text'])) ? '<p>'.$message['text'].'</p>' : '')?></p>
                            </div>
							<?php endif; ?>
                            <div class="uk-form-row uk-width-1-1">
                                <div class="uk-form-icon uk-form-password uk-width-1-1">
                                    <i class="uk-icon uk-icon-key"></i>
                                    <?=form_password($new_password,$new_password['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$new_password['title'],'placeholder'=>$new_password['placeholder']))?>
                                    <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'<?=$this->lang->line('title_link_show_password')?>', lblHide:'<?=$this->lang->line('title_link_hide_password')?>'}"><?=$this->lang->line('text_link_show_password')?></a>
                                </div>
                                <span class="uk-form-help-block uk-form-alert-danger alert" style="display:none;">error</span>
                                <?=form_error($new_password['name'],'<span class="uk-form-help-block uk-form-alert-danger alert" style="hidden">','</span>')?>
                            </div>
                            <div class="uk-form-row uk-width-1-1">
                                <div class="uk-form-icon uk-form-password uk-width-1-1">
                                    <i class="uk-icon uk-icon-key"></i>
                                    <?=form_password($new_password_confirm,$new_password_confirm['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$new_password_confirm['title'],'placeholder'=>$new_password_confirm['placeholder']))?>
                                    <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'<?=$this->lang->line('title_link_show_password')?>', lblHide:'<?=$this->lang->line('title_link_hide_password')?>'}"><?=$this->lang->line('text_link_show_password')?></a>
                                </div>
                                <?=form_error($new_password_confirm['name'],'<span class="uk-form-help-inline uk-form-alert-danger">','</span>')?>
                            </div>
                            <div class="uk-form-row"><button class="uk-width-1-1 uk-button uk-button-back uk-button-large" data-uk-tooltip="{pos:'top-left'}" title="<?=$this->lang->line('title_btn_reset_password')?>"><?=$this->lang->line('label_btn_reset_password')?></button></div>
                            <div class="uk-form-row uk-text-small">
                                <a class="uk-float-left uk-link uk-link-muted" href="<?=links_url(array('class'=>'auth','method'=>'login'))?>" data-uk-tooltip="{pos:'top-left'}" title="<?=$this->lang->line('title_link_login')?>"><?=$this->lang->line('text_link_login')?></a>
		                    </div>
                        </fieldset>
					<?=form_close()?>
		        </div>
                <div class="uk-width-1-1 uk-visible-small">
					<?=form_open(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.$code, array('class' => 'uk-form', 'id' => $this->router->class.'-'.$this->router->method, 'method' => 'post'),array('users_id'=>$users_id,'code'=>$code))?>
                        <fieldset>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <h3 class="page-title"><?=lang('reset_password_heading')?></h3>
                                </div>
                            </div>
                            <?php if(isset($message) && isset($message['text'])) : ?>
                            <div class="uk-alert uk-alert-<?=((isset($message['status'])) ? (($message['status'] == 'error') ? 'danger' : $message['status']) : 'success')?>" data-uk-alert>
                                <p><?=((isset($message['text'])) ? '<p>'.$message['text'].'</p>' : '')?></p>
                            </div>
                            <?php endif; ?>
                            <div class="uk-form-row uk-width-1-1">
                                <div class="uk-form-icon uk-form-password uk-width-1-1">
                                    <i class="uk-icon uk-icon-key"></i>
                                    <?=form_password($new_password,$new_password['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$new_password['title'],'placeholder'=>$new_password['placeholder']))?>
                                    <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'<?=$this->lang->line('title_link_show_password')?>', lblHide:'<?=$this->lang->line('title_link_hide_password')?>'}"><?=$this->lang->line('text_link_show_password')?></a>
                                </div>
                                <?=form_error($new_password['name'],'<span class="uk-form-help-inline uk-form-alert-danger">','</span>')?>
                            </div>
                            <div class="uk-form-row uk-width-1-1">
                                <div class="uk-form-icon uk-form-password uk-width-1-1">
                                    <i class="uk-icon uk-icon-key"></i>
                                    <?=form_password($new_password_confirm,$new_password_confirm['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$new_password_confirm['title'],'placeholder'=>$new_password_confirm['placeholder']))?>
                                    <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'<?=$this->lang->line('title_link_show_password')?>', lblHide:'<?=$this->lang->line('title_link_hide_password')?>'}"><?=$this->lang->line('text_link_show_password')?></a>
                                </div>
                                <?=form_error($new_password_confirm['name'],'<span class="uk-form-help-inline uk-form-alert-danger">','</span>')?>
                            </div>
                            <div class="uk-form-row"><button class="uk-width-1-1 uk-button uk-button-back uk-button-large" data-uk-tooltip="{pos:'top-left'}" title="<?=$this->lang->line('title_btn_reset_password')?>"><?=$this->lang->line('label_btn_reset_password')?></button></div>
                            <div class="uk-form-row uk-text-small">
                                <a class="uk-float-left uk-link uk-link-muted" href="<?=links_url(array('class'=>'auth','method'=>'login'))?>" data-uk-tooltip="{pos:'top-left'}" title="<?=$this->lang->line('title_link_login')?>"><?=$this->lang->line('text_link_login')?></a>
                            </div>
                        </fieldset>
					<?=form_close()?>
		        </div>
	        </div>
        </div>
	</div>	
</div>
