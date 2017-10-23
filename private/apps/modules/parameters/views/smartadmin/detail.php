<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if(!$this->input->is_ajax_request()) { ?>
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
					<?php }else{ ?>
					<div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					    <h4 class="modal-title">
					        <?=@$module_detail->webmodules_title?>
					    </h4>
					</div>
					<div class="modal-body no-padding">
					<?php } ?>	
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.@$users_id,array('id'=>$this->router->class.'-'.$this->router->method,'name'=>$this->router->class.'-'.$this->router->method,'class'=>'smart-form'),array('id'=>@$users_id))?>
							<!-- <header>
								Standard Form Header
							</header> -->

							<fieldset>
								<div class="row">
									<!-- <section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tcorp['label']?></label>
										<label class="input state-disabled">
											<?=form_input($tcorp,$tcorp['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tcorp['title'],'placeholder'=>$tcorp['placeholder']))?>
										</label>
									</section> -->
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tcode['label'].((isset($tcode['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($tcode,$tcode['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tcode['title'],'placeholder'=>$tcode['placeholder']))?>
										</label>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$seqno['label'].((isset($seqno['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($seqno,$seqno['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$seqno['title'],'placeholder'=>$seqno['placeholder']))?>
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tdesc['label'].((isset($tdesc['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($tdesc,$tdesc['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tdesc['title'],'placeholder'=>$tdesc['placeholder']))?>
										</label>
									</section>
									<!-- <section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$ttype['label'].((isset($ttype['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select state-disabled">
											<?=form_dropdown($ttype['name'],$ttype['data'], @$ttype['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section> -->
								</div>
								<div class="row">
									<!-- <section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tstat['label']?></label>
										<label class="select state-disabled">
											<?=form_dropdown($tstat['name'],$tstat['data'], @$tstat['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
										</label>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tnote['label'].((isset($tnote['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($tnote,$tnote['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tnote['title'],'placeholder'=>$tnote['placeholder']))?>
										</label>
									</section> -->
								</div>
								<div class="row">
									<!-- <section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tattr['label'].((isset($tattr['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($tattr,$tattr['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tattr['title'],'placeholder'=>$tattr['placeholder']))?>
										</label>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$pcode['label'].((isset($pcode['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($pcode,$pcode['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$pcode['title'],'placeholder'=>$pcode['placeholder']))?>
										</label>
									</section> -->
								</div>
								<!-- <div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$seqno['label'].((isset($seqno['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($seqno,$seqno['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$seqno['title'],'placeholder'=>$seqno['placeholder']))?>
										</label>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$status['label'].((isset($status['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select state-disabled">
											<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
										</label>
									</section>
								</div> -->
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
						<?php if(!$this->input->is_ajax_request()) { ?>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>
<?php }else{ ?>
					</div>
					<?php } ?>	
