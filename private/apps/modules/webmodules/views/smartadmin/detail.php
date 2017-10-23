<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$module_detail = get_module_detail($this->router->class,$this->router->method);
?>
<div class="row">
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-pencil-square-o"></i> 
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
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?=$this->router->class?>-<?=$this->router->method?>-0" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-user"></i> </span>
					<h2><?=@$module_detail->webmodules_title?> </h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
						<?=form_open_multipart('#',array('class'=>'smart-form'))?>
							<fieldset>
								<legend>Main Module</legend>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$webmodules_class['label']?></label>
										<label class="input state-disabled">
											<?=form_input($webmodules_class,@$webmodules_class['value'],array('class'=>'','disabled'=>'disabled','readonly'=>'readonly','maxlength'=>'100','title'=>$webmodules_class['title'],'placeholder'=>$webmodules_class['placeholder']))?>
										</label>
									</section>
									<section class="col col-6">
										<label class="label strong"><?=$webmodules_title['label']?></label>
										<label class="input state-disabled">
											<?=form_input($webmodules_title,@$webmodules_title['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$webmodules_title['title'],'placeholder'=>$webmodules_title['placeholder']))?>
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$webmodules_description['label']?></label>
										<label class="input state-disabled">
											<?=form_input($webmodules_description,@$webmodules_description['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$webmodules_description['title'],'placeholder'=>$webmodules_description['placeholder']))?>
										</label>
									</section>
									<section class="col col-6">
										<label class="label strong"><?=$webmodules_icon['label']?></label>
										<label class="input state-disabled">
											<?=form_input($webmodules_icon,@$webmodules_icon['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$webmodules_icon['title'],'placeholder'=>$webmodules_icon['placeholder']))?>
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$editable['label']?></label>
										<label class="input select state-disabled">
											<?=form_dropdown($editable['name'],$editable['data'], @$editable['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
										</label>
									</section>							
									<section class="col col-6">
										<label class="label strong"><?=$removeable['label']?></label>
										<label class="input select state-disabled">
											<?=form_dropdown($removeable['name'],$removeable['data'], @$removeable['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
										</label>
									</section>							
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$need_login['label']?></label>
										<label class="input select state-disabled">
											<?=form_dropdown($need_login['name'],$need_login['data'], @$need_login['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
										</label>
									</section>							
									<section class="col col-6">
										<label class="label strong"><?=$groups_access['label']?></label>
										<div class="row">
										<?php
											$gaCols[0]	= array();
											$gaCols[1]	= array();

											$col = 0;
											foreach ($groups_access['data'] as $idxGA => $group)
											{
												$gaCols[$col][$idxGA]	= $group;
												$col++;

												if($col == count($gaCols)) $col = 0;
											}

											foreach ($gaCols as $idxC => $values)
											{
												echo '<div class="col col-'.(12/(count($gaCols))).'">';
												if(count($values) > 0)
												{
													foreach ($values as $idxV => $row)
													{
														echo '<label class="checkbox state-disabled"><input type="checkbox" name="'.$groups_access['name'].'" value="'.$idxV.'"'.((isset($groups_access['selected']) && !empty($groups_access['selected']) && !is_null($groups_access['selected']) && is_array($groups_access['selected']) && in_array((int)$idxV, $groups_access['selected'])) ? ' checked' : '').' disabled><i></i>'.$row.'</label>';
													}
												}
												echo '</div>';
											}
										?>
										</div>
									</section>
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$status['label']?></label>
										<label class="input select state-disabled">
											<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
										</label>
									</section>							
								</div>
							</fieldset>
					 		<fieldset id="webmodules_method">
								<section>
									<legend>Method / Function</legend>
								</section>
								<?php 
									if(isset($methods) && count($methods) > 0)
									{
										$totMethod = count($methods);
										foreach ($methods as $idxM => $method)
										{
											$webmodules_method_title['name'] 	= 'webmodules_method_title['.$idxM.']';
											$webmodules_method_title['id'] 		= 'webmodules_method_title-'.$idxM;
											$webmodules_method['name'] 			= 'webmodules_method['.$idxM.']';
											$webmodules_method['id'] 			= 'webmodules_method-'.$idxM;
											$method_type['name'] 				= 'method_type['.$idxM.']';
											$method_type['id'] 					= 'method_type-'.$idxM;
											$method_groups_access['name'] 		= 'method_groups_access['.$idxM.'][]';
								?>
								<div class="row_method" id="method-<?=$idxM?>">
									<div class="row">
										<section class="col col-5">
											<label class="label strong"><?=$webmodules_method_title['label']?></label>
											<label class="input select state-disabled">
												<?php
													echo form_hidden('method_id['.$idxM.']', $method->webmodules_id);
													echo form_input($webmodules_method_title,@$method->webmodules_title,array('class'=>'webmodules_method_title','maxlength'=>'100','title'=>$webmodules_method_title['title'],'placeholder'=>$webmodules_method_title['placeholder']));
												?>
											</label>
											</section>
										<section class="col col-6">
											<label class="label strong"><?=$method_groups_access['label']?></label>
											<div class="row">
											<?php
												if(isset($method->groups_access) && !empty($method->groups_access) && !is_null($method->groups_access))
												{
													$serialGroupsMethod = unserialize($method->groups_access);
													$arrSelGroupsMethod = array();
													foreach ($serialGroupsMethod as $idxSGM => $mGroup)
													{
														$arrSelGroupsMethod[$mGroup] = $mGroup;
													}
												}
												$gaCols2[0]	= array();
												$gaCols2[1]	= array();

												$col2 = 0;
												foreach ($method_groups_access['data'] as $idxGA2 => $group2)
												{
													$gaCols2[$col2][$idxGA2]	= $group2;
													$col2++;

													if($col2 == count($gaCols2)) $col2 = 0;
												}

												foreach ($gaCols2 as $idxC2 => $values2)
												{
													echo '<div class="col col-'.(12/(count($gaCols2))).'">';
													if(count($values2) > 0)
													{
														foreach ($values2 as $idxV2 => $row2)
														{
															echo '<label class="checkbox state-disabled'.(($method->webmodules_method_type <> 'public') ? ' state-disabled' : '').'"><input type="checkbox" name="'.$method_groups_access['name'].'" value="'.$idxV2.'"'.((isset($arrSelGroupsMethod) &&!empty($arrSelGroupsMethod) && !is_null($arrSelGroupsMethod) && is_array($arrSelGroupsMethod) && in_array($idxV2, $arrSelGroupsMethod)) ? (($method->webmodules_method_type <> 'public') ? '' : ' checked') : '').''.(($method->webmodules_method_type <> 'public') ? '  onclick="return false;"' : '').' disabled><i></i>'.$row2.'</label>';
														}
													}
													echo '</div>';
												}
											?>
											</div>
										</section>
									</div>
									<div class="row">
										<section class="col col-5">
											<label class="label strong"><?=$webmodules_method['label']?></label>
											<label class="input state-disabled">
												<?=form_input($webmodules_method,@$method->webmodules_method,array('class'=>'webmodules_method','readonly'=>'readonly','maxlength'=>'100','title'=>$webmodules_method['title'],'placeholder'=>$webmodules_method['placeholder']))?>
											</label>
										</section>
										<section class="col col-3">
											<label class="label strong"><?=$method_type['label']?></label>
											<label class="input select state-disabled">
												<?=form_dropdown($method_type['name'],$method_type['data'], @$method->webmodules_method_type, array('class'=>'method_type','disabled'=>'disabled'))?><i></i>
											</label>
										</section>
									</div>
									<hr>
								</div>
								<?php
										}
									}
								?>
							</fieldset>
							
							<footer>
								<button type="button" class="btn btn-default" onclick="window.history.back();">
									<?=$this->lang->line('label_btn_back')?>
								</button>
							</footer>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>

