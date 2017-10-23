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
	<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'),array('id'=>@$users_id))?>
		<fieldset>
			<div id="messages" style="display: none;">
				<div class="alert"></div>
			</div>
			<section>
				<label class="label strong"><?=$tcode['label']?></label>
				<label class="input state-disabled">
					<?=form_input($tcode,$tcode['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tcode['title'],'placeholder'=>$tcode['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$tname['label']?></label>
				<label class="input state-disabled">
					<?=form_input($tname,$tname['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$tname['title'],'placeholder'=>$tname['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$ttype['label']?></label>
				<label class="input state-disabled">
					<?=form_input($ttype,$ttype['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$ttype['title'],'placeholder'=>$ttype['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$ttot['label']?></label>
				<label class="input state-disabled">
					<?=form_input($ttot,$ttot['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$ttot['title'],'placeholder'=>$ttot['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$tattr['label']?></label>
				<label class="input state-disabled">
					<?=form_input($tattr,$tattr['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$ttype['title'],'placeholder'=>$ttype['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$tdscrip['label']?></label>
				<label class="input state-disabled">
					<?=form_input($tdscrip,$tdscrip['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$ttype['title'],'placeholder'=>$ttype['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$tnote['label']?></label>
				<label class="input state-disabled">
					<?=form_input($tnote,$tnote['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$tnote['title'],'placeholder'=>$tnote['placeholder']))?>
				</label>
			</section>
									
		</fieldset>
        
		<footer>
			<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
				<?=$this->lang->line('label_btn_close')?>
			</button>
		</footer>
	<?=form_close()?>
</div>
