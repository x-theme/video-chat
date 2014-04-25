<?php
	$img = x::url_theme() . '/img';
?>
<link rel="stylesheet" href="<?=x::url_theme()?>/css/lobby.css">

<center>
	<div id='withcenter-video-chat'>
	<div class='headerfield'>
		<div id='withcenter-vc-header'>
				<div class='icon'><img src='<?=$img?>/icon.png'></div>
				<div class='menu'>
					<a href='#' class='link home'><img src='<?=$img?>/home.png'><?=lang("HOME")?></a>
					<a href='#' class='link about'><img src='<?=$img?>/about.png'><?=lang("ABOUT")?></a>
					<a href='#' class='link terms'><img src='<?=$img?>/terms.png'><?=lang("TERMS")?></a>
					<a href='#' class='link support'><img src='<?=$img?>/support.png'><?=lang("SUPPORT")?></a>
				</div>
			</div>
	</div>	
		<form class='class-room' action='?'>
			<input type="hidden" name="page" value="room">
			<input id='input-room-name' type='text' name='room_name' value='' placeholder='<?=lang("ROOM NAME")?>' autocomplete="off">
			<input id='input-user-name' type='text' name='user_name' value='' placeholder='<?=lang("USER NAME")?>' autocomplete="off">
			<input id='start-to-join' type='submit' value='Start!'>
		</form>
	<table id='get-pro-box-container' cellpadding=0 cellspacing=0>
	<tr valign='top'>
		<td>
			<div class='easy-to-use get-pro-box'>
				<div class='img-holder'><img src='<?=$img?>/wrench.png'></div>
				<div class='text'>
					<span class='title'>
					Easy To Use
					</span>
					<span class='description'>
					Start chatting as fast as clicking a button!
					</span>
					<a class='get-pro' href='#'>Get Pro</a>
				</div>
			</div>
		</td>
		<td class='space'></td>
		<td>
			<div class='easy-to-use get-pro-box'>
			<div class='img-holder'><img src='<?=$img?>/gift.png'></div>
			<div class='text'>
				<span class='title'>
				Free To Use
				</span>
				<span class='description'>
				Share the conversation with multiple people!
				</span>
				<a class='get-pro' href='#'>Get Pro</a>
			</div>
			</div>
		</td>
		<td class='space'></td>
		<td>
		<div class='easy-to-use get-pro-box'>
			<div class='img-holder'><img src='<?=$img?>/paint.png'></div>
				<div class='text'>
					<span class='title'>
					Fun To Use
					</span>
					<span class='description'>
					Easy to add or change elements!
					</span>
					<a class='get-pro' href='#'>Get Pro</a>
			</div></div>
		</td>
		</tr>
	</table>	
		<div class='footer'>
			© COPYRIGHT 2014 DOMAIN.COM
			<? if ( admin() ) { ?>
			
			<? } ?>
		</div>
	</div>
</center>
</div>


<!--[if IE 7]>
<style>
	#withcenter-video-chat #get-pro-box-container .get-pro-box .text{		
		left:10px
	}

	#withcenter-video-chat #get-pro-box-container{		
		width:406px;		
	}	
	#withcenter-video-chat #get-pro-box-container .get-pro-box{	
		width: 112px;
	}
</style>
<![endif]-->



