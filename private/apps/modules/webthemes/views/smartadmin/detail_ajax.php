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
				<label class="label strong"><?=$webthemes_name['label']?></label>
				<label class="input state-disabled">
					<?=form_input($webthemes_name,$webthemes_name['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$webthemes_name['title'],'placeholder'=>$webthemes_name['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$webthemes_title['label']?></label>
				<label class="input state-disabled">
					<?=form_input($webthemes_title,$webthemes_title['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$webthemes_title['title'],'placeholder'=>$webthemes_title['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$webthemes_description['label']?></label>
				<label class="input state-disabled">
					<?=form_input($webthemes_description,$webthemes_description['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$webthemes_description['title'],'placeholder'=>$webthemes_description['placeholder']))?>
				</label>
			</section>
			<section>
				<label class="label strong"><?=$status['label']?></label>
				<label class="input select state-disabled">
					<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
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
