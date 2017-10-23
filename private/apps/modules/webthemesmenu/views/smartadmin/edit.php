<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$module_detail = get_module_detail($this->router->class,$this->router->method);
?>
<div class="row">
	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
		<h1 class="page-title txt-color-blueDark">
			
			<!-- PAGE HEADER -->
			<i class="fa-fw fa fa-pencil-square-o"></i> 
				Routes
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
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class.'-'.$this->router->method,'name'=>$this->router->class.'-'.$this->router->method,'class'=>'smart-form'),array('id'=>$webmodules_id))?>
							<!-- <header>
								Standard Form Header
							</header> -->

							<fieldset>
								<section>
									<label class="label strong">Themes <span class="required">(*)</span></label>
									<label class="select<?=(!empty(form_error('webmodules_id'))) ? ' state-error' : ''?>">
										<?=form_dropdown($webmodules_id['name'],$webmodules_id['data'], @$webmodules_id['selected'], array('class'=>''))?><i></i>
									</label>
									<?=form_error('webmodules_id','<div class="note note-danger">','</span>')?>
								</section>							

								<section>
									<label class="label strong">Routes Name <span class="required">(*)</span></label>
									<label class="input<?=(!empty(form_error('webroutes_name'))) ? ' state-error' : ''?>">
										<?=form_input($webroutes_name,$webroutes_name['value'],array('class'=>'','maxlength'=>'50','title'=>$webroutes_name['title'],'placeholder'=>$webroutes_name['placeholder']))?>
									</label>
									<?=form_error('webroutes_name','<div class="note note-danger">','</span>')?>
								</section>

								<section>
									<label class="label strong">Routes Title <span class="required">(*)</span></label>
									<label class="input<?=(!empty(form_error('webroutes_title'))) ? ' state-error' : ''?>">
										<?=form_input($webroutes_title,$webroutes_title['value'],array('class'=>'','maxlength'=>'50','title'=>$webroutes_title['title'],'placeholder'=>$webroutes_title['placeholder']))?>
									</label>
									<?=form_error('webroutes_title','<div class="note note-danger">','</span>')?>
								</section>

								<section>
									<label class="label strong">Routes Description</label>
									<label class="input<?=(!empty(form_error('webroutes_description'))) ? ' state-error' : ''?>">
										<?=form_input($webroutes_description,$webroutes_description['value'],array('class'=>'','maxlength'=>'100','title'=>$webroutes_description['title'],'placeholder'=>$webroutes_description['placeholder']))?>
									</label>
									<?=form_error('webroutes_description','<div class="note note-danger">','</span>')?>
								</section>

								<section>
									<label class="label strong">Routes Params</label>
									<label class="input<?=(!empty(form_error('webroutes_params'))) ? ' state-error' : ''?>">
										<?=form_input($webroutes_params,$webroutes_params['value'],array('class'=>'','maxlength'=>'100','title'=>$webroutes_params['title'],'placeholder'=>$webroutes_params['placeholder']))?>
									</label>
									<?=form_error('webroutes_params','<div class="note note-danger">','</span>')?>
								</section>

								<section>
									<label class="label strong">Routes Value</label>
									<label class="input<?=(!empty(form_error('webroutes_value'))) ? ' state-error' : ''?>">
										<?=form_input($webroutes_value,$webroutes_value['value'],array('class'=>'','maxlength'=>'100','title'=>$webroutes_value['title'],'placeholder'=>$webroutes_value['placeholder']))?>
									</label>
									<?=form_error('webroutes_value','<div class="note note-danger">','</span>')?>
								</section>
								
								<section>
									<label class="label strong">Routes Order</label>
									<label class="input<?=(!empty(form_error('webroutes_order'))) ? ' state-error' : ''?>">
										<?=form_input($webroutes_order,$webroutes_order['value'],array('class'=>'','title'=>$webroutes_order['title'],'placeholder'=>$webroutes_order['placeholder']))?>
									</label>
									<?=form_error('webroutes_order','<div class="note note-danger">','</span>')?>
								</section>
							</fieldset>
							
							<footer>
								<button type="submit" class="btn btn-primary">
									Submit
								</button>
								<button type="button" class="btn btn-default" onclick="window.history.back();">
									Back
								</button>
							</footer>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>
