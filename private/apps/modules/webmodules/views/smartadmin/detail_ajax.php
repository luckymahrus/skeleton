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
	<?=form_open_multipart(links_url(array('class'=>$this->router->class,'method'=>$this->router->method)),array('id'=>$this->router->class,'name'=>$this->router->class,'class'=>'smart-form'),array('id'=>@$webmodules_id))?>
		<fieldset>
			<div id="messages" style="display: none;">
				<div class="alert"></div>
			</div>
			<legend>Main Module</legend>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$webmodules_class['label']?></label>
					<label class="input state-disabled">
						<?=form_input($webmodules_class,@$webmodules_class['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$webmodules_class['title'],'placeholder'=>$webmodules_class['placeholder']))?>
					</label>
				</section>
				<section class="col col-6">
					<label class="label strong"><?=$webmodules_title['label']?></label>
					<label class="input state-disabled">
						<?=form_input($webmodules_title,@$webmodules_title['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'50','title'=>$webmodules_title['title'],'placeholder'=>$webmodules_title['placeholder']))?>
					</label>
				</section>
			</div>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$webmodules_description['label']?></label>
					<label class="input state-disabled">
						<?=form_input($webmodules_description,@$webmodules_description['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$webmodules_description['title'],'placeholder'=>$webmodules_description['placeholder']))?>
						<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
						</label>
				</section>
				<section class="col col-6">
					<label class="label strong"><?=$webmodules_icon['label']?></label>
					<label class="input state-disabled">
						<?=form_input($webmodules_icon,@$webmodules_icon['value'],array('class'=>'','disabled'=>'disabled','maxlength'=>'100','title'=>$webmodules_icon['title'],'placeholder'=>$webmodules_icon['placeholder']))?>
						<i class="form-control-feedback glyphicon pull-right" style="display: none;"></i>
						</label>
				</section>
			</div>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$editable['label']?></label>
					<label class="input select state-disabled">
						<?=form_dropdown($editable['name'],$editable['data'], @$editable['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
					</label>
				</section>							
				<section class="col col-6">
					<label class="label strong"><?=$removeable['label']?></label>
					<label class="input select state-disabled">
						<?=form_dropdown($removeable['name'],$removeable['data'], @$removeable['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
					</label>
				</section>							
			</div>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$need_login['label']?></label>
					<label class="input select state-disabled">
						<?=form_dropdown($need_login['name'],$need_login['data'], @$need_login['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
					</label>
				</section>							
				<section class="col col-6">
					<label class="label strong"><?=$groups_access['label']?></label>
					<div class="row">
					<?php
						$gaCols[0]	= array();
						$gaCols[1]	= array();

						$col = 0;
						foreach ($groups_access['data'] as $idxGA => $group)
						{
							$gaCols[$col][$idxGA]	= $group;
							$col++;

							if($col == count($gaCols)) $col = 0;
						}

						foreach ($gaCols as $idxC => $values)
						{
							echo '<div class="col col-'.(12/(count($gaCols))).'">';
							if(count($values) > 0)
							{
								foreach ($values as $idxV => $row)
								{
									echo '<label class="checkbox state-disabled"><input type="checkbox" name="'.$groups_access['name'].'" value="'.$idxV.'"'.((isset($groups_access['selected']) && !empty($groups_access['selected']) && !is_null($groups_access['selected']) && is_array($groups_access['selected']) && in_array((int)$idxV, $groups_access['selected'])) ? ' checked' : '').' disabled><i></i>'.$row.'</label>';
								}
							}
							echo '</div>';
						}
					?>
					</div>
				</section>
			</div>
			<div class="row">
				<section class="col col-6">
					<label class="label strong"><?=$status['label']?></label>
					<label class="input select state-disabled">
						<?=form_dropdown($status['name'],$status['data'], @$status['selected'], array('class'=>'','disabled'=>'disabled'))?><i></i>
					</label>
				</section>							
			</div>
		</fieldset>
 		<fieldset id="webmodules_method">
			<section>
				<legend>Method / Function</legend>
			</section>
			<?php 
				if(isset($methods) && count($methods) > 0)
				{
					foreach ($methods as $idxM => $method)
					{
			?>
			<div class="row_method" id="method-<?=$idxM?>">
				<div class="row">
					<section class="col col-5">
						<label class="label strong"><?=$webmodules_method_title['label']?></label>
						<label class="input state-disabled">
							<?php
								echo form_hidden('method_id['.$idxM.']', $method->webmodules_id);
								echo form_input($webmodules_method_title,@$method->webmodules_title,array('class'=>'webmodules_method_title','maxlength'=>'100','title'=>$webmodules_method_title['title'],'placeholder'=>$webmodules_method_title['placeholder']));
							?>
						</label>
					</section>
					<section class="col col-6">
						<label class="label strong"><?=$method_groups_access['label']?></label>
						<div class="row">
						<?php
							if(isset($method->groups_access) && !empty($method->groups_access) && !is_null($method->groups_access))
							{
								$serialGroupsMethod = unserialize($method->groups_access);
								$arrSelGroupsMethod = array();
								foreach ($serialGroupsMethod as $idxSGM => $mGroup)
								{
									$arrSelGroupsMethod[$mGroup] = $mGroup;
								}
							}
							$gaCols2[0]	= array();
							$gaCols2[1]	= array();

							$col2 = 0;
							foreach ($method_groups_access['data'] as $idxGA2 => $group2)
							{
								$gaCols2[$col2][$idxGA2]	= $group2;
								$col2++;

								if($col2 == count($gaCols2)) $col2 = 0;
							}

							foreach ($gaCols2 as $idxC2 => $values2)
							{
								echo '<div class="col col-'.(12/(count($gaCols2))).'">';
								if(count($values2) > 0)
								{
									foreach ($values2 as $idxV2 => $row2)
									{
										echo '<label class="checkbox state-disabled'.(($method->webmodules_method_type <> 'public') ? ' state-disabled' : '').'"><input type="checkbox" name="'.$method_groups_access['name'].'" value="'.$idxV2.'"'.((isset($arrSelGroupsMethod) &&!empty($arrSelGroupsMethod) && !is_null($arrSelGroupsMethod) && is_array($arrSelGroupsMethod) && in_array($idxV2, $arrSelGroupsMethod)) ? (($method->webmodules_method_type <> 'public') ? '' : ' checked') : '').''.(($method->webmodules_method_type <> 'public') ? '  onclick="return false;"' : '').' disabled><i></i>'.$row2.'</label>';
									}
								}
								echo '</div>';
							}
						?>
						</div>
					</section>
				</div>
				<div class="row">
					<section class="col col-5">
						<label class="label strong"><?=$webmodules_method['label']?></label>
						<label class="input state-disabled state-disabled">
							<?=form_input($webmodules_method,@$method->webmodules_method,array('class'=>'webmodules_method','disabled'=>'disabled','maxlength'=>'100','title'=>$webmodules_method['title'],'placeholder'=>$webmodules_method['placeholder']))?>
						</label>
					</section>
					<section class="col col-3">
						<label class="label strong"><?=$method_type['label']?></label>
						<label class="input select state-disabled state-disabled">
							<?=form_dropdown($method_type['name'],$method_type['data'], @$method->webmodules_method_type, array('class'=>'method_type','disabled'=>'disabled'))?><i></i>
						</label>
					</section>
				</div>
				<hr>
			</div>
			<?php
					}
				}
			?>
		</fieldset>
       
		<footer>
			<button name="cancel" type="button" class="btn btn-default" data-dismiss="modal">
				<?=$this->lang->line('label_btn_close')?>
			</button>
		</footer>
	<?=form_close()?>
</div>
