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
	<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'),array('id'=>@$id))?>
		<fieldset>
			<div id="messages" style="display: none;">
				<div class="alert"></div>
			</div>
			<div class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_code')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('code'))) ? ' state-error' : ''?>">
						<?=form_input($code,$code['value'],array('class'=>'input-lg','maxlength'=>'50','title'=>$code['title'],'placeholder'=>$code['placeholder']))?>
					</label>
					<?=form_error('code','<div class="note note-danger">','</span>')?>
				</section>
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_name')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('name'))) ? ' state-error' : ''?>">
						<?=form_input($name,$name['value'],array('class'=>'input-lg','maxlength'=>'50','title'=>$name['title'],'placeholder'=>$name['placeholder']))?>
					</label>
					<?=form_error('name','<div class="note note-danger">','</span>')?>
				</section>
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_category')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('category'))) ? ' state-error' : ''?>">
						<?=form_input($category,$category['value'],array('class'=>'input-lg','maxlength'=>'100','title'=>$category['title'],'placeholder'=>$category['placeholder']))?>
					</label>
					<?=form_error('category','<div class="note note-danger">','</span>')?>
				</section>
												
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_note')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('note'))) ? ' state-error' : ''?>">
						<?=form_input($note,$note['value'],array('class'=>'input-lg','maxlength'=>'100','rows'=>'26','title'=>$note['title'],'placeholder'=>$note['placeholder']))?>
					</label>
					<?=form_error('note','<div class="note note-danger">','</span>')?>
				</section>
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_website')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('website'))) ? ' state-error' : ''?>">
						<?=form_input($website,$website['value'],array('class'=>'input-lg','maxlength'=>'100','title'=>$website['title'],'placeholder'=>$website['placeholder']))?>
					</label>
					<?=form_error('website','<div class="note note-danger">','</span>')?>
				</section>
				<section>
				<label class="label strong"><?=$status['label'].((isset($status['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
				<label class="input select<?=(!empty(form_error('status'))) ? ' state-error' : ''?>">
					<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>'input-lg'))?><i></i>
				</label>
				<div class="note"></div>
			</section>
				
			</div>
			<div class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_address')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('address'))) ? ' state-error' : ''?>">
						<?=form_input($address,$address['value'],array('class'=>'input-lg','maxlength'=>'50','title'=>$address['title'],'placeholder'=>$address['placeholder']))?>
					</label>
					<?=form_error('address','<div class="note note-danger">','</span>')?>
				</section>
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_city')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('city'))) ? ' state-error' : ''?>">
						<?=form_input($city,$city['value'],array('class'=>'input-lg','maxlength'=>'50','title'=>$city['title'],'placeholder'=>$city['placeholder']))?>
					</label>
					<?=form_error('city','<div class="note note-danger">','</span>')?>
				</section>
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_province')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('province'))) ? ' state-error' : ''?>">
						<?=form_input($province,$province['value'],array('class'=>'input-lg','maxlength'=>'100','title'=>$province['title'],'placeholder'=>$province['placeholder']))?>
					</label>
					<?=form_error('province','<div class="note note-danger">','</span>')?>
				</section>
												
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_country')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('country'))) ? ' state-error' : ''?>">
						<?=form_input($country,$country['value'],array('class'=>'input-lg','maxlength'=>'100','title'=>$country['title'],'placeholder'=>$country['placeholder']))?>
					</label>
					<?=form_error('country','<div class="note note-danger">','</span>')?>
				</section>
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_post_code')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('post_code'))) ? ' state-error' : ''?>">
						<?=form_input($post_code,$post_code['value'],array('class'=>'input-lg','maxlength'=>'100','title'=>$post_code['title'],'placeholder'=>$post_code['placeholder']))?>
					</label>
					<?=form_error('post_code','<div class="note note-danger">','</span>')?>
				</section>
				<section>
					<label class="label strong"><?=$this->lang->line('table_column_phone')?> <span class="required">(*)</span></label>
					<label class="input<?=(!empty(form_error('phone'))) ? ' state-error' : ''?>">
						<?=form_input($phone,$phone['value'],array('class'=>'input-lg','maxlength'=>'100','title'=>$phone['title'],'placeholder'=>$phone['placeholder']))?>
					</label>
					<?=form_error('phone','<div class="note note-danger">','</span>')?>
				</section>
				
			</div>					
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
