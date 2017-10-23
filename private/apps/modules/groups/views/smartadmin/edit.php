<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$module_detail = get_module_detail($this->router->class,$this->router->method);
?>
<div class="row">
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-pencil-square-o"></i> 
			<?=$this->lang->line('modules_name')?>
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
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.@$groups_id,array('id'=>$this->router->class.'-'.$this->router->method,'name'=>$this->router->class.'-'.$this->router->method,'class'=>'smart-form'),array('id'=>$groups_id))?>
							<!-- <header>
								Standard Form Header
							</header> -->

							<fieldset>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$groups_name['label'].((isset($groups_name['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('groups_name'))) ? ' state-error' : ''?>">
											<?=form_input($groups_name,$groups_name['value'],array('class'=>'','maxlength'=>'50','title'=>$groups_name['title'],'placeholder'=>$groups_name['placeholder']))?>
										</label>
										<?=form_error('groups_name','<div class="note note-danger">','</span>')?>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$groups_description['label'].((isset($groups_description['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('groups_description'))) ? ' state-error' : ''?>">
											<?=form_input($groups_description,$groups_description['value'],array('class'=>'','maxlength'=>'100','title'=>$groups_description['title'],'placeholder'=>$groups_description['placeholder']))?>
										</label>
										<?=form_error('groups_description','<div class="note note-danger">','</span>')?>
									</section>
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$groups_level['label'].((isset($groups_level['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input<?=(!empty(form_error('groups_level'))) ? ' state-error' : ''?>">
											<?=form_input($groups_level,$groups_level['value'],array('class'=>'','step'=>'1','min'=>'0','max'=>'100','title'=>$groups_level['title'],'placeholder'=>$groups_level['placeholder']))?>
										</label>
										<?=form_error('groups_level','<div class="note note-danger">','</span>')?>
									</section>
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$groups_internal['label'].((isset($groups_internal['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('groups_internal'))) ? ' state-error' : ''?>">
											<?=form_dropdown($groups_internal['name'],$groups_internal['data'], @$groups_internal['selected'], array('class'=>''))?><i></i>
										</label>
										<?=form_error('groups_internal','<div class="note note-danger">','</span>')?>
									</section>
								</div>
								<div class="row">
									<section class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="label strong"><?=$status['label'].((isset($status['required'])) ? ' <span class="required">(*)</span>' : '')?></label>
										<label class="input select<?=(!empty(form_error('status'))) ? ' state-error' : ''?>">
											<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>''))?><i></i>
										</label>
										<?=form_error('status','<div class="note note-danger">','</span>')?>
									</section>
								</div>
							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary">
									<?=$this->lang->line('label_btn_submit')?>
								</button>
								<button type="button" class="btn btn-default" onclick="window.history.back();">
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
