<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$module_detail = get_module_detail($this->router->class,$this->router->method);
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">
        <?=@$module_detail->webmodules_title?>
    </h4>
</div>
<div class="modal-body no-padding">
	<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.@$webmodules_id,array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'),array('id'=>@$webmodules_id))?>
		<fieldset>
			<div id="messages" style="display: none;">
				<div class="alert"></div>
			</div>
			<legend>Main Module</legend>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$webmodules_class['label'].((isset($webmodules_class['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
					<label class="input state-disabled">
						<?=form_input($webmodules_class,@$webmodules_class['value'],array('class'=>'','readonly'=>'readonly','maxlength'=>'100','title'=>$webmodules_class['title'],'placeholder'=>$webmodules_class['placeholder']))?>
						<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
						</label>
					<div class="note"></div>
				</section>
				<section class="col col-6">
					<label class="label strong"><?=$webmodules_title['label'].((isset($webmodules_title['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
					<label class="input<?=(!empty(form_error('webmodules_title'))) ? ' state-error' : ''?>">
						<?=form_input($webmodules_title,@$webmodules_title['value'],array('class'=>'','maxlength'=>'50','title'=>$webmodules_title['title'],'placeholder'=>$webmodules_title['placeholder']))?>
						<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
					</label>
					<div class="note"></div>
				</section>
			</div>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$webmodules_description['label'].((isset($webmodules_description['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
					<label class="input<?=(!empty(form_error('webmodules_description'))) ? ' state-error' : ''?>">
						<?=form_input($webmodules_description,@$webmodules_description['value'],array('class'=>'','maxlength'=>'100','title'=>$webmodules_description['title'],'placeholder'=>$webmodules_description['placeholder']))?>
						<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
						</label>
					<div class="note"></div>
				</section>
				<section class="col col-6">
					<label class="label strong"><?=$webmodules_icon['label'].((isset($webmodules_icon['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
					<label class="input<?=(!empty(form_error('webmodules_icon'))) ? ' state-error' : ''?>">
						<?=form_input($webmodules_icon,@$webmodules_icon['value'],array('class'=>'','maxlength'=>'100','title'=>$webmodules_icon['title'],'placeholder'=>$webmodules_icon['placeholder']))?>
						<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
						</label>
					<div class="note">Click <a href="http://192.241.236.31/themes/preview/smartadmin/1.8.x/ajax/index.html#ajax/fa.html" target="_blank"><small>here</small></a> for reference</div>
				</section>
			</div>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$editable['label'].((isset($editable['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
					<label class="input select<?=(!empty(form_error('editable'))) ? ' state-error' : ''?>">
						<?=form_dropdown($editable['name'],$editable['data'], @$editable['selected'], array('class'=>''))?><i></i>
					</label>
					<div class="note"></div>
				</section>							
				<section class="col col-6">
					<label class="label strong"><?=$removeable['label'].((isset($removeable['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
					<label class="input select<?=(!empty(form_error('removeable'))) ? ' state-error' : ''?>">
						<?=form_dropdown($removeable['name'],$removeable['data'], @$removeable['selected'], array('class'=>''))?><i></i>
					</label>
					<div class="note"></div>
				</section>							
			</div>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$need_login['label'].((isset($need_login['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
					<label class="input select<?=(!empty(form_error('need_login'))) ? ' state-error' : ''?>">
						<?=form_dropdown($need_login['name'],$need_login['data'], @$need_login['selected'], array('class'=>''))?><i></i>
					</label>
					<div class="note"></div>
				</section>							
				<section class="col col-6">
					<label class="label strong"><?=$groups_access['label'].((isset($groups_access['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
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
									echo '<label class="checkbox"><input type="checkbox" name="'.$groups_access['name'].'" value="'.$idxV.'"'.((isset($groups_access['selected']) && !empty($groups_access['selected']) && !is_null($groups_access['selected']) && is_array($groups_access['selected']) && in_array((int)$idxV, $groups_access['selected'])) ? ' checked' : '').'><i></i>'.$row.'</label>';
								}
							}
							echo '</div>';
						}
					?>
					</div>
					<div class="note"></div>
				</section>
			</div>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$status['label'].((isset($status['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
					<label class="input select<?=(!empty(form_error('status'))) ? ' state-error' : ''?>">
						<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>''))?><i></i>
					</label>
					<div class="note"></div>
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
						<label class="label strong"><?=$webmodules_method_title['label'].((isset($webmodules_method_title['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
						<label class="input">
							<?php
								echo form_hidden('method_id['.$idxM.']', $method->webmodules_id);
								echo form_input($webmodules_method_title,@$method->webmodules_title,array('class'=>'webmodules_method_title','maxlength'=>'100','title'=>$webmodules_method_title['title'],'placeholder'=>$webmodules_method_title['placeholder']));
							?>
						</label>
						<div class="note"></div>
					</section>
					<section class="col col-6">
						<label class="label strong"><?=$method_groups_access['label'].((isset($method_groups_access['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
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
										echo '<label class="checkbox'.(($method->webmodules_method_type <> 'public') ? ' state-disabled' : '').'"><input type="checkbox" name="'.$method_groups_access['name'].'" value="'.$idxV2.'"'.((isset($arrSelGroupsMethod) &&!empty($arrSelGroupsMethod) && !is_null($arrSelGroupsMethod) && is_array($arrSelGroupsMethod) && in_array($idxV2, $arrSelGroupsMethod)) ? (($method->webmodules_method_type <> 'public') ? '' : ' checked') : '').''.(($method->webmodules_method_type <> 'public') ? '  onclick="return false;"' : '').'><i></i>'.$row2.'</label>';
									}
								}
								echo '</div>';
							}
						?>
						</div>
						<div class="note"><strong>Notes:</strong> If nothing selected, group access will be equal with the class group access.</div>
					</section>
					
					<section class="col col-1 button-clone">
						<label class="label">&nbsp;</label>
						<label class="input">
							<a href="javascript:void(0);" class="btn btn-xs btn-primary add-clone" rel="tooltip" data-placement="top" data-original-title="Add Clone"><i class="fa fa-plus"></i></a>
							<a href="javascript:void(0);" class="btn btn-xs btn-danger remove-clone" rel="tooltip" data-placement="top" data-original-title="Remove Clone" data-id="<?=$method->webmodules_id?>"<?=(($totMethod == 1) ? ' style="display: none;"' : '')?>><i class="fa fa-trash"></i></a>
						</label>
					</section>
				</div>
				<div class="row">
					<section class="col col-5">
						<label class="label strong"><?=$webmodules_method['label'].((isset($webmodules_method['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
						<label class="input state-disabled">
							<?=form_input($webmodules_method,@$method->webmodules_method,array('class'=>'webmodules_method','readonly'=>'readonly','maxlength'=>'100','title'=>$webmodules_method['title'],'placeholder'=>$webmodules_method['placeholder']))?>
						</label>
						<div class="note"></div>
					</section>
					<section class="col col-3">
						<label class="label strong"><?=$method_type['label'].((isset($method_type['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
						<label class="select">
							<?=form_dropdown($method_type['name'],$method_type['data'], @$method->webmodules_method_type, array('class'=>'method_type'))?><i></i>
						</label>
					</section>
				</div>
				<hr>
			</div>
			<?php
					}
				}
				else
				{
			?>
			<div class="row_method" id="method-0">
				<div class="row">
					<section class="col col-5">
						<label class="label strong"><?=$webmodules_method_title['label'].((isset($webmodules_method_title['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
						<label class="input">
							<?=form_input($webmodules_method_title,@$webmodules_method_title['value'],array('class'=>'webmodules_method_title','maxlength'=>'100','title'=>$webmodules_method_title['title'],'placeholder'=>$webmodules_method_title['placeholder']))?>
						</label>
						<div class="note"></div>
					</section>
					<section class="col col-6">
						<label class="label strong"><?=$method_groups_access['label'].((isset($method_groups_access['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
						<div class="row">
						<?php
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
										echo '<label class="checkbox"><input type="checkbox" name="'.$method_groups_access['name'].'" value="'.$idxV2.'"><i></i>'.$row2.'</label>';
									}
								}
								echo '</div>';
							}
						?>
						</div>
						<div class="note"><strong>Notes:</strong> If nothing selected, group access will be equal with the class group access.</div>
					</section>
					
					<section class="col col-1 button-clone">
						<label class="label">&nbsp;</label>
						<label class="input">
							<a href="javascript:void(0);" class="btn btn-xs btn-primary add-clone" rel="tooltip" data-placement="top" data-original-title="Add Clone"><i class="fa fa-plus"></i></a>
							<a href="javascript:void(0);" class="btn btn-xs btn-danger remove-clone" rel="tooltip" data-placement="top" data-original-title="Remove Clone" style="display: none;"><i class="fa fa-trash"></i></a>
						</label>
					</section>
				</div>
				<div class="row">
					<section class="col col-5">
						<label class="label strong"><?=$webmodules_method['label'].((isset($webmodules_method['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
						<label class="input">
							<?=form_input($webmodules_method,@$webmodules_method['value'],array('class'=>'webmodules_method','maxlength'=>'100','title'=>$webmodules_method['title'],'placeholder'=>$webmodules_method['placeholder']))?>
						</label>
						<div class="note"></div>
					</section>
					<section class="col col-3">
						<label class="label strong"><?=$method_type['label'].((isset($method_type['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
						<label class="select">
							<?=form_dropdown($method_type['name'],$method_type['data'], @$method_type['selected'], array('class'=>'method_type'))?><i></i>
						</label>
					</section>
				</div>
				<hr>
			</div>
			<?php
				}
			?>
		</fieldset>
       
		<footer>
			<button name="submit" type="submit" class="btn btn-primary">
				<?=$this->lang->line('label_btn_submit')?>
			</button>
			<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
				<?=$this->lang->line('label_btn_cancel')?>
			</button>
		</footer>
	<?=form_close()?>
</div>

<script>
	$(document).ready(function()
	{
		$("[rel=tooltip]").tooltip();

		var totalMethod			= 0;

		$('body').on('keypress keyup', 'form#<?=$this->router->class?> input[name=<?=$webmodules_class['name']?>],form#<?=$this->router->class?> input.webmodules_method',function(e)
		{
			$(this).val($(this).val().toLowerCase().replace(/^[^a-z]+/, '').replace(/ /g,"_"));
		});

		$('body').on('blur', 'form#<?=$this->router->class?> input[name=<?=$webmodules_class['name']?>],form#<?=$this->router->class?> input.webmodules_method',function(e)
		{
			$(this).val($(this).val().toLowerCase().replace(/^[^a-z]+|[^a-z0-9]+$/ig, ''));
		});

		$('body').on('click','#modal-<?=$this->router->class?> form#<?=$this->router->class?> fieldset#webmodules_method div.row_method a.add-clone', function (e)
		{
			totalMethod++;
			var base_html_method 	= ''+
			'<div class="row_method" id="method-'+totalMethod+'">'+
			'	<div class="row">'+
			'		<section class="col col-5">'+
			'			<label class="label strong"><?=$webmodules_method_title['label'].((isset($webmodules_method_title['required'])) ? ' <span class="required">(*)</span>' : '')?></label>'+
			'			<label class="input">'+
			'				<input type="text" name="webmodules_method_title['+totalMethod+']" value="" class="webmodules_method_title" id="webmodules_method_title-'+totalMethod+'" label="<?=$this->lang->line('label_input_webmodules_method_title')?>" placeholder="<?=$this->lang->line('placeholder_input_webmodules_method_title')?>" title="<?=$this->lang->line('title_input_webmodules_method_title')?>" class="" maxlength="100">'+
			'			</label>'+
			'			<div class="note"></div>'+
			'		</section>'+
			'		<section class="col col-6">'+
			'			<label class="label strong"><?=$method_groups_access['label'].((isset($method_groups_access['required'])) ? ' <span class="required">(*)</span>' : '')?></label>'+
			'			<div class="row">'+
						<?php
							$gaCols3[0]	= array();
							$gaCols3[1]	= array();

							$col3 = 0;
							foreach ($method_groups_access['data'] as $idxGA3 => $group3)
							{
								$gaCols3[$col3][$idxGA3]	= $group3;
								$col3++;

								if($col3 == count($gaCols3)) $col3 = 0;
							}

							foreach ($gaCols3 as $idxC2 => $values3)
							{
								echo '\'			<div class="col col-'.(12/(count($gaCols3))).'">\'+
								';
								if(count($values3) > 0)
								{
									foreach ($values3 as $idxV3 => $row3)
									{
										echo '\'			<label class="checkbox"><input type="checkbox" name="method_groups_access[\'+totalMethod+\'][]" value="'.$idxV3.'"><i></i>'.$row3.'</label>\'+
										';
									}
								}
								echo '\'			</div>\'+
								';
							}
						?>
			'			</div>'+
			'			<div class="note"><strong>Notes:</strong> If nothing selected, group access will be equal with the class group access.</div>'+
			'		</section>'+
			'		<section class="col col-1 button-clone">'+
			'			<label class="label">&nbsp;</label>'+
			'			<label class="input">'+
			'				<a href="javascript:void(0);" class="btn btn-xs btn-primary add-clone" rel="tooltip" data-placement="top" data-original-title="Add Clone"><i class="fa fa-plus"></i></a>'+
			'				<a href="javascript:void(0);" class="btn btn-xs btn-danger remove-clone" rel="tooltip" data-placement="top" data-original-title="Remove Clone"><i class="fa fa-trash"></i></a>'+
			'			</label>'+
			'		</section>'+
			'	</div>'+
			'	<div class="row">'+
			'		<section class="col col-5">'+
			'			<label class="label strong"><?=$webmodules_method['label'].((isset($webmodules_method['required'])) ? ' <span class="required">(*)</span>' : '')?></label>'+
			'			<label class="input">'+
			'				<input type="text" name="webmodules_method['+totalMethod+']" value="" class="webmodules_method" id="webmodules_method-'+totalMethod+'" label="<?=$this->lang->line('label_input_webmodules_method')?>" placeholder="<?=$this->lang->line('placeholder_input_webmodules_method')?>" title="<?=$this->lang->line('title_input_webmodules_method')?>" class="" maxlength="100">'+
			'			</label>'+
			'			<div class="note"></div>'+
			'		</section>'+
			'		<section class="col col-3">'+
			'			<label class="label strong"><?=$method_type['label'].((isset($method_type['required'])) ? ' <span class="required">(*)</span>' : '')?></label>'+
			'			<label class="select">'+
			'				<select name="method_type['+totalMethod+']" class="method_type">'+
			'					<option value="public"><?=$this->lang->line('title_status_public')?></option>'+
			'					<option value="protected"><?=$this->lang->line('title_status_protected')?></option>'+
			'					<option value="private"><?=$this->lang->line('title_status_private')?></option>'+
			'				</select>'+
			'			</label>'+
			'		</section>'+
			'	</div>'+
			'	<hr>';
			'</div>';

			var container = $(this).closest('#webmodules_method');

			container.append(base_html_method);
			$(this).closest('.input').find('a.remove-clone').show();
			$("#modal-<?=$this->router->class?> [rel=tooltip]").tooltip();

			$.each(container.find('.row_method'), function( key, row )
			{
				var row = $(container.find('.row_method')[key]);
				row.attr('id','method-'+key);
				row.find('input[type=text].webmodules_method_title').attr('name','webmodules_method_title['+key+']').attr('id','webmodules_method_title-'+key);
				row.find('input[type=text].webmodules_method').attr('name','webmodules_method['+key+']').attr('id','webmodules_method-'+key);
				row.find('input[type=checkbox]').attr('name','method_groups_access['+key+'][]');
				row.find('select').attr('name','method_type['+key+']').attr('id','method_type-'+key);
			});
		});

		$('body').on('click','#modal-<?=$this->router->class?> form#<?=$this->router->class?> fieldset#webmodules_method div.row_method a.remove-clone', function (e)
		{
			var container = $(this).closest('#webmodules_method');
			if((container.find('.row_method').length)-1 == 1)
			{
				container.find('.row_method').find('a.remove-clone').hide();
			}
			var method_container = $(this).closest('.row_method');
			var id = $(this).data('id');
			console.log(id);
			if(id != undefined)
			{
				container.append('<input type="hidden" name="removed_method_id[]" value="'+($(this).data('id'))+'">');
			}
			method_container.next('hr').remove();
			method_container.remove();
			totalMethod--;

			$.each(container.find('.row_method'), function( key, row )
			{
				var row = $(container.find('.row_method')[key]);
				row.attr('id','method-'+key);
				row.find('input[type=text].webmodules_method_title').attr('name','webmodules_method_title['+key+']').attr('id','webmodules_method_title-'+key);
				row.find('input[type=text].webmodules_method').attr('name','webmodules_method['+key+']').attr('id','webmodules_method-'+key);
				row.find('input[type=checkbox]').attr('name','method_groups_access['+key+'][]');
				row.find('select').attr('name','method_type['+key+']').attr('id','method_type-'+key);
			});
		});
	});
</script>