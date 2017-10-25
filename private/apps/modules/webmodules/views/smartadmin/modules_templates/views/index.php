

<div class="row">
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-table"></i> 
			<?php echo '<?=$this->lang->line(\'modules_name\')?>
'; ?>
			<span>>  
				<?php echo '<?=@$module_detail->webmodules_title?>
'; ?>
			</span>
		</h1>
	</div>
	
	<?php echo '<?php if($allow_add) : ?>
'; ?>
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		<?php echo '<?php if($this->config->item(\'form_in_ajax_modal\') == FALSE) : ?>
'; ?>
		<a href="<?php echo '<?=links_url(array(\'class\'=>$this->router->class,\'method\'=>\'add\'))?>'; ?>" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-plus fa-lg"></i>&emsp;<?php echo '<?=$this->lang->line(\'label_btn_add_modules\')?>'; ?></a>
		<?php echo '<?php else : ?>
'; ?>
		<a href="<?php echo '<?=links_url(array(\'class\'=>$this->router->class,\'method\'=>\'add\'))?>'; ?>" data-toggle="modal" data-target="#modal-<?php echo '<?=$this->router->class?>'; ?>" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-plus fa-lg"></i>&emsp;<?php echo '<?=$this->lang->line(\'label_btn_add_modules\')?>'; ?></a>
		<?php echo '<?php endif; ?>
'; ?>
	</div>
	<?php echo '<?php endif; ?>
'; ?>
</div>

<?php echo '<?php if(isset($message) && isset($message[\'text\'])) : ?>
'; ?>
<div class="alert alert-block alert-<?php echo '<?=((isset($message[\'status\'])) ? (($message[\'status\'] == \'error\') ? \'danger\' : \'success\') : \'warning\')?>'; ?>">
	<a class="close" data-dismiss="alert" href="#">×</a>
	<h4 class="alert-heading"><i class="fa fa-<?php echo '<?=((isset($message[\'status\'])) ? (($message[\'status\'] == \'error\') ? \'times-circle-o\' : \'check-square-o\') : \'warning\')?>'; ?>"></i> <?php echo '<?=((isset($message[\'status\'])) ? (($message[\'status\'] == \'error\') ? \'Error\' : \'Success\') : \'Warning\')?>'; ?>!</h4>
	<p><?php echo '<?=((isset($message[\'text\'])) ? $message[\'text\'] : \'\')?>'; ?></p>
</div>
<?php echo '<?php endif; ?>
'; ?>

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?php echo '<?=$this->router->class?>'; ?>-<?php echo '<?=$this->router->method?>'; ?>-0" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2><?php echo '<?=@$module_detail->webmodules_title?>'; ?> </h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
						<table id="dt_<?php echo '<?=$this->router->class?>'; ?>" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th data-hide="phone"></th>
<?php
if($table_fields && count($table_fields) > 0)
{
	$cols = 0;
	foreach ($table_fields as $idxTF => $field)
	{
		if($field->name <> $table_pkey && $field->name <> '_created_by' && $field->name <> '_updated_by' && $field->name <> '_created_at' && $field->name <> '_updated_at' && $field->name <> 'is_deleted')
		{
			if($cols == 0)
			{
echo '									<th data-class="expand"><?=$this->lang->line(\'table_column_'.$field->name.'\')?></th>
';
			}
			elseif($cols > 3)
			{
echo '									<th data-hide="phone,tablet"><?=$this->lang->line(\'table_column_'.$field->name.'\')?></th>
';
			}
			else
			{
echo '									<th data-hide="phone"><?=$this->lang->line(\'table_column_'.$field->name.'\')?></th>
';
			}
			$cols++;
		}
	}
}
?>
									<?php echo '<?php if($allow_detail || $allow_edit || $allow_delete) : ?>
'; ?>
									<th data-hide="phone,tablet"><?php echo '<?=$this->lang->line(\'table_column_action\')?>'; ?></th>
									<?php echo '<?php endif; ?>
'; ?>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>

<?php echo '<?php if($allow_add && $this->config->item(\'form_in_ajax_modal\') == TRUE) : ?>
';?>
<div class="modal fade" id="modal-<?php echo '<?=$this->router->class?>'; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-<?php echo '<?=$this->router->class?>'; ?>Label" aria-hidden="true">  
    <div class="modal-dialog modal-lg">  
        <div class="modal-content">
        </div>  
    </div>  
</div>
<?php echo '<?php endif; ?>
';?>
