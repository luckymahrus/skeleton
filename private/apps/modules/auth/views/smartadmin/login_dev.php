				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
						<div class="well no-padding">
							<?=form_open(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)), array('class' => 'smart-form client-form', 'id' => 'login-form', 'method' => 'post'))?>
								<header class="strong">
									<?=@$module_detail->webmodules_title?>
								</header>

								<fieldset>
									<section>
										<?=lang('login_subheading', '', array('class'=>'label'))?>
									</section>

									<?php if($this->session->flashdata('message') || isset($message)) : $message = (($this->session->flashdata('message')) ? $this->session->flashdata('message') : $message); ?>
									<section>
										<div class="alert alert-<?=((isset($message['class'])) ? $message['class'] : 'info')?> fade in">
											<button class="close" data-dismiss="alert">×</button>
											<i class="fa-fw fa <?=((isset($message['icon'])) ? $message['icon'] : 'fa-info')?>"></i>
											<strong><?=((isset($message['status'])) ? $message['status'] : 'Info')?></strong>
											<?php
											if(isset($message['text']))
											{
												if(is_array($message['text']))
												{
													foreach ($message['text'] as $idxM => $msg)
													{
														echo $msg.'<br>';
													}
												}
												else
												{
													echo $message['text'];
												}
											}
											?>
										</div>
									</section>
									<?php endif; ?>

									<section>
										<label class="label strong"><?=$identity['label'].((isset($identity['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
											<?=form_input($identity,$identity['value'],array('class'=>'','maxlength'=>'50','title'=>$identity['title'],'placeholder'=>$identity['placeholder']))?>
											<!-- <?=form_input($identity)?> -->
											<b class="tooltip tooltip-top-right"><i class="fa fa-envelope txt-color-teal"></i> <?=$this->lang->line('login_identity_label')?></b>
										</label>
                                    	<?=form_error($identity['name'],'<div class="note note-error">','</div>')?>
									</section>

									<section>
										<label class="label strong"><?=$password['label'].((isset($password['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<?=form_password($password,$password['value'],array('class'=>'','maxlength'=>'50','title'=>$password['title'],'placeholder'=>$password['placeholder']))?>
											<!-- <?=form_password($password)?> -->
											<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> <?=$this->lang->line('login_password_label')?></b>
										</label>
                                    	<?=form_error($password['name'],'<div class="note note-error">','</div>')?>
										<div class="note">
											<a href="<?=links_url(array('class'=>'auth','method'=>'forgot_password'))?>"><?=lang('login_forgot_password')?></a>
										</div>
									</section>
								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary">
										<?=$this->lang->line('label_btn_login_admin')?>
									</button>
								</footer>
							<?=form_close()?>

						</div>
					</div>
				</div>