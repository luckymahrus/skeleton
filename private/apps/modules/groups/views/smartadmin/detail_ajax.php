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
			<div class="row">
				<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<label class="label strong"><?=$groups_name['label']?></label>
					<label class="input state-disabled">
						<?=form_input($groups_name,$groups_name['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$groups_name['title'],'placeholder'=>$groups_name['placeholder']))?>
					</label>
				</section>
				<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<label class="label strong"><?=$groups_description['label']?></label>
					<label class="input state-disabled">
						<?=form_input($groups_description,$groups_description['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$groups_description['title'],'placeholder'=>$groups_description['placeholder']))?>
					</label>
				</section>
			</div>
			<div class="row">
				<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<label class="label strong"><?=$groups_level['label']?></label>
					<label class="input state-disabled">
						<?=form_input($groups_level,$groups_level['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$groups_level['title'],'placeholder'=>$groups_level['placeholder']))?>
					</label>
				</section>
				<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<label class="label strong"><?=$groups_internal['label']?></label>
					<label class="input select state-disabled">
						<?=form_dropdown($groups_internal['name'],$groups_internal['data'], @$groups_internal['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
					</label>
				</section>							
			</div>
			<div class="row">
				<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<label class="label strong"><?=$status['label']?></label>
					<label class="input select state-disabled">
						<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
					</label>
				</section>							
			</div>
		</fieldset>
        
		<footer>
			<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
				<?=$this->lang->line('label_btn_close')?>
			</button>
		</footer>
	<?=form_close()?>
</div>
