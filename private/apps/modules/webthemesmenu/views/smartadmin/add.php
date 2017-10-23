<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$module_detail = get_module_detail($this->router->class,$this->router->method);
?>
<div class="row">
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-pencil-square-o"></i> 
				Themes Menu
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
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?=$this->router->class?>-<?=$this->router->method?>-0" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-user"></i> </span>
					<h2><?=@$module_detail->webmodules_title?> </h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'))?>
							<!-- <header>
								Standard Form Header
							</header> -->

							<fieldset>
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
				</div>
			</div>
		</article>				
	</div>
</section>
