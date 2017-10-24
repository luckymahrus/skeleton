

<?php echo '<?php if(!$this->input->is_ajax_request()) : ?>
'; ?>
<div class="row">
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-pencil-square-o"></i> 
			<?php echo '<?=$this->lang->line(\'modules_name\')?>
'; ?>
			<span>>  
				<?php echo '<?=@$module_detail->webmodules_title?>
'; ?>
			</span>
		</h1>
	</div>
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
		<article class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?php echo '<?=$this->router->class?>'; ?>-<?php echo '<?=$this->router->method?>'; ?>-0" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-user"></i> </span>
					<h2><?php echo '<?=@$module_detail->webmodules_title?>'; ?></h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
<?php echo '<?php else : ?>
'; ?>
					<div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					    <h4 class="modal-title">
					        <?php echo '<?=@$module_detail->webmodules_title?>
'; ?>
					    </h4>
					</div>
					<div class="modal-body no-padding">
<?php echo '<?php endif; ?>
'; ?>
						<?php echo '<?=form_open_multipart(links_url(array(\'class\'=>$this->router->class,\'method\'=>$this->router->method)).\'/\'.$'.$table_pkey.',array(\'id\'=>$this->router->class,\'name\'=>$this->router->class,\'class\'=>\'smart-form\'),array(\'id\'=>$'.$table_pkey.'))?>
'; ?>
							<fieldset>
								<div id="messages" style="display: none;">
									<div class="alert"></div>
								</div>
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
echo '								<div class="row">
';
			}
			if($field->name == 'status' || (($field->type == 'smallint' || $field->type == 'tinyint') && $field->max_length <= 2))
			{
echo '									<section class="col col-6">
';
echo '										<label class="label strong"><?=$'.$field->name.'[\'label\'].((isset($'.$field->name.'[\'required\'])) ? \' <span class="required">(*)</span>\' : \'\')?></label>
';
echo '										<label class="input select<?=(!empty(form_error(\''.$field->name.'\'))) ? \' state-error\' : \'\'?>">
';
echo '											<?=form_dropdown($'.$field->name.'[\'name\'],$'.$field->name.'[\'data\'], @$'.$field->name.'[\'selected\'], array(\'class\'=>\'\'))?>
';
echo '										</label>
';
echo '										<div class="note"></div>
';
echo '									</section>
';
			}
			else
			{
echo '									<section class="col col-6">
';
echo '										<label class="label strong"><?=$'.$field->name.'[\'label\'].((isset($'.$field->name.'[\'required\'])) ? \' <span class="required">(*)</span>\' : \'\')?></label>
';
echo '										<label class="input<?=(!empty(form_error(\''.$field->name.'\'))) ? \' state-error\' : \'\'?>">
';
echo '											<?=form_input($'.$field->name.',@$'.$field->name.'[\'value\'],array(\'class\'=>\'\',\'maxlength\'=>\''.$field->max_length.'\',\'title\'=>$'.$field->name.'[\'title\'],\'placeholder\'=>$'.$field->name.'[\'placeholder\']))?>
';
echo '											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
';
echo '										</label>
';
echo '										<div class="note"></div>
';
echo '									</section>
';
			}
			if($cols == 1)
			{
echo '								</div>
';
				$cols = 0;
			}
			else
			{
				$cols++;
			}
		}
	}
}
?>
							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary">
									<?php echo '<?=$this->lang->line(\'title_btn_update\')?>
'; ?>
								</button>
<?php echo '<?php if(!$this->input->is_ajax_request()) : ?>
'; ?>
								<button type="button" class="btn btn-default" onclick="window.history.back();">
									<?php echo '<?=$this->lang->line(\'label_btn_cancel\')?>
'; ?>
								</button>
<?php echo '<?php else : ?>
'; ?>
								<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
									<?php echo '<?=$this->lang->line(\'label_btn_cancel\')?>
'; ?>
								</button>
<?php echo '<?php endif; ?>	
'; ?>
							</footer>
						<?php echo '<?=form_close()?>
'; ?>
<?php echo '<?php if(!$this->input->is_ajax_request()) : ?>
'; ?>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>
<?php echo '<?php else : ?>
'; ?>
					</div>
<?php echo '<?php endif; ?>	
'; ?>

