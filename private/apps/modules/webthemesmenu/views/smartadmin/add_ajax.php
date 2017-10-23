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
				<label class="label strong"><?=$webthemes_id['label'].((isset($webthemes_id['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="select<?=(!empty(form_error('webthemes_id'))) ? ' state-error' : ''?>">
					<?=form_dropdown($webthemes_id['name'],$webthemes_id['data'], @$webthemes_id['selected'], array('class'=>''))?><i></i>
				</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$webthemesmenu_name['label'].((isset($webthemesmenu_name['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('webthemesmenu_name'))) ? ' state-error' : ''?>">
					<?=form_input($webthemesmenu_name,$webthemesmenu_name['value'],array('class'=>'','maxlength'=>'50','title'=>$webthemesmenu_name['title'],'placeholder'=>$webthemesmenu_name['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
				</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$webthemesmenu_title['label'].((isset($webthemesmenu_title['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('webthemesmenu_title'))) ? ' state-error' : ''?>">
					<?=form_input($webthemesmenu_title,$webthemesmenu_title['value'],array('class'=>'','maxlength'=>'100','title'=>$webthemesmenu_title['title'],'placeholder'=>$webthemesmenu_title['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
					</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$webthemesmenu_description['label'].((isset($webthemesmenu_description['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('webthemesmenu_description'))) ? ' state-error' : ''?>">
					<?=form_input($webthemesmenu_description,$webthemesmenu_description['value'],array('class'=>'','maxlength'=>'100','title'=>$webthemesmenu_description['title'],'placeholder'=>$webthemesmenu_description['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
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
