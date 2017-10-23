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
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'))?>
							<fieldset>
								<section>
									<label class="label strong"><?=$uploads_name['label']?></label>
									<label class="input state-disabled">
										<?=form_input($uploads_name,@$uploads_name['value'],array('class'=>'','disabled'=>'disabled','readonly'=>'readonly','maxlength'=>'100','title'=>$uploads_name['title'],'placeholder'=>$uploads_name['placeholder']))?>
									</label>
									<div class="note"></div>
								</section>
								<section>
									<label class="label strong"><?=$uploads_description['label']?></label>
									<label class="input state-disabled">
										<?=form_input($uploads_description,@$uploads_description['value'],array('class'=>'','disabled'=>'disabled','readonly'=>'readonly','maxlength'=>'100','title'=>$uploads_description['title'],'placeholder'=>$uploads_description['placeholder']))?>
									</label>
									<div class="note"></div>
								</section>
								<section>
									<label class="label strong"><?=$uploads_client_name['label']?></label>
									<label class="input state-disabled">
										<?=form_input($uploads_client_name,@$uploads_client_name['value'],array('class'=>'','disabled'=>'disabled','readonly'=>'readonly','maxlength'=>'100','title'=>$uploads_client_name['title'],'placeholder'=>$uploads_client_name['placeholder']))?>
									</label>
									<div class="note"></div>
								</section>
								<section>
									<label class="label strong"><?=$uploads_file_ext['label']?></label>
									<label class="input state-disabled">
										<?=form_input($uploads_file_ext,@$uploads_file_ext['value'],array('class'=>'','disabled'=>'disabled','readonly'=>'readonly','maxlength'=>'100','title'=>$uploads_file_ext['title'],'placeholder'=>$uploads_file_ext['placeholder']))?>
									</label>
									<div class="note"></div>
								</section>
								<section>
									<label class="label strong"><?=$uploads_file_size['label']?></label>
									<label class="input state-disabled">
										<?=form_input($uploads_file_size,@$uploads_file_size['value'],array('class'=>'','disabled'=>'disabled','readonly'=>'readonly','maxlength'=>'100','title'=>$uploads_file_size['title'],'placeholder'=>$uploads_file_size['placeholder']))?>
									</label>
									<div class="note"></div>
								</section>
								<section>
									<label class="label strong"><?=$status['label']?></label>
									<label class="input select state-disabled">
										<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
									</label>
								</section>							
							</fieldset>
							
							<footer>
								<a href="<?=links_url(array('class'=>$this->router->class,'method'=>'download'))?>/<?=$uploads_raw_name['value']?>" class="btn btn-primary" target="_blank">
									<i class="fa fa-download"></i>&emsp;<?=$this->lang->line('label_btn_download')?>
								</a>
								<?php if(!$this->input->is_ajax_request()) { ?>
								<button type="button" class="btn btn-default" onclick="window.history.back();">
									<?=$this->lang->line('label_btn_back')?>
								</button>
								<?php }else{ ?>
								<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
									<?=$this->lang->line('label_btn_close')?>
								</button>
								<?php } ?>	
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
