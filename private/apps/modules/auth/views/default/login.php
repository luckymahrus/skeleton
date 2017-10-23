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
					<?=form_open(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), array('class' => 'uk-form', 'id' => 'login-form', 'method' => 'post'))?>
                        <fieldset>
				            <div class="uk-grid">
							    <div class="uk-width-1-1">
									<h3 class="page-title"><?=lang('login_heading')?></h3>
							    </div>
			                </div>
							<?php if(isset($message) && isset($message['text'])) : ?>
                            <div class="uk-alert uk-alert-<?=((isset($message['status'])) ? (($message['status'] == 'error') ? 'danger' : $message['status']) : 'success')?>" data-uk-alert>
                                <p><?=((isset($message['text'])) ? '<p>'.$message['text'].'</p>' : '')?></p>
                            </div>
							<?php endif; ?>
                            <div class="uk-form-row uk-width-1-1">
                                <div class="uk-form-icon uk-width-1-1">
                                    <i class="uk-icon uk-icon-<?=(($this->config->item('identity') == 'usersUsername' ) ? 'user' : 'envelope')?>"></i>
                                    <?=form_input($identity,$identity['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$identity['title'],'placeholder'=>$identity['placeholder']))?>
                                </div>
                                <?=form_error($identity['name'],'<span class="uk-form-help-inline uk-form-alert-danger">','</span>')?>
                            </div>
                            <div class="uk-form-row uk-width-1-1">
                                <div class="uk-form-icon uk-form-password uk-width-1-1">
                                    <i class="uk-icon uk-icon-unlock-alt"></i>
                                    <?=form_password($password,$password['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$password['title'],'placeholder'=>$password['placeholder']))?>
                                    <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'<?=$this->lang->line('title_link_show_password')?>', lblHide:'<?=$this->lang->line('title_link_hide_password')?>'}"><?=$this->lang->line('text_link_show_password')?></a>
                                </div>
                                <?=form_error($password['name'],'<span class="uk-form-help-inline uk-form-alert-danger">','</span>')?>
                            </div>
                            <div class="uk-form-row"><button class="uk-width-1-1 uk-button uk-button-back uk-button-large" data-uk-tooltip="{pos:'top-left'}" title="<?=$this->lang->line('title_btn_login')?>"><?=$this->lang->line('login_submit_btn')?></button></div>
                            <div class="uk-form-row uk-text-small">
                                <?php if($this->config->item('remember_users')) : ?>
		                        <label class="uk-float-left"><input type="checkbox"> <?=$this->lang->line('login_remember_label')?></label>
                                <?php endif; ?>
		                        <a class="uk-float-right uk-link uk-link-muted" href="<?=links_url(array('class'=>'auth','method'=>'forgot_password'))?>"><?=$this->lang->line('login_forgot_password')?></a>
		                    </div>
                        </fieldset>
	                    <!-- <div class="uk-form-row">
	                        <input class="uk-width-1-1 uk-form-large" type="text" placeholder="Username">
	                    </div>
	                    <div class="uk-form-row">
						    <div class="uk-form-row uk-form-password">
						        <input type="password" name="usersPassword" placeholder="Wachtwoord" class="uk-width-1-1 uk-form-large">
						        <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'Tonen', lblHide:'Verbergen'}">Tonen</a>
						    </div>
	                    </div>
	                    <div class="uk-form-row">
	                        <button type="submit" class="uk-width-1-1 uk-button uk-button-back uk-button-large" href="#">Login</button>
	                    </div>
	                    <div class="uk-form-row uk-text-small">
	                        <label class="uk-float-left"><input type="checkbox"> Remember Me</label>
	                        <a class="uk-float-right uk-link uk-link-muted" href="#">Forgot Password?</a>
	                    </div> -->
					<?=form_close()?>
		        </div>
                <div class="uk-width-1-1 uk-visible-small">
					<?=form_open(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), array('class' => 'uk-form', 'id' => 'login-form', 'method' => 'post'))?>
                        <fieldset>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <h3 class="page-title"><?=lang('login_heading')?></h3>
                                </div>
                            </div>
                            <?php if(isset($message) && isset($message['text'])) : ?>
                            <div class="uk-alert uk-alert-<?=((isset($message['status'])) ? (($message['status'] == 'error') ? 'danger' : $message['status']) : 'success')?>" data-uk-alert>
                                <p><?=((isset($message['text'])) ? '<p>'.$message['text'].'</p>' : '')?></p>
                            </div>
                            <?php endif; ?>
                            <div class="uk-form-row uk-width-1-1">
                                <div class="uk-form-icon uk-width-1-1">
                                    <i class="uk-icon uk-icon-<?=(($this->config->item('identity') == 'usersUsername' ) ? 'user' : 'envelope')?>"></i>
                                    <?=form_input($identity,$identity['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$identity['title'],'placeholder'=>$identity['placeholder']))?>
                                </div>
                                <?=form_error($identity['name'],'<span class="uk-form-help-inline uk-form-alert-danger">','</span>')?>
                            </div>
                            <div class="uk-form-row uk-width-1-1">
                                <div class="uk-form-icon uk-form-password uk-width-1-1">
                                    <i class="uk-icon uk-icon-unlock-alt"></i>
                                    <?=form_password($password,$password['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$password['title'],'placeholder'=>$password['placeholder']))?>
                                    <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'<?=$this->lang->line('title_link_show_password')?>', lblHide:'<?=$this->lang->line('title_link_hide_password')?>'}"><?=$this->lang->line('text_link_show_password')?></a>
                                </div>
                                <?=form_error($password['name'],'<span class="uk-form-help-inline uk-form-alert-danger">','</span>')?>
                            </div>
                            <div class="uk-form-row"><button class="uk-width-1-1 uk-button uk-button-back uk-button-large" data-uk-tooltip="{pos:'top-left'}" title="<?=$this->lang->line('title_btn_login')?>"><?=$this->lang->line('login_submit_btn')?></button></div>
                            <div class="uk-form-row uk-text-small">
                                <?php if($this->config->item('remember_users')) : ?>
                                <label class="uk-float-left"><input type="checkbox"> <?=$this->lang->line('login_remember_label')?></label>
                                <?php endif; ?>
                                <a class="uk-float-right uk-link uk-link-muted" href="<?=links_url(array('class'=>'auth','method'=>'forgot_password'))?>"><?=$this->lang->line('login_forgot_password')?></a>
                            </div>
                        </fieldset>
                        <!-- <div class="uk-form-row uk-form-icon uk-width-1-1">
                            <i class="uk-icon uk-icon-<?=(($this->config->item('identity') == 'usersUsername' ) ? 'user' : 'envelope')?>"></i>
                            <?=form_input($identity,$identity['value'],array('class'=>'uk-form-large uk-width-1-1','data-uk-tooltip'=>"{pos:'top-left'}",'title'=>$identity['title'],'placeholder'=>$identity['placeholder']))?>
                        </div>
                        <?=form_error($identity['name'],'<span class="uk-form-help-inline uk-form-alert-danger">','</span>')?>
	                    <div class="uk-form-row">
						    <div class="uk-form-row uk-form-password">
								<?=lang('login_dev_password_label', $password['name'], array('class'=>'label'))?>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<?=form_password($password)?>
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> <?=$this->lang->line('login_dev_password_label')?></b>
								</label>
                            	<?=form_error($password['name'],'<div class="note note-error">','</div>')?>
						        <input type="password" name="usersPassword" placeholder="Wachtwoord" class="uk-width-1-1 uk-form-large">
						        <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'Tonen', lblHide:'Verbergen'}">Tonen</a>
						    </div>
	                    </div>
	                    <div class="uk-form-row">
	                    	<?=form_submit('submit', lang('login_dev_submit_btn'),array('class'=>'uk-width-1-1 uk-button uk-button-back uk-button-large'))?>
	                    </div>
	                    <div class="uk-form-row uk-text-small">
	                        <label class="uk-float-left"><input type="checkbox"> Remember Me</label>
	                        <a class="uk-float-right uk-link uk-link-muted" href="#">Forgot Password?</a>
	                    </div> -->
					<?=form_close()?>
		        </div>
	        </div>
        </div>
	</div>	
</div>
