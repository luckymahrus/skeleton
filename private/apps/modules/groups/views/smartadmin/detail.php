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

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-<?=$this->router->class?>-<?=$this->router->method?>-0" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-user"></i> </span>
					<h2><?=@$module_detail->webmodules_title?> </h2>
				</header>

				<div>
					<div class="jarviswidget-editbox">
					</div>

					<div class="widget-body no-padding">
						<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)).'/'.@$users_id,array('id'=>$this->router->class.'-'.$this->router->method,'name'=>$this->router->class.'-'.$this->router->method,'class'=>'smart-form'),array('id'=>@$users_id))?>
							<!-- <header>
								Standard Form Header
							</header> -->

							<fieldset>
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
								<button type="button" class="btn btn-default" onclick="window.history.back();">
									<?=$this->lang->line('label_btn_close')?>
								</button>
							</footer>
						<?=form_close()?>
					</div>
				</div>
			</div>
		</article>				
	</div>
</section>
