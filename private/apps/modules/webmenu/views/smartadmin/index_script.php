<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
	$(document).ready(function()
	{
		pageSetUp();

		var updateOutput = function(e)
		{
			var list = e.length ? e : $(e.target), output = list.data('output');
			if (window.JSON)
			{
				output.val(window.JSON.stringify(list.nestable('serialize')));
				//, null, 2));
			}
			else
			{
				output.val('JSON browser support required for this demo.');
			}
		};

		$('#nestable').nestable({
			group : 1,maxDepth: 3
		});

		$('#nestable').nestable({
			group : 1,maxDepth: 3
		}).on('change', updateOutput);

	    updateOutput($('#nestable').data('output', $('#nestable-output')));

		$('body').on('click','a.addToMenu',function(e)
		{
			var $this 		= $(this);
			var mid 		= $(this).data('mid');
			var gid 		= $(this).data('gid');
			var tid 		= $(this).data('tid');
			var formData	= {'mid':mid,'gid':gid,'tid':tid};

			$.SmartMessageBox(
			{
				title 	: '<span class="txt-color-orangeDark"><strong>Warning!</strong></span>',
				content : 'You are going to <span class="txt-color-orangeDark"><strong>add</strong></span> this module to web menu. Are you sure?',
				buttons : '[No][Yes]'
			}, function(ButtonPressed)
			{
				if (ButtonPressed === "Yes")
				{
					$.post('<?=links_url(array('class'=>$this->router->class,'method'=>'add'))?>',formData,function(response,status)
					{
						var menuData = response.message.data;
						console.log(menuData);

						var newMenuHtml = '<li class="dd-item dd3-item" data-id="'+menuData.webmenu_id+'">'+
						'	<div class="dd-handle dd3-handle">Drag</div>'+
						'	<div class="dd3-content">'+
						'		<div class="panel-group smart-accordion-default" id="accordion-'+menuData.webmenu_id+'">'+
						'			<div class="panel panel-default">'+
						'				<div class="panel-heading">'+
						'					<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-'+menuData.webmenu_id+'" href="#collapseOne-'+menuData.webmenu_id+'" aria-expanded="false" class="collapsed"><i class="'+((menuData.webmenu_icon == null || menuData.webmenu_icon == undefined) ? '' : menuData.webmenu_icon)+'"></i> '+menuData.webmenu_title+' </a></h4>'+
						'				</div>'+
						'				<div id="collapseOne-'+menuData.webmenu_id+'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">'+
						'					<div class="panel-body">'+
						'						<form action="<?=links_url(array('class'=>$this->router->class,'method'=>'edit'))?>" id="webmenu-edit-'+menuData.webmenu_id+'" name="webmenu-edit-selected" class="smart-form edit-selected" enctype="multipart/form-data" method="post" accept-charset="utf-8">'+
						'							<input type="hidden" name="id" value="'+menuData.webmenu_id+'">'+
						'							<div id="messages" style="display: none;">'+
						'							<div class="alert"></div>'+
						'							</div>'+
						'							<fieldset>'+
						'								<section>'+
						'									<label class="label strong"><?=$this->lang->line('label_input_webmenu_title')?></label>'+
						'									<label class="input">'+
						'										<input type="text" name="webmenu_title" value="'+menuData.webmenu_title+'" class="input-sm" id="webmenu_title-'+menuData.webmenu_id+'" label="<?=$this->lang->line('label_input_webmenu_title')?>" placeholder="<?=$this->lang->line('placeholder_input_webmenu_title')?>" title="<?=$this->lang->line('title_input_webmenu_title')?>">'+
						'									</label>'+
						'									<div class="note"></div>'+
						'								</section>'+
						'								<section>'+
						'									<label class="label strong"><?=$this->lang->line('label_input_webmenu_icon')?></label>'+
						'									<label class="input">'+
						'										<input type="text" name="webmenu_icon" value="'+((menuData.webmenu_icon == null || menuData.webmenu_icon == undefined) ? '' : menuData.webmenu_icon)+'" class="input-sm" id="webmenu_icon-'+menuData.webmenu_id+'" label="<?=$this->lang->line('label_input_webmenu_icon')?>" placeholder="<?=$this->lang->line('placeholder_input_webmenu_icon')?>" title="<?=$this->lang->line('title_input_webmenu_icon')?>">'+
						'									</label>'+
						'									<div class="note">Click <a href="http://192.241.236.31/themes/preview/smartadmin/1.8.x/ajax/index.html#ajax/fa.html" target="_blank"><small>here</small></a> for reference</div>'+
						'								</section>'+
						'							</fieldset>'+
						'							<footer>'+
						'								<button type="submit" class="btn btn-primary"><?=$this->lang->line('label_btn_update')?></button>'+
						'								<button type="button" class="btn btn-danger delete" data-id="'+menuData.webmenu_id+'"><?=$this->lang->line('label_btn_delete')?></button>'+
						'							</footer>'+
						'						</form>'+
						'					</div>'+
						'				</div>'+
						'			</div>'+
						'		</div>'+
						'	</div>'+
						'</li>';

						$('#nestable #nestable-main').append(newMenuHtml);
					})
					.always(function(responseText)
					{
						$('#nestable').nestable({
							group : 1,maxDepth: 3
						}).on('change', updateOutput);

						updateOutput($('#nestable').data('output', $('#nestable-output')));
					});
				}
			});				
		});

		$('body').on('submit','form.edit-selected',function(e)
		{
			$('#nestable').nestable({
				group : 1,maxDepth: 3
			}).on('change', updateOutput);

			updateOutput($('#nestable').data('output', $('#nestable-output')));

			var $this 				= $(this);
	        var URL 				= $this.attr("action");
	        var formMethod 			= $this.attr("method");
		    var formData 			= new FormData($this[0]);
    		var $formElement		= $this.find('input,select');
			var messageContainer 	= $this.find('#messages');

			$.SmartMessageBox(
			{
				title 	: '<span class="txt-color-orangeDark"><strong>Warning!</strong></span>',
				content : 'You are going to <span class="txt-color-orangeDark"><strong>update</strong></span> this menu. Are you sure?',
				buttons : '[No][Yes]'
			}, function(ButtonPressed)
			{
				if (ButtonPressed === "Yes")
				{
					$this.find('button').prop('disabled', true);

				    $.ajax({
				        url: URL,
				        type: formMethod,
				        data: formData,
				        async: false,
				        cache: false,
				        contentType: false,
				        processData: false
					})
					.fail(function(jqXHR, textStatus, errorThrown)
					{
						var messageObj 			= jqXHR.responseJSON.message;
						var errorField 			= messageObj.data;

						messageContainer.find('.alert').html(messageObj.text).addClass('alert-'+messageObj.class);
						messageContainer.show();

						$formElement.each(function()
						{
							var fieldName 	= $(this).attr('name');
							var fieldLabel 	= $(this).closest('label.input');
							var fieldNotes 	= $(this).closest('section').find('div.note');

			        		fieldLabel.removeClass('state-error state-success');
			        		fieldNotes.removeClass('note-danger note-success');
			        		fieldLabel.find('.form-control-feedback').removeClass('glyphicon-remove txt-color-red glyphicon-ok txt-color-green').hide();

							if(errorField[fieldName] != undefined)
							{
				        		fieldLabel.addClass('state-error');
				        		fieldNotes.addClass('note-danger').text(errorField[fieldName]).show();
			        			fieldLabel.find('.form-control-feedback').addClass('glyphicon-remove txt-color-red').show();
							}
							else
							{
				        		fieldLabel.addClass('state-success');
			        			fieldLabel.find('.form-control-feedback').addClass('glyphicon-ok txt-color-green').show();
							}
						});
					})
			        .success(function(data, textStatus, jqXHR)
			        {
						var messageObj 			= data.message;
						messageContainer.find('.alert').html(messageObj.text).addClass('alert-'+messageObj.class);
						messageContainer.show();
						setTimeout(function() { $('.alert').hide(); }, 2000);

						console.log($this.closest('div.panel').find('.panel-title a'));

						$this.closest('div.panel').find('.panel-title a').html('<i class="'+$this.find('input[name=webmenu_icon]').val()+'"></i> '+$this.find('input[name=webmenu_title]').val());
        			})
        			.complete(function( jqXHR, textStatus )
        			{
						$this.find('button').prop('disabled', false);
        			});

					$('#nestable').nestable({
						group : 1,maxDepth: 3
					}).on('change', updateOutput);

	    			updateOutput($('#nestable').data('output', $('#nestable-output')));
				}
			});				
			e.preventDefault();
		});

		$('body').on('click','form.edit-selected button.delete',function(e)
		{
			$('#nestable').nestable({
				group : 1,maxDepth: 3
			}).on('change', updateOutput);

			updateOutput($('#nestable').data('output', $('#nestable-output')));

			var $this 		= $(this);
			var id 			= $(this).data('id');

			$.SmartMessageBox(
			{
				title 	: '<span class="txt-color-orangeDark"><strong>Warning!</strong></span>',
				content : 'You are going to <span class="txt-color-orangeDark"><strong>remove</strong></span> this menu and all its child. Are you sure?',
				buttons : '[No][Yes]'
			}, function(ButtonPressed)
			{
				if (ButtonPressed === "Yes")
				{
					var mainContainer	= $this.closest('li.dd-item');
					$('#<?=$this->router->class?>-edit-all').append('<input type="hidden" name="remove_id[]" value="'+id+'">');

					var childMenu = mainContainer.find('ol.dd-list li.dd-item');

					$.each(childMenu, function( key, row )
					{
						$('#<?=$this->router->class?>-edit-all').append('<input type="hidden" name="remove_id[]" value="'+$(row).data('id')+'">');
					});

					mainContainer.remove();

					$('#nestable').nestable({
						group : 1,maxDepth: 3
					}).on('change', updateOutput);

	    			updateOutput($('#nestable').data('output', $('#nestable-output')));
				}
			});				
		});
	});
</script>