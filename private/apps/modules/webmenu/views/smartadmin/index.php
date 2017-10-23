<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$module_detail = get_module_detail($this->router->class,$this->router->method);
?>
<div class="row">
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-table"></i> 
			<?=$this->lang->line('modules_name')?>
			<span>>  
				<?=@$module_detail->webmodules_title?>
			</span>
		</h1>
	</div>
</div>

<?php if(isset($message) && isset($message['text'])) : ?>
<div class="alert alert-block alert-<?=((isset($message['status'])) ? (($message['status'] == 'error') ? 'danger' : 'success') : 'warning')?>">
	<a class="close" data-dismiss="alert" href="#">×</a>
	<h4 class="alert-heading"><i class="fa fa-<?=((isset($message['status'])) ? (($message['status'] == 'error') ? 'times-circle-o' : 'check-square-o') : 'warning')?>"></i> <?=((isset($message['status'])) ? (($message['status'] == 'error') ? 'Error' : 'Success') : 'Warning')?>!</h4>
	<p><?=((isset($message['text'])) ? $message['text'] : '')?></p>
</div>
<?php endif; ?>


<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?=$this->router->class?>-<?=$this->router->method?>-main-0" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-database"></i> </span>
					<h2>Select Menu</h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'))?>
							<fieldset>
								<div id="messages" style="display: none;">
									<div class="alert"></div>
								</div>
								<div class="row">
									<section class="col col-4">
										<label class="label strong"><?=$webthemes_id['label'].((isset($webthemes_id['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('webthemes_id'))) ? ' state-error' : ''?>">
											<?=form_dropdown($webthemes_id['name'],$webthemes_id['data'], @$webthemes_id['selected'], array('class'=>'','id'=>$webthemes_id['id']))?><i></i>
										</label>
										<div class="note"></div>
									</section>							
									<section class="col col-4">
										<label class="label strong"><?=$webthemesmenu_id['label'].((isset($webthemesmenu_id['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('webthemesmenu_id'))) ? ' state-error' : ''?>">
											<select id="<?=$webthemesmenu_id['id']?>" name="<?=$webthemesmenu_id['name']?>" class="">
												<?php
												if(isset($webthemesmenu_id['data']) && count($webthemesmenu_id['data']) > 0)
												{
													foreach ($webthemesmenu_id['data'] as $idxT => $themes)
													{
														if(isset($themes) && count($themes) > 0)
														{
															foreach ($themes as $idxTM => $menu)
															{
														?>
														<option value="<?=$idxTM?>" data-chained="<?=$idxT?>"><?=$menu?></option>
														<?php
															}
														}
													}
												}
												?>												
											</select>
										</label>
										<div class="note"></div>
									</section>							
									<section class="col col-4">
										<label class="label strong"><?=$groups_id['label'].((isset($groups_id['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('groups_id'))) ? ' state-error' : ''?>">
											<?=form_dropdown($groups_id['name'],$groups_id['data'], @$groups_id['selected'], array('class'=>''))?><i></i>
										</label>
										<div class="note"></div>
									</section>							
								</div>
							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary"><?=$this->lang->line('label_btn_search')?></button>
								<button type="button" class="btn btn-default" onclick="window.history.back();"><?=$this->lang->line('label_btn_cancel')?></button>
							</footer>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</article>				
	</div>
	<div class="row">
		<?php if(isset($webmodules) && count($webmodules) > 0) : ?>
		<article class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?=$this->router->class?>-<?=$this->router->method?>-modules-0" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-user"></i> </span>
					<h2>Modules</h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
						<div class="panel-group smart-accordion-default" id="accordion-modules">
						<?php
						$no = 0;
						foreach ($webmodules as $idxWM => $modules)
						{
						?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-modules" href="#<?=$modules['parent']->webmodules_name?>"> <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i> <?=$modules['parent']->webmodules_title?></a></h4>
								</div>
								<div id="<?=$modules['parent']->webmodules_name?>" class="panel-collapse collapse<?=(($no == 0) ? ' in' : '')?>">
									<div class="panel-body smart-form">
										<ul>
											<?php
											if(isset($modules['child']) && count($modules['child']) > 0)
											{
												foreach ($modules['child'] as $idxMC => $child)
												{
											?>
											<li>
												<span><?=$child->webmodules_title?></span><a href="javascript:void(0);" class="btn btn-xs btn-primary pull-right addToMenu" data-mid="<?=$child->webmodules_id?>" data-gid="<?=$groups_id['selected']?>" data-tid="<?=$webthemesmenu_id['selected']?>">add</a>
											</li>
											<?php
												}
											}
											?>
										</ul>
									</div>
								</div>
							</div>

						<?php
						$no++;
						}
						?>
						</div>
					</div>
				</div>
			</div>
		</article>				
		<article class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?=$this->router->class?>-<?=$this->router->method?>-menu-0" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-user"></i> </span>
					<h2>Menu</h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
						<div class="smart-form">
							<fieldset>
								<div class="dd" id="nestable">
								<?php if(isset($webmenu) && count($webmenu) > 0) : ?>
									<ol class="dd-list" id="nestable-main">
										<?php
										foreach ($webmenu as $idxWM => $menu)
										{
										?>
										<li class="dd-item dd3-item" data-id="<?=$menu['parent']->webmenu_id?>">
											<div class="dd-handle dd3-handle">
												Drag
											</div>
											<div class="dd3-content">
												<div class="panel-group smart-accordion-default" id="accordion-<?=$menu['parent']->webmenu_id?>">
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-<?=$menu['parent']->webmenu_id?>" href="#collapseOne-<?=$menu['parent']->webmenu_id?>" aria-expanded="false" class="collapsed"><?=((isset($menu['parent']->webmenu_icon) && !empty($menu['parent']->webmenu_icon) && !is_null($menu['parent']->webmenu_icon)) ? '<i class="'.$menu['parent']->webmenu_icon.'"></i> ' : '')?><?=$menu['parent']->webmenu_title?> </a></h4>
														</div>
														<div id="collapseOne-<?=$menu['parent']->webmenu_id?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
															<div class="panel-body">
																<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>'edit')),array('id'=>$this->router->class.'-edit-'.$menu['parent']->webmenu_id,'name'=>$this->router->class.'-edit-selected','class'=>'smart-form edit-selected'),array('id'=>$menu['parent']->webmenu_id))?>
																	<fieldset>
																		<div id="messages" style="display: none;">
																			<div class="alert"></div>
																		</div>
																		<section>
																			<label class="label strong"><?=$this->lang->line('label_input_webmenu_title')?></label>
																			<label class="input">
																				<input type="text" name="webmenu_title" value="<?=trim($menu['parent']->webmenu_title)?>" class="input-sm" id="webmenu_title-<?=$menu['parent']->webmenu_id?>" label="<?=$this->lang->line('label_input_webmenu_title')?>" placeholder="<?=$this->lang->line('placeholder_input_webmenu_title')?>" title="<?=$this->lang->line('title_input_webmenu_title')?>">
																			</label>
																			<div class="note"></div>
																		</section>
																		<section>
																			<label class="label strong"><?=$this->lang->line('label_input_webmenu_icon')?></label>
																			<label class="input">
																				<input type="text" name="webmenu_icon" value="<?=trim($menu['parent']->webmenu_icon)?>" class="input-sm" id="webmenu_icon-<?=$menu['parent']->webmenu_id?>" label="<?=$this->lang->line('label_input_webmenu_icon')?>" placeholder="<?=$this->lang->line('placeholder_input_webmenu_icon')?>" title="<?=$this->lang->line('title_input_webmenu_icon')?>">
																			</label>
																			<div class="note">Click <a href="http://192.241.236.31/themes/preview/smartadmin/1.8.x/ajax/index.html#ajax/fa.html" target="_blank"><small>here</small></a> for reference</div>
																		</section>
																	</fieldset>
																	<footer>
																		<button type="submit" class="btn btn-primary"><?=$this->lang->line('label_btn_update')?></button>
																		<button type="button" class="btn btn-danger delete" data-id="<?=$menu['parent']->webmenu_id?>"><?=$this->lang->line('label_btn_delete')?></button>
																	</footer>
																<?=form_close()?>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php
											if(isset($menu['child']) && count($menu['child']) > 0)
											{
											?>
											<ol class="dd-list">
											<?php
												foreach ($menu['child'] as $idxC => $submenu)
												{
											?>
												<li class="dd-item dd3-item" data-id="<?=$submenu['parent']->webmenu_id?>">
													<div class="dd-handle dd3-handle">
														Drag
													</div>
													<div class="dd3-content">
														<div class="panel-group smart-accordion-default" id="accordion-<?=$submenu['parent']->webmenu_id?>">
															<div class="panel panel-default">
																<div class="panel-heading">
																	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-<?=$submenu['parent']->webmenu_id?>" href="#collapseOne-<?=$submenu['parent']->webmenu_id?>" aria-expanded="false" class="collapsed"><?=((isset($submenu['parent']->webmenu_icon) && !empty($submenu['parent']->webmenu_icon) && !is_null($submenu['parent']->webmenu_icon)) ? '<i class="'.$submenu['parent']->webmenu_icon.'"></i> ' : '')?><?=$submenu['parent']->webmenu_title?> </a></h4>
																</div>
																<div id="collapseOne-<?=$submenu['parent']->webmenu_id?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
																	<div class="panel-body">
																		<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>'edit')),array('id'=>$this->router->class.'-edit-'.$submenu['parent']->webmenu_id,'name'=>$this->router->class.'-edit-selected','class'=>'smart-form edit-selected'),array('id'=>$submenu['parent']->webmenu_id))?>
																			<fieldset>
																				<div id="messages" style="display: none;">
																					<div class="alert"></div>
																				</div>
																				<section>
																					<label class="label strong"><?=$this->lang->line('label_input_webmenu_title')?></label>
																					<label class="input">
																						<input type="text" name="webmenu_title" value="<?=trim($submenu['parent']->webmenu_title)?>" class="input-sm" id="webmenu_title-<?=$submenu['parent']->webmenu_id?>" label="<?=$this->lang->line('label_input_webmenu_icon')?>" placeholder="<?=$this->lang->line('placeholder_input_webmenu_icon')?>" title="<?=$this->lang->line('title_input_webmenu_title')?>">
																					</label>
																					<div class="note"></div>
																				</section>
																				<section>
																					<label class="label strong"><?=$this->lang->line('label_input_webmenu_icon')?></label>
																					<label class="input">
																						<input type="text" name="webmenu_icon" value="<?=trim($submenu['parent']->webmenu_icon)?>" class="input-sm" id="webmenu_icon-<?=$submenu['parent']->webmenu_id?>" label="<?=$this->lang->line('label_input_webmenu_icon')?>" placeholder="<?=$this->lang->line('placeholder_input_webmenu_icon')?>" title="<?=$this->lang->line('title_input_webmenu_icon')?>">
																					</label>
																					<div class="note">Click <a href="http://192.241.236.31/themes/preview/smartadmin/1.8.x/ajax/index.html#ajax/fa.html" target="_blank"><small>here</small></a> for reference</div>
																				</section>
																			</fieldset>
																			<footer>
																				<button type="submit" class="btn btn-primary"><?=$this->lang->line('label_btn_update')?></button>
																				<button type="button" class="btn btn-danger delete" data-id="<?=$submenu['parent']->webmenu_id?>"><?=$this->lang->line('label_btn_delete')?></button>
																			</footer>
																		<?=form_close()?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<?php
													if(isset($submenu['child']) && count($submenu['child']) > 0)
													{
													?>
													<ol class="dd-list">
													<?php
														foreach ($submenu['child'] as $idxC2 => $submenu2)
														{
													?>
														<li class="dd-item dd3-item" data-id="<?=$submenu2->webmenu_id?>">
															<div class="dd-handle dd3-handle">
																Drag
															</div>
															<div class="dd3-content">
																<div class="panel-group smart-accordion-default" id="accordion-<?=$submenu2->webmenu_id?>">
																	<div class="panel panel-default">
																		<div class="panel-heading">
																			<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-<?=$submenu2->webmenu_id?>" href="#collapseOne-<?=$submenu2->webmenu_id?>" aria-expanded="false" class="collapsed"><?=((isset($submenu2->webmenu_icon) && !empty($submenu2->webmenu_icon) && !is_null($submenu2->webmenu_icon)) ? '<i class="'.$submenu2->webmenu_icon.'"></i> ' : '')?><?=$submenu2->webmenu_title?> </a></h4>
																		</div>
																		<div id="collapseOne-<?=$submenu2->webmenu_id?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
																			<div class="panel-body">
																				<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>'edit')),array('id'=>$this->router->class.'-edit-'.$submenu2->webmenu_id,'name'=>$this->router->class.'-edit-selected','class'=>'smart-form edit-selected'),array('id'=>$submenu2->webmenu_id))?>
																					<fieldset>
																						<div id="messages" style="display: none;">
																							<div class="alert"></div>
																						</div>
																						<section>
																							<label class="label strong"><?=$this->lang->line('label_input_webmenu_title')?></label>
																							<label class="input">
																								<input type="text" name="webmenu_title" value="<?=trim($submenu2->webmenu_title)?>" class="input-sm" id="webmenu_title-<?=$submenu2->webmenu_id?>" label="<?=$this->lang->line('label_input_webmenu_icon')?>" placeholder="<?=$this->lang->line('placeholder_input_webmenu_icon')?>" title="<?=$this->lang->line('title_input_webmenu_title')?>">
																							</label>
																							<div class="note"></div>
																						</section>
																						<section>
																							<label class="label strong"><?=$this->lang->line('label_input_webmenu_icon')?></label>
																							<label class="input">
																								<input type="text" name="webmenu_icon" value="<?=trim($submenu2->webmenu_icon)?>" class="input-sm" id="webmenu_icon-<?=$submenu2->webmenu_id?>" label="<?=$this->lang->line('label_input_webmenu_icon')?>" placeholder="<?=$this->lang->line('placeholder_input_webmenu_icon')?>" title="<?=$this->lang->line('title_input_webmenu_icon')?>">
																							</label>
																							<div class="note">Click <a href="http://192.241.236.31/themes/preview/smartadmin/1.8.x/ajax/index.html#ajax/fa.html" target="_blank"><small>here</small></a> for reference</div>
																						</section>
																					</fieldset>
																					<footer>
																						<button type="submit" class="btn btn-primary"><?=$this->lang->line('label_btn_update')?></button>
																						<button type="button" class="btn btn-danger delete" data-id="<?=$submenu2['parent']->webmenu_id?>"><?=$this->lang->line('label_btn_delete')?></button>
																					</footer>
																				<?=form_close()?>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</li>
													<?php
														}
													?>
													</ol>
													<?php
													}
													?>
												</li>
											<?php
												}
											?>
											</ol>
											<?php
											}
											?>
										</li>
										<?php
										}
										?>
									</ol>
								<?php endif; ?>
								</div>
							</fieldset>
						</div>
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>'edit')),array('id'=>$this->router->class.'-edit-all','name'=>$this->router->class.'-edit-all','class'=>'smart-form edit-all'))?>
							<input type="hidden" id="nestable-output" name="all_menu">
							<?=form_hidden('webthemes_id',$webthemes_id['selected'])?>
							<?=form_hidden('webthemesmenu_id',$webthemesmenu_id['selected'])?>
							<?=form_hidden('groups_id',$groups_id['selected'])?>
							<footer>
								<button type="submit" class="btn btn-primary"><?=$this->lang->line('label_btn_submit')?></button>
								<button type="button" class="btn btn-default" onclick="window.history.back();"><?=$this->lang->line('label_btn_cancel')?></button>
							</footer>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</article>	
		<?php endif; ?>			
	</div>
</section>