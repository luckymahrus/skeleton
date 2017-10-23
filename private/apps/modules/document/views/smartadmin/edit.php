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
		<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
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
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.@$uploads_id,array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'),array('id'=>@$uploads_id))?>
							<fieldset>
								<section>
									<label class="label strong"><?=$uploads_name['label'].((isset($uploads_name['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
									<label class="input<?=(!empty(form_error('uploads_name'))) ? ' state-error' : ''?>">
										<?=form_input($uploads_name,$uploads_name['value'],array('class'=>'','maxlength'=>'50','title'=>$uploads_name['title'],'placeholder'=>$uploads_name['placeholder']))?>
										<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
									</label>
									<div class="note"></div>
								</section>
								<section>
									<label class="label strong"><?=$uploads_description['label'].((isset($uploads_description['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
									<label class="input<?=(!empty(form_error('uploads_description'))) ? ' state-error' : ''?>">
										<?=form_input($uploads_description,$uploads_description['value'],array('class'=>'','maxlength'=>'50','title'=>$uploads_description['title'],'placeholder'=>$uploads_description['placeholder']))?>
										<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
									</label>
									<div class="note"></div>
								</section>
								<section>
									<label class="label strong"><?=$status['label'].((isset($status['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
									<label class="input select<?=(!empty(form_error('status'))) ? ' state-error' : ''?>">
										<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>''))?><i></i>
									</label>
									<div class="note"></div>
								</section>							
							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary">
									<?=$this->lang->line('label_btn_update')?>
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
