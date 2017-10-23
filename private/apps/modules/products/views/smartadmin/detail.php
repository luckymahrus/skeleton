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
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.@$id,array('id'=>$this->router->class.'-'.$this->router->method,'name'=>$this->router->class.'-'.$this->router->method,'class'=>'smart-form'),array('id'=>@$id))?>
							<!-- <header>
								Standard Form Header
							</header> -->

							<fieldset>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tcode['label']?></label>
										<label class="input state-disabled">
											<?=form_input($tcode,$tcode['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tcode['title'],'placeholder'=>$tcode['placeholder']))?>
										</label>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$ttype['label']?></label>
										<label class="input state-disabled">
											<?=form_input($ttype,$ttype['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$ttype['title'],'placeholder'=>$ttype['placeholder']))?>
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tdesc['label']?></label>
										<label class="input state-disabled">
											<?=form_input($tdesc,$tdesc['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$tdesc['title'],'placeholder'=>$tdesc['placeholder']))?>
										</label>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tattr['label']?></label>
										<label class="input<?=(!empty(form_error('tattr'))) ? ' state-error' : ''?>">
											<?=form_input($tattr,$tattr['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tattr['title'],'placeholder'=>$tattr['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>

								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$pcode['label']?></label>
										<label class="input<?=(!empty(form_error('pcode'))) ? ' state-error' : ''?>">
											<?=form_input($pcode,$pcode['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$pcode['title'],'placeholder'=>$pcode['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$tnote['label']?></label>
										<label class="input<?=(!empty(form_error('tnote'))) ? ' state-error' : ''?>">
											<?=form_input($tnote,$tnote['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tnote['title'],'placeholder'=>$tnote['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>		
								</div>

								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$list_price['label']?></label>
										<label class="input<?=(!empty(form_error('list_price'))) ? ' state-error' : ''?>">
											<?=form_input($list_price,$list_price['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$list_price['title'],'placeholder'=>$list_price['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>							
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$status['label']?></label>
										<label class="input select state-disabled">
											<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
										</label>
									</section>							
								</div>
							</fieldset>
							
							<footer>
<?php if(!$this->input->is_ajax_request()) : ?>
								<button type="button" class="btn btn-default" onclick="window.history.back();">
									<?=$this->lang->line('label_btn_cancel')?>
								</button>
<?php else : ?>
								<button name="close" type="button" class="btn btn-default" data-dismiss="modal">
									<?=$this->lang->line('label_btn_close')?>
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

<script type="text/javascript">
	
	$(document).ready(function() {

	 // PAGE RELATED SCRIPTS

	 // Spinne
    		

})
</script>