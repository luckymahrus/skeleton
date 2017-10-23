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
								<div class="row">
									<!-- <section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tcorp['label'].((isset($tcorp['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('tcorp'))) ? ' state-error' : ''?>">
											<?=form_input($tcorp,$tcorp['value'],array('class'=>'','maxlength'=>'50','title'=>$tcorp['title'],'placeholder'=>$tcorp['placeholder'],'disabled'=>'disabled'))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section> -->
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tcode['label'].((isset($tcode['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('tcode'))) ? ' state-error' : ''?>">
											<?=form_input($tcode,$tcode['value'],array('class'=>'','maxlength'=>'50','title'=>$tcode['title'],'placeholder'=>$tcode['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>

									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$seqno['label'].((isset($seqno['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('seqno'))) ? ' state-error' : ''?>">
											<?=form_input($seqno,$seqno['value'],array('class'=>'','maxlength'=>'50','title'=>$seqno['title'],'placeholder'=>$seqno['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>
							
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<label class="label strong"><?=$tdesc['label'].((isset($tdesc['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('tdesc'))) ? ' state-error' : ''?>">
											<?=form_input($tdesc,$tdesc['value'],array('class'=>'','maxlength'=>'255','title'=>$tdesc['title'],'placeholder'=>$tdesc['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>
									<!-- <section class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<label class="label strong"><?=$ttype['label'].((isset($ttype['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select<?=(!empty(form_error('ttype'))) ? ' state-error' : ''?>">
											<?=form_dropdown($ttype['name'],$ttype['data'], @$ttype['selected'], array('class'=>''))?><i></i>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section> -->
								</div>
								<div class="row">
									<!-- <section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tstat['label'].((isset($tstat['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select<?=(!empty(form_error('tstat'))) ? ' state-error' : ''?>">
											<?=form_dropdown($tstat['name'],$tstat['data'], @$tstat['selected'], array('class'=>''))?><i></i>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<?=form_error('tstat','<div class="note note-danger">','</span>')?>
										<div class="note"></div>
									</section> -->
									<!-- <section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tnote['label'].((isset($tnote['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('tnote'))) ? ' state-error' : ''?>">
											<?=form_input($tnote,$tnote['value'],array('class'=>'','maxlength'=>'50','title'=>$tnote['title'],'placeholder'=>$tnote['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section> -->
								</div>
								<div class="row">
									<!-- <section class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<label class="label strong"><?=$tattr['label'].((isset($tattr['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('tattr'))) ? ' state-error' : ''?>">
											<?=form_input($tattr,$tattr['value'],array('class'=>'','maxlength'=>'250','title'=>$tattr['title'],'placeholder'=>$tattr['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$pcode['label'].((isset($pcode['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('pcode'))) ? ' state-error' : ''?>">
											<?=form_input($pcode,$pcode['value'],array('class'=>'','maxlength'=>'50','title'=>$pcode['title'],'placeholder'=>$pcode['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section> -->
									<!-- <section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$seqno['label'].((isset($seqno['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('seqno'))) ? ' state-error' : ''?>">
											<?=form_input($seqno,$seqno['value'],array('class'=>'','maxlength'=>'50','title'=>$seqno['title'],'placeholder'=>$seqno['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section> -->
								</div>
								<div class="row">
									
									<!-- <section class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<label class="label strong"><?=$status['label'].((isset($status['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select<?=(!empty(form_error('status'))) ? ' state-error' : ''?>">
											<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>''))?><i></i>
										</label>
										<?=form_error('status','<div class="note note-danger">','</span>')?>
								</section>	 -->
								</div>

								<div class="row">	

									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$chkbox['label'].((isset($chkbox['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="checkbox<?=(!empty(form_error('chkbox'))) ? ' state-error' : ''?>">
											<?=form_checkbox($chkbox,$chkbox['value'],array('class'=>'','maxlength'=>'50','title'=>$chkbox['title']))?><i></i> 
										
										</label>
										<?=form_error('chkbox','<div class="note note-danger">','</span>')?>
									</section>	



								</div> 

							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary">
									<?=$this->lang->line('label_btn_submit')?>
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
