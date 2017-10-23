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
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$users_first_name['label']?></label>
										<label class="input state-disabled">
											<?=form_input($users_first_name,$users_first_name['value'],array('class'=>'','maxlength'=>'50','title'=>$users_first_name['title'],'placeholder'=>$users_first_name['placeholder']))?>
										</label>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$users_last_name['label'].((isset($users_last_name['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($users_last_name,$users_last_name['value'],array('class'=>'','maxlength'=>'50','title'=>$users_last_name['title'],'placeholder'=>$users_last_name['placeholder']))?>
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$users_email['label'].((isset($users_email['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input state-disabled">
											<?=form_input($users_email,$users_email['value'],array('class'=>'','maxlength'=>'100','title'=>$users_email['title'],'placeholder'=>$users_email['placeholder']))?>
										</label>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$groups_id['label'].((isset($groups_id['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select state-disabled">
											<?=form_dropdown($groups_id['name'],$groups_id['data'], @$groups_id['selected'], array('class'=>''))?><i></i>
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$status['label'].((isset($status['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select state-disabled">
											<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>''))?><i></i>
										</label>
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
