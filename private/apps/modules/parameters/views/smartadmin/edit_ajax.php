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
				<label class="label strong"><?=$tcode['label'].((isset($tcode['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('tcode'))) ? ' state-error' : ''?>">
					<?=form_input($tcode,$tcode['value'],array('class'=>'','maxlength'=>'50','title'=>$tcode['title'],'placeholder'=>$tcode['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
				</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$tname['label'].((isset($tname['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('tname'))) ? ' state-error' : ''?>">
					<?=form_input($tname,$tname['value'],array('class'=>'','maxlength'=>'50','title'=>$tname['title'],'placeholder'=>$tname['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
				</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$ttype['label'].((isset($ttype['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('ttype'))) ? ' state-error' : ''?>">
					<?=form_input($ttype,$ttype['value'],array('class'=>'','maxlength'=>'100','title'=>$ttype['title'],'placeholder'=>$ttype['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
					</label>
				<div class="note"></div>
			</section>
			<section>
				<label class="label strong"><?=$ttot['label'].((isset($ttot['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('ttot'))) ? ' state-error' : ''?>">
					<?=form_input($ttot,$ttot['value'],array('class'=>'','maxlength'=>'100','title'=>$ttype['title'],'placeholder'=>$ttype['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
					</label>
				<div class="note"></div>
			</section>	
			<section>
				<label class="label strong"><?=$tattr['label'].((isset($tattr['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('tattr'))) ? ' state-error' : ''?>">
					<?=form_input($tattr,$tattr['value'],array('class'=>'','maxlength'=>'100','title'=>$tattr['title'],'placeholder'=>$tattr['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
					</label>
				<div class="note"></div>
			</section>	
			<section>
				<label class="label strong"><?=$tdscrip['label'].((isset($tdscrip['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('tdscrip'))) ? ' state-error' : ''?>">
					<?=form_input($tdscrip,$tdscrip['value'],array('class'=>'','maxlength'=>'100','title'=>$tdscrip['title'],'placeholder'=>$tdscrip['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
					</label>
				<div class="note"></div>
			</section>	
			<section>
				<label class="label strong"><?=$tnote['label'].((isset($tnote['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input<?=(!empty(form_error('tnote'))) ? ' state-error' : ''?>">
					<?=form_input($tnote,$tnote['value'],array('class'=>'','maxlength'=>'100','title'=>$tnote['title'],'placeholder'=>$tnote['placeholder']))?>
					<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
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
