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
			<section>
				<label class="label strong"><?=$groups_name['label'].((isset($groups_name['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('groups_name'))) ? ' state-error' : ''?>">
					<?=form_input($groups_name,$groups_name['value'],array('class'=>'','maxlength'=>'50','title'=>$groups_name['title'],'placeholder'=>$groups_name['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
				</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$groups_description['label'].((isset($groups_description['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('groups_description'))) ? ' state-error' : ''?>">
					<?=form_input($groups_description,$groups_description['value'],array('class'=>'','maxlength'=>'50','title'=>$groups_description['title'],'placeholder'=>$groups_description['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
				</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$groups_level['label'].((isset($groups_level['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('groups_level'))) ? ' state-error' : ''?>">
					<?=form_input($groups_level,$groups_level['value'],array('class'=>'','maxlength'=>'100','title'=>$groups_level['title'],'placeholder'=>$groups_level['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
					</label>
				<div class="note"></div>
			</section>
											
			<section>
				<label class="label strong"><?=$groups_internal['label'].((isset($groups_internal['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input select<?=(!empty(form_error('groups_internal'))) ? ' state-error' : ''?>">
					<?=form_dropdown($groups_internal['name'],$groups_internal['data'], @$groups_internal['selected'], array('class'=>''))?><i></i>
				</label>
				<div class="note"></div>
			</section>							
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
