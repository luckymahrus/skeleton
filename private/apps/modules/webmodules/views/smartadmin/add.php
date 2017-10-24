<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if(!$this->input->is_ajax_request()) : ?>
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
		<article class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?=$this->router->class?>-<?=$this->router->method?>-0" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-user"></i> </span>
					<h2><?=@$module_detail->webmodules_title?> </h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
<?php else : ?>
					<div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					    <h4 class="modal-title">
					        <?=@$module_detail->webmodules_title?>
					    </h4>
					</div>
					<div class="modal-body no-padding">
<?php endif; ?>	
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'))?>
							<fieldset>
								<div id="messages" style="display: none;">
									<div class="alert"></div>
								</div>
								<legend>Main Module</legend>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$webmodules_class['label'].((isset($webmodules_class['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('webmodules_class'))) ? ' state-error' : ''?>">
											<?=form_input($webmodules_class,@$webmodules_class['value'],array('class'=>'','maxlength'=>'100','title'=>$webmodules_class['title'],'placeholder'=>$webmodules_class['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
											</label>
										<div class="note"></div>
									</section>
									<section class="col col-6">
										<label class="label strong"><?=$db_model['label'].((isset($db_model['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('db_model'))) ? ' state-error' : ''?>">
											<?=form_dropdown($db_model['name'],$db_model['data'], @$db_model['selected'], array('class'=>''))?><i></i>
										</label>
										<div class="note"></div>
									</section>							
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$webmodules_title['label'].((isset($webmodules_title['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('webmodules_title'))) ? ' state-error' : ''?>">
											<?=form_input($webmodules_title,@$webmodules_title['value'],array('class'=>'','maxlength'=>'50','title'=>$webmodules_title['title'],'placeholder'=>$webmodules_title['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>
									<section class="col col-6">
										<label class="label strong"><?=$webmodules_description['label'].((isset($webmodules_description['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('webmodules_description'))) ? ' state-error' : ''?>">
											<?=form_input($webmodules_description,@$webmodules_description['value'],array('class'=>'','maxlength'=>'100','title'=>$webmodules_description['title'],'placeholder'=>$webmodules_description['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
											</label>
										<div class="note"></div>
									</section>
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$webmodules_icon['label'].((isset($webmodules_icon['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('webmodules_icon'))) ? ' state-error' : ''?>">
											<?=form_input($webmodules_icon,@$webmodules_icon['value'],array('class'=>'','maxlength'=>'100','title'=>$webmodules_icon['title'],'placeholder'=>$webmodules_icon['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
											</label>
										<div class="note">Click <a href="http://192.241.236.31/themes/preview/smartadmin/1.8.x/ajax/index.html#ajax/fa.html" target="_blank"><small>here</small></a> for reference</div>
									</section>
									<section class="col col-6">
										<label class="label strong"><?=$editable['label'].((isset($editable['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('editable'))) ? ' state-error' : ''?>">
											<?=form_dropdown($editable['name'],$editable['data'], @$editable['selected'], array('class'=>''))?><i></i>
										</label>
										<div class="note"></div>
									</section>							
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="label strong"><?=$removeable['label'].((isset($removeable['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('removeable'))) ? ' state-error' : ''?>">
											<?=form_dropdown($removeable['name'],$removeable['data'], @$removeable['selected'], array('class'=>''))?><i></i>
										</label>
										<div class="note"></div>
									</section>							
									<section class="col col-6">
										<label class="label strong"><?=$need_login['label'].((isset($need_login['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('need_login'))) ? ' state-error' : ''?>">
											<?=form_dropdown($need_login['name'],$need_login['data'], @$need_login['selected'], array('class'=>''))?><i></i>
										</label>
										<div class="note"></div>
									</section>							
								</div>
								<div class="row">
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
														echo '<label class="checkbox"><input type="checkbox" name="'.$groups_access['name'].'" value="'.$idxV.'"><i></i>'.$row.'</label>';
													}
												}
												echo '</div>';
											}
										?>
										</div>
										<div class="note"></div>
									</section>
								</div>
							</fieldset>
					 		<fieldset id="webmodules_method">
								<section>
									<legend>Method / Function</legend>
								</section>


								<?php
									$fncs		= array('get','detail','get_detail','add','insert','edit','update','activate','deactivate','_change_status','delete','_delete','_form_input');
									$fncsTypes	= array('public','public','public','public','public','public','public','public','public','private','public','private','private');
									$createView	= array(FALSE,TRUE,FALSE,TRUE,FALSE,TRUE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE);

									foreach($fncs as $idxF => $fnc)
									{
										$webmodules_method_title['value']	= ltrim(ucwords(str_replace('_',' ',$fncs[$idxF])));
										$webmodules_method_title['id']		= 'webmodules_method_title-'.$idxF;
										$webmodules_method_title['name']	= 'webmodules_method_title['.$idxF.']';
										$webmodules_method['value']			= $fncs[$idxF];
										$webmodules_method['id']			= 'webmodules_method-'.$idxF;
										$webmodules_method['name']			= 'webmodules_method['.$idxF.']';
										$method_type['selected']			= $fncsTypes[$idxF];
										$method_type['name']				= 'method_type['.$idxF.']';
										$create_view['selected']			= $createView[$idxF];
										$create_view['name']				= 'create_view['.$idxF.']';
								?>
								<div class="row_method" id="method-<?=$idxF?>">
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
															echo '<label class="checkbox'.(($method_type['selected'] <> 'public') ? ' state-disabled' : '').'"><input type="checkbox" class="method_groups_access" name="'.$method_groups_access['name'].'" value="'.$idxV2.'"'.(($method_type['selected'] <> 'public') ? ' disabled' : '').'><i></i>'.$row2.'</label>';
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
												<a href="javascript:void(0);" class="btn btn-xs btn-danger remove-clone" rel="tooltip" data-placement="top" data-original-title="Remove Clone"><i class="fa fa-trash"></i></a>
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
										<section class="col col-3">
											<label class="label strong">&nbsp;</label>
											<div class="row">
												<label class="checkbox<?=(($method_type['selected'] <> 'public') ? ' state-disabled' : '')?>"><input type="checkbox" class="create_view" name="<?=$create_view['name']?>"<?=(($method_type['selected'] <> 'public') ? ' disabled' : (($create_view['selected'] == TRUE) ? ' checked' : ''))?>><i></i><?=$create_view['data']?></label>
											</div>
										</section>
									</div>
									<hr>
								</div>
								<?php
									}
								?>
							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary">
									<?=$this->lang->line('label_btn_submit')?>
								</button>
<?php if(!$this->input->is_ajax_request()) : ?>
								<button type="button" class="btn btn-default" onclick="window.history.back();">
									<?=$this->lang->line('label_btn_cancel')?>
								</button>
<?php else : ?>
								<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
									<?=$this->lang->line('label_btn_cancel')?>
								</button>
<?php endif; ?>	
							</footer>
						<?=form_close()?>
<?php if(!$this->input->is_ajax_request()) : ?>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>
<?php else : ?>
					</div>
<?php endif; ?>	

<?php if($this->input->is_ajax_request()) : ?>
<script>
	$(document).ready(function()
	{
		$("[rel=tooltip]").tooltip();

		var totalMethod			= 0;

		$('body').on('change', 'form#<?=$this->router->class?> select.method_type', function(e)
		{
			var $this 	= $(this);
			var $val	= $this.val();

			var $row_method = $this.closest('.row_method');
			var $checkbox = $row_method.find('.checkbox');

			if($val !== 'public')
			{
				$checkbox.find('input[type=checkbox]').prop('checked', false);
				$checkbox.addClass('state-disabled');
				$checkbox.find('input[type=checkbox]').prop('disabled',true);
			}
			else
			{
				$checkbox.removeClass('state-disabled');
				$checkbox.find('input[type=checkbox]').prop('disabled',false);
				$checkbox.find('input[type=checkbox]').removeAttr('onclick');
			}
		});

		$('body').on('keypress keyup blur', 'form#<?=$this->router->class?> input.webmodules_method', function(e)
		{
			var $current 		= $(this);
			var notesCurrent 	= $current.closest('section');
			var totDuplicated	= 0;

			$('form#<?=$this->router->class?> input.webmodules_method').each(function()
			{
				var notesThis 		= $(this).closest('section');

        		notesThis.find('.label').removeClass('state-error');
        		notesThis.find('.note').removeClass('note-danger').text('').hide();

				if ($(this).val() != '' && $current.val() != '' && $(this).val() == $current.val() && $(this).attr('id') != $current.attr('id'))
				{
	        		notesThis.find('label').addClass('state-error');
	        		notesThis.find('.note').addClass('note-danger').text('Duplicated method name').show();
					totDuplicated++;
				}
				else
				{
	        		notesThis.find('label').removeClass('state-error');
	        		notesThis.find('.note').removeClass('note-danger').text('').hide();
				}
			});

			if(totDuplicated == 0)
			{
				duplicatedMethod = false;
        		notesCurrent.find('label').removeClass('state-error');
        		notesCurrent.find('.note').removeClass('note-danger').text('').hide();
			}
			else
			{
				duplicatedMethod = true;
        		notesCurrent.find('label').addClass('state-error');
        		notesCurrent.find('.note').addClass('note-danger').text('Duplicated method name').show();
			}
		});

		$('body').on('keypress keyup', 'form#<?=$this->router->class?> input[name=<?=$webmodules_class['name']?>],form#<?=$this->router->class?> input.webmodules_method',function(e)
		{
			$(this).val($(this).val().toLowerCase().replace(/^[^a-z_]+/, '').replace(/ /g,"_").replace(/[^a-z0-9_]+/g,""));
		});

		$('body').on('blur', 'form#<?=$this->router->class?> input[name=<?=$webmodules_class['name']?>],form#<?=$this->router->class?> input.webmodules_method',function(e)
		{
			$(this).val($(this).val().toLowerCase().replace(/^[^a-z_]+|[^a-z0-9]+$/ig, ''));
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
				'		<section class="col col-3">'+
				'			<label class="label strong">&nbsp;</label>'+
				'			<div class="row">'+
				'				<label class="checkbox"><input type="checkbox" class="create_view" name="create_view[\'+totalMethod+\']"><i></i><?=$create_view['data']?></label>'+
				'			</div>'+
				'		</section>'+
				'	</div>'+
				'	<hr>'+
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
			method_container.next('hr').remove();
			method_container.remove();
			totalMethod--;

			$.each(container.find('.row_method'), function( key, row )
			{
				var row = $(container.find('.row_method')[key]);
				row.attr('id','method-'+key);
				row.find('input[type=text].webmodules_method_title').attr('name','webmodules_method_title['+key+']').attr('id','webmodules_method_title-'+key);
				row.find('input[type=text].webmodules_method').attr('name','webmodules_method['+key+']').attr('id','webmodules_method-'+key);
				row.find('input[type=checkbox].method_groups_access').attr('name','method_groups_access['+key+'][]');
				row.find('input[type=checkbox].create_view').attr('name','create_view['+key+']');
				row.find('select').attr('name','method_type['+key+']').attr('id','method_type-'+key);
			});
		});
	});
</script><?php endif; ?>	
