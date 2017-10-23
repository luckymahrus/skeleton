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

		                            <?php if(isset($users_email)) : ?>
									<section>
										<?=lang('login_identity_label', $users_email['name'], array('class'=>'label'))?>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
		                                    <?=form_input($users_email,@$users_email['value'],array('class'=>'','title'=>$users_email['title'],'placeholder'=>$users_email['placeholder']))?>
											<b class="tooltip tooltip-top-right"><i class="fa fa-envelope txt-color-teal"></i> <?=$this->lang->line('login_identity_label')?></b>
										</label>
                                    	<?=form_error($users_email['name'],'<div class="note note-error">','</div>')?>
									</section>
		                            <?php endif;  if(isset($users_username)) : ?>
									<section>
										<?=lang('login_identity_label', $users_email['name'], array('class'=>'label'))?>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
		                                    <?=form_input($users_username,@$users_username['value'],array('class'=>'','title'=>$users_username['title'],'placeholder'=>$users_username['placeholder']))?>
											<b class="tooltip tooltip-top-right"><i class="fa fa-envelope txt-color-teal"></i> <?=$this->lang->line('login_identity_label')?></b>
										</label>
                                    	<?=form_error($users_username['name'],'<div class="note note-error">','</div>')?>
									</section>
		                            <?php endif; ?>
								</fieldset>
								<footer>
									<?=form_submit('submit', lang('login_submit_btn'),array('class'=>'btn btn-primary'))?>
									<?php if($this->config->item('maintenance_mode') == TRUE) : ?>
									<a href="<?=links_url(array('class'=>$this->router->class,'method'=>'logout'))?>" class="btn btn-warning">Logout Maintenance Mode</a>
									<?php endif; ?>
								</footer>
							<?=form_close()?>

						</div>
					</div>
				</div>
