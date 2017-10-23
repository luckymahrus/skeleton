<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$module_detail = get_module_detail($this->router->class,$this->router->method);
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">
        <?=@$module_detail->webmodules_title?>
    </h4>
</div>
<div class="modal-body no-padding">
	<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'))?>
		<fieldset>
			<div id="messages" style="display: none;">
				<div class="alert"></div>
			</div>
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
		</fieldset>
        
		<footer>
			<button name="submit" type="submit" class="btn btn-primary">
				<?=$this->lang->line('label_btn_submit')?>
			</button>
			<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
				<?=$this->lang->line('label_btn_cancel')?>
			</button>
		</footer>
	<?=form_close()?>
</div>
