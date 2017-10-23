<?php defined('BASEPATH') OR exit('No direct script access allowed');

$allow_add 		= $this->custom_auth->is_allowed_to($this->router->class,'add');
$allow_detail 	= $this->custom_auth->is_allowed_to($this->router->class,'detail');
$allow_edit		= $this->custom_auth->is_allowed_to($this->router->class,'edit');
$allow_delete 	= $this->custom_auth->is_allowed_to($this->router->class,'delete');
$allow_reset 	= $this->custom_auth->is_allowed_to($this->router->class,'reset_password');
?>
<script type="text/javascript">
	$(document).ready(function()
	{
		pageSetUp();

		var dt_<?=$this->router->class?> = '';

		var responsiveHelper_dt_<?=$this->router->class?> = undefined;

		var breakpointDefinition =
		{
			tablet : 1024,
			phone : 480
		};

		dt_<?=$this->router->class?> = $('#dt_<?=$this->router->class?>').dataTable(
		{
	        "processing": true,
	        "serverSide": true,
	        "ajax": "<?=links_url(array('class'=>$this->router->class,'method'=>'get'))?>?format=datatables",
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
				if (!responsiveHelper_dt_<?=$this->router->class?>)
				{
					responsiveHelper_dt_<?=$this->router->class?> = new ResponsiveDatatablesHelper($('#dt_<?=$this->router->class?>'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow)
			{
				responsiveHelper_dt_<?=$this->router->class?>.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings)
			{
				$("[rel=tooltip]").tooltip();
				responsiveHelper_dt_<?=$this->router->class?>.respond();
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
			    {
			        "data": 'users_first_name',
			        "searchable": true,
			        "orderable": true,
			        "targets": 1,
			    },
			    {
			        "data": 'users_last_name',
			        "searchable": true,
			        "orderable": true,
			        "targets": 2,
			    },
			    {
			        "data": 'users_email',
			        "searchable": true,
			        "orderable": true,
			        "targets": 3,
			    },
			    {
			        "data": 'groups',
			        "searchable": true,
			        "orderable": false,
			        "targets": 4,
					"render": function (data, type, full, meta)
					{
						var html = '';
						$.each(full.groups, function( key, row )
						{
							html += row.groups_description+'<br>';
						});
						return html;
					}
			    },
			    {
			        "data": 'users_last_login',
			        "searchable": false,
			        "orderable": true,
			        "targets": 5,
			        "className": "dt-body-center",
					"render": function (data, type, full, meta)
					{
						if(data != null)
						{
							var now	= new Date(data*1000);
							return jQuery.format.prettyDate(now);
						}
						return '-';
					}
			    },
			    {
			        "data": 'status',
			        "searchable": true,
			        "orderable": true,
			        "targets": 6,
			        "className": "dt-body-center",
					"render": function (data, type, full, meta)
		            {
		            	var html = '';
						switch(data)
						{
						    case '0'	: 	html = '<span class="label label-primary">Registered</span>';	break;
						    case '1'	: 	html = '<span class="label label-success">Verified</span>';		break;
						    case '2'	: 	html = '<span class="label label-default">Archived</span>';		break;
						    case '3'	: 	html = '<span class="label label-warning">Blocked</span>';		break;
						    case '10'	: 	html = '<span class="label label-danger">Deleted</span>';		break;
						    default 	: 	html = '<span class="label label-primary">Registered</span>';	break;
						}
						return html;
		            }
			    },
				<?php if($allow_detail || $allow_edit || $allow_delete || $allow_reset) : ?>
			    {
			        "searchable": false,
			        "orderable": false,
			        "targets": 7,
			        "className": "dt-body-center",
					"render": function (data, type, full, meta)
		            {
		            	var html = '';
		            	<?php if($allow_detail) : ?>
		            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-success action-detail" data-id="'+full.users_id+'" data-action="detail" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="fa fa-eye"></i></a>&nbsp;';
		            	<?php endif; ?>
		            	if(full.users_id != <?=$this->session->userdata('users_id')?>)
		            	{
			            	<?php if($allow_edit) : ?>
			            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-primary action-edit" data-id="'+full.users_id+'" data-action="edit" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;';
			            	<?php endif; if($allow_reset) : ?>
			            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-warning action-reset" data-id="'+full.users_id+'" data-action="reset" rel="tooltip" data-placement="top" data-original-title="Reset Password"><i class="fa fa-refresh"></i></a>&nbsp;';
			            	<?php endif; if($allow_delete) : ?>
			            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-danger action-delete" data-id="'+full.users_id+'" data-action="delete" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></a>';
			            	<?php endif; ?>
		            	}

						return html;
		            }
			    },
				<?php endif; ?>
			]
		});

		<?php if($allow_add && $this->config->item('form_in_ajax_modal') == TRUE) : ?>
		$('body').on('submit','#modal-<?=$this->router->class?> form#<?=$this->router->class?>', function (e)
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
						$('#dt_<?=$this->router->class?>').DataTable().ajax.reload(null, false);

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
			e.preventDefault();
		})
		<?php endif; ?>

		<?php
			if($allow_edit) 	$actionClass[] = 'a.action-edit';
			if($allow_reset) 	$actionClass[] = 'a.action-reset';
			if($allow_delete) 	$actionClass[] = 'a.action-delete';
			if($allow_detail) 	$actionClass[] = 'a.action-detail';

			if($allow_detail || $allow_edit || $allow_reset || $allow_delete) :
		?>

		$('body').on('click','<?=((isset($actionClass)) ? implode(',',$actionClass) : '')?>', function (e)
		{
			var $this 		= $(this);
			var id 			= $(this).data('id');
			var action 		= $(this).data('action');
			var formData	= {'id':id};
			var	URL 		= '';
			var	formMethod 	= 'post';

			switch(action)
			{
				<?php if($allow_edit)	: ?>
				case 'edit' 		: 	URL = '<?=links_url(array('class'=>$this->router->class,'method'=>'edit'))?>/'+id; 	formMethod 	= 'get'; 	break;
				case 'activate' 	: 	URL	= '<?=links_url(array('class'=>$this->router->class,'method'=>'activate'))?>';						break;
				case 'deactivate' 	: 	URL	= '<?=links_url(array('class'=>$this->router->class,'method'=>'deactivate'))?>';					break;
				<?php endif; ?>
				<?php if($allow_detail)	: ?>
				case 'detail' 		: 	URL = '<?=links_url(array('class'=>$this->router->class,'method'=>'detail'))?>/'+id; 	formMethod 	= 'get'; 	break;
				<?php endif; ?>
				<?php if($allow_delete)	: ?>
				case 'delete' 		: 	URL	= '<?=links_url(array('class'=>$this->router->class,'method'=>'delete'))?>';						break;
				<?php endif; ?>
				<?php if($allow_reset)	: ?>
				case 'reset' 		: 	URL	= '<?=links_url(array('class'=>$this->router->class,'method'=>'reset_password'))?>';				break;
				<?php endif; ?>
			}

			if(action == 'detail')
			{
				var modalElement	= $this.closest('div#content').find('.modal');
				$.get( URL, function( data ) {
					modalElement.modal('show');
					modalElement.find('.modal-content').html(data);
				});
			}
			else
			{
				$.SmartMessageBox(
				{
					title : '<span class="txt-color-orangeDark"><strong>Warning!</strong></span>',
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
								$('#dt_<?=$this->router->class?>').DataTable().ajax.reload(null, false);
							})
							.always(function(responseText)
							{
								var htmlData	= (responseText.message != undefined) ? responseText.message : responseText.responseJSON.message;
								var html = 	'<div class="alert alert-block alert-'+htmlData.class+'">'+
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
							var modalElement	= $this.closest('div#content').find('.modal');
							$.get( URL, function( data ) {
								modalElement.modal('show');
								modalElement.find('.modal-content').html(data);
							});
						}
					}
				});				
			}
			e.preventDefault();
		})
		<?php endif; ?>
	});

</script>
