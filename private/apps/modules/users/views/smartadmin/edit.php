<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$module_detail = get_module_detail($this->router->class,$this->router->method);
?>
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
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.@$users_id,array('id'=>$this->router->class.'-'.$this->router->method,'name'=>$this->router->class.'-'.$this->router->method,'class'=>'smart-form'),array('id'=>@$users_id))?>
							<!-- <header>
								Standard Form Header
							</header> -->

							<fieldset>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$users_first_name['label'].((isset($users_first_name['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('users_first_name'))) ? ' state-error' : ''?>">
											<?=form_input($users_first_name,$users_first_name['value'],array('class'=>'','maxlength'=>'50','title'=>$users_first_name['title'],'placeholder'=>$users_first_name['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$users_last_name['label'].((isset($users_last_name['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('users_last_name'))) ? ' state-error' : ''?>">
											<?=form_input($users_last_name,$users_last_name['value'],array('class'=>'','maxlength'=>'50','title'=>$users_last_name['title'],'placeholder'=>$users_last_name['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
										</label>
										<div class="note"></div>
									</section>
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$users_email['label'].((isset($users_email['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('users_email'))) ? ' state-error' : ''?>">
											<?=form_input($users_email,$users_email['value'],array('class'=>'','maxlength'=>'100','title'=>$users_email['title'],'placeholder'=>$users_email['placeholder']))?>
											<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
											</label>
										<div class="note"></div>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$groups_id['label'].((isset($groups_id['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('groups_id'))) ? ' state-error' : ''?>">
											<?=form_dropdown($groups_id['name'],$groups_id['data'], @$groups_id['selected'], array('class'=>''))?><i></i>
										</label>
										<div class="note"></div>
									</section>
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$status['label'].((isset($status['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select<?=(!empty(form_error('status'))) ? ' state-error' : ''?>">
											<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>''))?><i></i>
										</label>
										<?=form_error('status','<div class="note note-danger">','</span>')?>
									</section>							
									<?php if($allow_reset) : ?>					
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$reset_password['label'].((isset($reset_password['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="select<?=(!empty(form_error('reset_password'))) ? ' state-error' : ''?>">
											<?=form_dropdown($reset_password['name'],$reset_password['data'], @$reset_password['selected'], array('class'=>''))?><i></i>
										</label>
										<?=form_error('reset_password','<div class="note note-danger">','</span>')?>
									</section>					
									<?php endif; ?>		
								</div>
							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary">
									<?=$this->lang->line('title_btn_update')?>
								</button>
								<button type="button" class="btn btn-default" onclick="window.history.back();">
									<?=$this->lang->line('label_btn_cancel')?>
								</button>
							</footer>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>
