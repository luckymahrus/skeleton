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
	
	<?php if($allow_add) : ?>
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		<?php if($this->config->item('form_in_ajax_modal') == FALSE) : ?>
		<a href="<?=links_url(array('class'=>$this->router->class,'method'=>'add'))?>" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-plus fa-lg"></i>&emsp;<?=$this->lang->line('label_btn_add_document')?></a>
		<?php else : ?>
		<a href="<?=links_url(array('class'=>$this->router->class,'method'=>'add'))?>" data-toggle="modal" data-target="#modal-<?=$this->router->class?>" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-plus fa-lg"></i>&emsp;<?=$this->lang->line('label_btn_add_document')?></a>
		<?php endif; ?>
	</div>
	<?php endif; ?>
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
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2><?=@$module_detail->webmodules_title?> </h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
						<table id="dt_<?=$this->router->class?>" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th data-hide="phone"></th>
									<th data-class="expand"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> <?=$this->lang->line('table_column_uploads_name')?></th>
									<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> <?=$this->lang->line('table_column_uploads_description')?></th>
									<th><i class="fa fa-fw fa-envelope text-muted hidden-md hidden-sm hidden-xs"></i> <?=$this->lang->line('table_column_uploads_client_name')?></th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-key text-muted hidden-md hidden-sm hidden-xs"></i> <?=$this->lang->line('table_column_uploads_file_ext')?></th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-clock-o text-muted hidden-md hidden-sm hidden-xs"></i> <?=$this->lang->line('table_column_uploads_file_size')?></th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-tags text-muted hidden-md hidden-sm hidden-xs"></i> <?=$this->lang->line('table_column_status')?></th>
									<?php if($allow_detail || $allow_edit || $allow_delete || $allow_reset) : ?>
									<th data-hide="phone,tablet"><?=$this->lang->line('table_column_action')?></th>
									<?php endif; ?>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>

<?php if($allow_add && $this->config->item('form_in_ajax_modal') == TRUE) : ?>
<div class="modal fade" id="modal-<?=$this->router->class?>" tabindex="-1" role="dialog" aria-labelledby="modal-<?=$this->router->class?>Label" aria-hidden="true">  
    <div class="modal-dialog">  
        <div class="modal-content">
        </div>  
    </div>  
</div>
<?php endif; ?>
