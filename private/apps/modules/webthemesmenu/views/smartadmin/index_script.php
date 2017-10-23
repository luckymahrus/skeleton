<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
	$(document).ready(function()
	{
		pageSetUp();

		var responsiveHelper_dt_basic = undefined;

		var breakpointDefinition =
		{
			tablet : 1024,
			phone : 480
		};

		var dt_tables = $('#dt_basic').dataTable(
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
				if (!responsiveHelper_dt_basic)
				{
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow)
			{
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings)
			{
				$("[rel=tooltip]").tooltip();
				responsiveHelper_dt_basic.respond();
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
			        "data": 'webthemes_name',
			        "searchable": true,
			        "orderable": true,
			        "targets": 1,
			    },
			    {
			        "data": 'webthemes_title',
			        "searchable": true,
			        "orderable": true,
			        "targets": 2,
			    },
			    {
			        "data": 'webthemesmenu_name',
			        "searchable": true,
			        "orderable": true,
			        "targets": 3,
			    },
			    {
			        "data": 'webthemesmenu_title',
			        "searchable": true,
			        "orderable": true,
			        "targets": 4,
			    },
			    {
			        "data": 'status',
			        "searchable": true,
			        "orderable": true,
			        "targets": 5,
			        "className": "dt-body-center",
					"render": function (data, type, full, meta)
		            {
		            	var html = '';
						switch(data)
						{
						    case '0'	: 	html = '<span class="label label-default">Inactive</span>';	break;
						    case '1'	: 	html = '<span class="label label-success">Active</span>';	break;
						    default 	: 	html = '<span class="label label-default">Inactive</span>';	break;
						}
						return html;
		            }
			    },
				<?php if($allow_detail || $allow_edit || $allow_delete) : ?>
			    {
			        "searchable": false,
			        "orderable": false,
			        "targets": 6,
			        "className": "dt-body-center",
					"render": function (data, type, full, meta)
		            {
		            	var html = '';
		            	<?php if($allow_detail) : ?>
		            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-success action-detail" data-id="'+full.webthemesmenu_id+'" data-webthemesid="'+full.webthemes_id+'" data-action="detail" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="fa fa-eye"></i></a>&nbsp;';
		            	<?php endif; if($allow_edit) : ?>
		            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-primary action-edit" data-id="'+full.webthemesmenu_id+'" data-webthemesid="'+full.webthemes_id+'" data-action="edit" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;';
		            	<?php endif; if($allow_delete) : ?>
		            	if(full.status != 1)
		            	{
			            	html += '<a href="javascript:void(0);" class="btn btn-xs btn-danger action-delete" data-id="'+full.webthemesmenu_id+'" data-webthemesid="'+full.webthemes_id+'" data-action="delete" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></a>';
		            	}
		            	<?php endif; ?>

						return html;
		            }
			    },
				<?php endif; ?>
			]
		});

		$('body').on('click','a.action-edit,a.action-reset,a.action-delete', function (e)
		{
			var id 		= $(this).data('id');
			var action 	= $(this).data('action');
			var data 	= {'id':id};

			$.SmartMessageBox(
			{
				title : '<span class="txt-color-orangeDark"><strong>Warning!</strong></span>',
				content : 'You are going to <span class="txt-color-orangeDark"><strong>'+action+'</strong></span> this data. Are you sure?',
				buttons : '[No][Yes]'
			}, function(ButtonPressed)
			{
				if (ButtonPressed === "Yes")
				{
					switch(action)
					{
						case 'edit' 		: window.location.href = "<?=links_url(array('class'=>$this->router->class,'method'=>'edit'))?>/"+id;	break;
						case 'delete' 		: $.redirect('<?=links_url(array('class'=>$this->router->class,'method'=>'delete'))?>',data);			break;
						case 'activate' 	: $.redirect('<?=links_url(array('class'=>$this->router->class,'method'=>'activate'))?>',data);			break;
						case 'deactivate' 	: $.redirect('<?=links_url(array('class'=>$this->router->class,'method'=>'deactivate'))?>',data);		break;
					}
				}
			});
			e.preventDefault();
		})
	})
</script>
