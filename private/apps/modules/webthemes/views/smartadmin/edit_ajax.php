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
	<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'),array('id'=>@$webthemes_id))?>
		<fieldset>
			<div id="messages" style="display: none;">
				<div class="alert"></div>
			</div>
			<section>
				<label class="label strong"><?=$webthemes_name['label'].((isset($webthemes_name['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('webthemes_name'))) ? ' state-error' : ''?>">
					<?=form_input($webthemes_name,$webthemes_name['value'],array('class'=>'','maxlength'=>'50','title'=>$webthemes_name['title'],'placeholder'=>$webthemes_name['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
				</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$webthemes_title['label'].((isset($webthemes_title['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('webthemes_title'))) ? ' state-error' : ''?>">
					<?=form_input($webthemes_title,$webthemes_title['value'],array('class'=>'','maxlength'=>'50','title'=>$webthemes_title['title'],'placeholder'=>$webthemes_title['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
				</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$webthemes_description['label'].((isset($webthemes_description['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('webthemes_description'))) ? ' state-error' : ''?>">
					<?=form_input($webthemes_description,$webthemes_description['value'],array('class'=>'','maxlength'=>'100','title'=>$webthemes_description['title'],'placeholder'=>$webthemes_description['placeholder']))?>
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
			<button name="submit" type="submit" class="btn btn-primary">
				<?=$this->lang->line('title_btn_update')?>
			</button>
			<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
				<?=$this->lang->line('label_btn_cancel')?>
			</button>
		</footer>
	<?=form_close()?>
</div>
