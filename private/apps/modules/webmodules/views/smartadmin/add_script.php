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

		$('body').on('click','form#<?=$this->router->class?> fieldset#webmodules_method div.row_method a.add-clone', function (e)
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

		$('body').on('click','form#<?=$this->router->class?> fieldset#webmodules_method div.row_method a.remove-clone', function (e)
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
				row.find('input[type=checkbox]').attr('name','method_groups_access['+key+'][]');
				row.find('select').attr('name','method_type['+key+']').attr('id','method_type-'+key);
			});
		});
	});
</script>