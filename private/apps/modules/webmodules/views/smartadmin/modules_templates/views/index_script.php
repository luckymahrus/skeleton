

<?php echo '<?php
$allow_add 		= $this->custom_auth->is_allowed_to($this->router->class,\'add\');
$allow_detail 	= $this->custom_auth->is_allowed_to($this->router->class,\'detail\');
$allow_edit		= $this->custom_auth->is_allowed_to($this->router->class,\'edit\');
$allow_delete 	= $this->custom_auth->is_allowed_to($this->router->class,\'delete\');

$allow_method = $this->custom_auth->is_allowed_to(\'webmodules_method\',\'index\');
?>
'; ?>
<script type="text/javascript">
	$(document).ready(function()
	{
		pageSetUp();

		var duplicatedMethod	= false;

		var dt_<?php echo '<?=$this->router->class?>'; ?> = '';

		var responsiveHelper_dt_<?php echo '<?=$this->router->class?>'; ?> = undefined;

		var breakpointDefinition =
		{
			tablet : 1024,
			phone : 480
		};

		dt_<?php echo '<?=$this->router->class?>'; ?> = $('#dt_<?php echo '<?=$this->router->class?>'; ?>').dataTable(
		{
	        "processing": true,
	        "serverSide": true,
	        "ajax": "<?php echo '<?=links_url(array(\'class\'=>$this->router->class,\'method\'=>\'get\'))?>'; ?>?format=datatables",
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'fr><'col-sm-6 col-xs-12 hidden-xs'l>>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
	        "oLanguage":
	        {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sLengthMenu": '_MENU_',
                "sInfoPostFix": '',
                "sLoadingRecords": 'Loading...',
                "sProcessing": 'Processing...',
                "sInfoDecimal": ',',
                "sInfoThousands": '.',
                "sEmptyTable": "No data available in table",
                "sInfo": 'Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong> entries',
                "sInfoEmpty": 'Showing 0 to 0 of 0 entries',
                "sInfoFiltered": '(filtered from <strong>_MAX_</strong> total entries)',
                "sZeroRecords": 'No matching records found',
                "oPaginate":
                {
                    "sFirst": '<i class="fa fa-fast-backward"></i>',
                    "sLast": '<i class="fa fa-fast-forward"></i>',
                    "sNext": '<i class="fa fa-step-forward"></i>',
                    "sPrevious": '<i class="fa fa-step-backward"></i>'
                },
                "oAria":
                {
                    "sSortAscending":  ': activate to sort column ascending',
                    "sSortDescending": ': activate to sort column descending'
				}
			    //"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
			},
			"preDrawCallback" : function()
			{
				if (!responsiveHelper_dt_<?php echo '<?=$this->router->class?>'; ?>)
				{
					responsiveHelper_dt_<?php echo '<?=$this->router->class?>'; ?> = new ResponsiveDatatablesHelper($('#dt_<?php echo '<?=$this->router->class?>'; ?>'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow)
			{
				responsiveHelper_dt_<?php echo '<?=$this->router->class?>'; ?>.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings)
			{
				$("[rel=tooltip]").tooltip();
				responsiveHelper_dt_<?php echo '<?=$this->router->class?>'; ?>.respond();
			},
			"columnDefs":
			[
			    {
			        "searchable": false,
			        "orderable": false,
			        "targets": 0,
			        "className": "dt-body-center",
					"render": function (data, type, full, meta)
					{
						return meta.settings._iDisplayStart+meta.row+1;
					}
			    },
<?php
if($table_fields && count($table_fields) > 0)
{
	$cols = 1;
	foreach ($table_fields as $idxTF => $field)
	{
		if($field->name <> $table_pkey && $field->name <> '_created_by' && $field->name <> '_updated_by' && $field->name <> '_created_at' && $field->name <> '_updated_at' && $field->name <> 'is_deleted')
		{
			if($field->name <> 'status')
			{

echo '			    {
			        "data": \''.$field->name.'\',
			        "searchable": true,
			        "orderable": true,
			        "targets": '.$cols.',
			    },
';
			}
			else
			{
echo '			    {
			        "data": \''.$field->name.'\',
			        "searchable": true,
			        "orderable": true,
			        "targets": '.$cols.',
			        "className": "dt-body-center",
					"render": function (data, type, full, meta)
		            {
		            	var html = \'\';
						switch(data)
						{
						    case \'0\'	: 	html = \'<span class="label label-default">Inactive</span>\';	break;
						    case \'1\'	: 	html = \'<span class="label label-success">Active</span>\';	break;
						    default 	: 	html = \'<span class="label label-default">Inactive</span>\';	break;
						}
						return html;
		            }
			    },
';
			}
			$cols++;
		}
	}
}
?>
				<?php echo '<?php if($allow_detail || $allow_edit || $allow_delete) : ?>
'; ?>
			    {
			        "searchable": false,
			        "orderable": false,
			        "targets": <?=$cols?>,
			        "className": "dt-body-center",
					"render": function (data, type, full, meta)
		            {
		            	var html = '';
		            	<?php echo '<?php if($allow_detail) : ?>
'; ?>
		            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-success action-detail" data-id="'+full.<?=$table_pkey?>+'" data-action="detail" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="fa fa-eye"></i></a>&nbsp;';
		            	<?php echo '<?php endif; if($allow_edit) : ?>
'; ?>
		            	<?php echo '<?php if($this->ion_auth->is_superuser()) : ?>
'; ?>
	            		html += '<a href="javascript:void(0);" class="btn btn-xs btn-primary action-edit" data-id="'+full.<?=$table_pkey?>+'" data-action="edit" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;';
		            	<?php echo '<?php else : ?>
'; ?>
		            	if(full.editable == true || full.editable)
		            	{
		            		html += '<a href="javascript:void(0);" class="btn btn-xs btn-primary action-edit" data-id="'+full.<?=$table_pkey?>+'" data-action="edit" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;';
		            	}
		            	<?php echo '<?php endif; ?>
'; ?>
		            	<?php echo '<?php endif; if($allow_delete) : ?>
'; ?>
		            	<?php echo '<?php if($this->ion_auth->is_superuser()) : ?>
'; ?>
		            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-danger action-delete" data-id="'+full.<?=$table_pkey?>+'" data-action="delete" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></a>';
		            	<?php echo '<?php else : ?>
'; ?>
		            	if(full.removeable == true || full.removeable)
		            	{
			            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-danger action-delete" data-id="'+full.<?=$table_pkey?>+'" data-action="delete" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></a>';
		            	}
		            	<?php echo '<?php endif; ?>
'; ?>
		            	<?php echo '<?php endif; ?>
'; ?>

						return html;
		            }
			    },
				<?php echo '<?php endif; ?>
'; ?>
			]
		});

		<?php echo '<?php if($allow_add && $this->config->item(\'form_in_ajax_modal\') == TRUE) : ?>
'; ?>
		$('body').on('submit','#modal-<?php echo '<?=$this->router->class?>'; ?> form#<?php echo '<?=$this->router->class?>'; ?>', function (e)
		{
			if(duplicatedMethod == false)
			{
				var $this 			= $(this);
		        var URL 			= $this.attr("action");
		        var formMethod 		= $this.attr("method");
			    var formData 		= new FormData($this[0]);
	    		var $formElement	= $this.find('input,select');

				$.SmartMessageBox(
				{
					title : '<span class="txt-color-orangeDark"><strong>Warning!</strong></span>',
					content : 'You are going to <span class="txt-color-orangeDark"><strong>save</strong></span> this data. Are you sure?',
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
							var messageContainer 	= $this.find('#messages');
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
							$('#dt_<?php echo '<?=$this->router->class?>'; ?>').DataTable().ajax.reload(null, false);

							var html = 	'<div class="alert alert-block alert-'+data.message.class+'">'+
										'<a class="close" data-dismiss="alert" href="#">×</a>'+
										'<h4 class="alert-heading"><i class="fa fa-'+data.message.icon+'"></i> '+data.message.status+'!</h4>'+
										'<p>'+data.message.text+'</p>'+
										'</div>';
							$('body').find('section#widget-grid').prepend(html);
							setTimeout(function() { $('.alert.alert-block').remove(); }, 2000);

							$( '.modal' ).modal( 'hide' ).data( 'bs.modal', null );
	        			})
	        			.complete(function( jqXHR, textStatus )
	        			{
							$this.find('button').prop('disabled', false);
	        			});
					}
				});
			}
			e.preventDefault();
		})
		//state-disabled

		$('body').on('change', 'form#<?php echo '<?=$this->router->class?>'; ?> select.method_type', function(e)
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


		$('body').on('keypress keyup blur', 'form#<?php echo '<?=$this->router->class?>'; ?> input.webmodules_method', function(e)
		{
			var $current 		= $(this);
			var notesCurrent 	= $current.closest('section');
			var totDuplicated	= 0;

			$('form#<?php echo '<?=$this->router->class?>'; ?> input.webmodules_method').each(function()
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
		<?php echo '<?php endif; ?>
'; ?>

		<?php echo '<?php
			if($allow_edit) 	$actionClass[] = \'#dt_\'.$this->router->class.\' a.action-edit\';
			if($allow_delete) 	$actionClass[] = \'#dt_\'.$this->router->class.\' a.action-delete\';
			if($allow_detail) 	$actionClass[] = \'#dt_\'.$this->router->class.\' a.action-detail\';

			if($allow_detail || $allow_edit || $allow_delete) :
		?>
'; ?>

		$('body').on('click','<?php echo '<?=((isset($actionClass)) ? implode(\',\',$actionClass) : \'\')?>'; ?>', function (e)
		{
			var $this 		= $(this);
			var id 			= $(this).data('id');
			var action 		= $(this).data('action');
			var formData	= {'id':id};
			var	URL 		= '';
			var	formMethod 	= 'post';

			switch(action)
			{
				<?php echo '<?php if($allow_edit)	: ?>
'; ?>
				case 'edit' 		: 	URL = '<?php echo '<?=links_url(array(\'class\'=>$this->router->class,\'method\'=>\'edit\'))?>';?>/'+id; 		formMethod 	= 'get'; 	break;
				case 'activate' 	: 	URL	= '<?php echo '<?=links_url(array(\'class\'=>$this->router->class,\'method\'=>\'activate\'))?>';?>';						break;
				case 'deactivate' 	: 	URL	= '<?php echo '<?=links_url(array(\'class\'=>$this->router->class,\'method\'=>\'deactivate\'))?>';?>';					break;
				<?php echo '<?php endif; ?>
'; ?>
				<?php echo '<?php if($allow_detail)	: ?>
'; ?>
				case 'detail' 		: 	URL = '<?php echo '<?=links_url(array(\'class\'=>$this->router->class,\'method\'=>\'detail\'))?>';?>/'+id; 	formMethod 	= 'get'; 	break;
				<?php echo '<?php endif; ?>
'; ?>
				<?php echo '<?php if($allow_delete)	: ?>
'; ?>
				case 'delete' 		: 	URL	= '<?php echo '<?=links_url(array(\'class\'=>$this->router->class,\'method\'=>\'delete\'))?>';?>';						break;
				<?php echo '<?php endif; ?>
'; ?>
			}

			if(action == 'detail')
			{
				var modalElement	= $this.closest('div#content').find('#modal-<?php echo '<?=$this->router->class?>'; ?>');
				$.get( URL, function( data )
				{
					modalElement.modal(
					{
                        cache	: false,
                        backdrop: 'static',
                        keyboard: false
                    }, "show");
					modalElement.find('.modal-content').html(data);
				});
			}
			else
			{
				$.SmartMessageBox(
				{
					title 	: '<span class="txt-color-orangeDark"><strong>Warning!</strong></span>',
					content : 'You are going to <span class="txt-color-orangeDark"><strong>'+action+'</strong></span> this data. Are you sure?',
					buttons : '[No][Yes]'
				}, function(ButtonPressed)
				{
					if (ButtonPressed === "Yes")
					{
						if(action != 'edit')
						{
							$.post(URL,formData,function(response,status)
							{
								$('#dt_<?php echo '<?=$this->router->class?>'; ?>').DataTable().ajax.reload(null, false);
							})
							.always(function(responseText)
							{
								var htmlData	= (responseText.message != undefined) ? responseText.message : responseText.responseJSON.message;
								var html 		= '<div class="alert alert-block alert-'+htmlData.class+'">'+
												  '<a class="close" data-dismiss="alert" href="#">×</a>'+
												  '<h4 class="alert-heading"><i class="fa fa-'+htmlData.icon+'"></i> '+htmlData.status+'!</h4>'+
												  '<p>'+htmlData.text+'</p>'+
												  '</div>';
								$this.closest('section#widget-grid').prepend(html);
								setTimeout(function() { $('.alert.alert-block').remove(); }, 2000);
							});
						}
						else
						{
							var modalElement	= $this.closest('div#content').find('#modal-<?php echo '<?=$this->router->class?>'; ?>');
							$.get( URL, function( data )
							{
								modalElement.modal(
								{
			                        cache	: false,
			                        backdrop: 'static',
			                        keyboard: false
			                    }, "show");
								modalElement.find('.modal-content').html(data);
							});
						}
					}
				});				
			}
			e.preventDefault();
		})
		<?php echo '<?php endif; ?>
'; ?>

		<?php echo '<?php if($this->config->item(\'form_in_ajax_modal\') && ($allow_add || $allow_edit)) : ?>
'; ?>

		<?php echo '<?php endif; ?>
'; ?>
	});

</script>
