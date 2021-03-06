<?php
	if ( strpos($in['user_name'], ' ') ) {
		return jsBack( lang("No space allowed in user name") );
	}
	
	$img = x::url_theme() . '/img';
	date_default_timezone_set('Asia/Seoul');
	error_reporting( E_ALL ^ E_NOTICE );
	
	$url_node_media_server = config("url_node_media_server");
	if ( empty( $url_node_media_server ) ) $url_node_media_server = "https://ontue.com:8443";
?>
<script>
/**
 *  @warning The code below must be set proper media server.
 *  @warning 아래의 설정은 미디어 서버를 지정하는 것입니다. 올바른 미디어 서버 주소를 입력하셔야 합니다.
 *  이 값은 관리자 페이지에서 설정을 할 수 있으며, 기본적으로 ontue.com 의 서버를 빌려서 씁니다.
 *  이 ontue.com 는 임시적인 것으로 언제든지 서비스를 중단할 수 있으므로 직접 미디어 서버 설정을 하여야 합니다.
 */
var $url_node_server	= "<?=$url_node_media_server?>";
</script>
<script src="<?=x::url()?>/module/video-chat-server/video-chat-server.js"></script>
<script src="<?=x::url_theme('js/theme.js')?>" /></script>
<!--link rel="stylesheet" href="<?=x::url()?>/module/video-chat-server/basic.css"-->
<?/*
	아래의 두 CSS 파일은 옵션입니다.
	화면을 좀 더 잘 보이도록 스타일을 지정해 주는 것 뿐입니다.
*/?>
<link rel="stylesheet" href="<?=x::url_theme()?>/css/room.css">
<link rel="stylesheet" href="<?=x::url_theme()?>/css/whiteboard.css">
<script>
/**
 *  @warning The code below is necessary.
 *  @warning 아래의 코드는 필수입니다.
 *  필수 코드는 $url_node_server 변수와 x_enter_room() 함수 두개 뿐입니다. 나머지는 옵션입니다.
 */
$(function(){
	x_enter_room(
		{
			'room_name' : "<?=$_GET['room_name']?>",
			'user_name' : '<?=$_GET['user_name']?>',
			'perspective' : null,
			 'whiteboard' : true
		}
	);
});
</script>

<script>
/**
 *  @note the code below is option.
 *  @note 아래의 코드(들)는 옵션입니다. 보기 좋게 하기 위해서 꾸미는 것입니다.
 */
$(function(){
	var url_home = "<?=g::url()?>";
	var enablevid = true;
	var enablemic = true;
	
	$("[name='copy_address']").click(function(){
		$("[name='copy_address']")[0].select();
		console.log('a');
	});
	$('.room-settings').click(function(){
		$('.room-settings .triangle').toggle();
		$('.room-settings-content').toggle();
	});
	setInterval(function(){
		if( $('.slot').length ){	
			$('#chat-box').show();			
			$('.top-menu').show();
		}		
		$('#chat-box').height($('#video-box').height() - 11 );
		$('#chat-message').height($('#video-box').height() - 94);			
	},2000);
	
	$('#chat-box').append("<table id='chat-settings' cellspacing=0 cellpadding=0><tr valing='top'>" +
	"<td class='left settings'><div class='chat-triangle'></div><div class='left-command mute-chat'></div><div class='left-command camera-chat'></div><div class='left-command leave-chat'></div></td>" + 
	"<td class='middle settings'></td>" + 
	"<td class='member-list settings'><div class='triangle'></div><div id='guests'></div></td>" + 
	"</tr></table>");		
	
	$('.member-list.settings').mouseout(function(){		
		$('.member-list .triangle').hide();
		$('#guests').hide();				
	});
	
	$('.left.settings').click(function(){
		console.log($(this).prop('class'));
		$('.chat-triangle').toggle();
		$('.left-command').toggle();
	});	
	
	$(".chat [type='submit']").val('');
	
	$('.do-command').mouseover(function(){		
		tooltip_command_class = $(this).prop('class');
		if( tooltip_command_class == 'do-command leave' ){
			$('.do-command.leave .tooltip').show();
			$('.do-command.leave .tip').show();
		}
		else if ( tooltip_command_class == 'do-command camera on'){
			$('.do-command.camera .tooltip').show();
			$('.do-command.camera .tooltip .tip.on').show();
		}
		else if ( tooltip_command_class == 'do-command camera off'){
			$('.do-command.camera .tooltip').show();
			$('.do-command.camera .tooltip .tip.off').show();
		}
		else if ( tooltip_command_class == 'do-command sound on' ){
			$('.do-command.sound .tooltip').show();
			$('.do-command.sound .tooltip .tip.on').show();
		}
		else if ( tooltip_command_class == 'do-command sound off' ){
			$('.do-command.sound .tooltip').show();
			$('.do-command.sound .tooltip .tip.off').show();
		}
	});
	
	$('.do-command').mouseout(function(){
		$('.tooltip').hide();	
		$('.tip').hide();
	});	

	$('.member-list.settings').mouseover(function(){
		var alone = true;
		$('#guests').html('').append('USERS ONLINE:<br>');
		for ( var id in $connected ) {
			$('#guests').append("<div class='id'>" + ids[id] + "</div>");
			alone = false;
		}
		
		if( alone ){
			$('#guests').append("<div class='id'>NONE</div>");
		}
		
		$('.member-list .triangle').show();
		$('#guests').show();				
	});	
	
	$('.do-command').click(function(){
		command_class = $(this).prop('class');
		
		if ( command_class == 'do-command leave' ) {
			location.href = url_home;
		}
		else if ( command_class == 'do-command camera on' || command_class == 'do-command camera off'){		
			
			// The code below is supposed to be the code created by easyrtc, but the easyrtc.js has a wrong function reference.
			// "easyrtc.enableCamera(enable);"
			// 'enable' is a boolean variable.
			// The reference problem is already noticed by the easyrtc programmers(at around 20 days ago) 
			// but is still not updated in version 1.0.7 (Because this update happened at around a month ago)
			// So I temporarily copied the function and made use of it like given below.
			// The code is the same when disabling/muting the audio tracks.
			//

			// this function makes your self video freeze(chrome) or black screen(Firefox) 
			// Clients connected with you will see your video in black screen.
			// THIS IS DONE BY DISABLING THE VIDEO TRACKS THAT IS CONSTANTLY AND CONTINUOUSLY SENT TO CONNECTED PEERS
			
			$('.tooltip').hide();	
			$('.tip').hide();
			$('.do-command.camera .tooltip').show();			
			if( enablevid == true ){
				enablevid = false;
				console.log('Video Tracks Removed');
				$(this).removeClass('on');
				$(this).addClass('off');								
				$('.do-command.camera .tip.off').show();
			}
			else{
				enablevid = true;				
				console.log('Video Tracks Added');
				$(this).removeClass('off');
				$(this).addClass('on');				
				$('.do-command.camera .tip.on').show();
			}
			var vidtracks = easyrtc.localStream.getVideoTracks();
			if (vidtracks) {
				for (var i = 0; i < vidtracks.length; i++) {
				var vidtrack = vidtracks[i];
				vidtrack.enabled = enablevid;
				}
			}
		}
		else if ( command_class == 'do-command sound on' || command_class == 'do-command sound off'){
			//this function mutes your video
			//THIS IS DONE BY DISABLING THE AUDIO TRACKS THAT IS CONSTANTLY AND CONTINUOUSLY SENT TO CONNECTED PEERS
			//"easyrtc.enableMicrophone(enable);"
			$('.tooltip').hide();	
			$('.tip').hide();
			$('.do-command.sound .tooltip').show();	
			if( enablemic == true ){
				enablemic = false;
				console.log('Audio Tracks Removed');
				$(this).removeClass('on');
				$(this).addClass('off');				
				$('.do-command.sound .tip.off').show();
			}
			else{
				enablemic = true;
				console.log('Audio Tracks Added');
				$(this).removeClass('off');
				$(this).addClass('on');
				$('.do-command.sound .tip.on').show();
			}
			var mictracks = easyrtc.localStream.getAudioTracks()
			if (mictracks) {
				for (var i = 0; i < mictracks.length; i++) {
				var mictrack = mictracks[i];
				mictrack.enabled = enablemic;
				}
			}
		}
		$('.room-settings .triangle').toggle();
		$('.room-settings-content').toggle();
	});	
	
	
	/*canvas*/
	if( $("#canvas").length ){		
		$("#canvas")[0].width = 960;		
	}
	$("li.text-book").click(function(){
	
			$("#canvas .menu-content").css("width","100%");		
	});	
	/****/
});

/**
 *  @param id is your rtc_id. if you want to do with your video, then you can use it.
 */
var ids = {};
/** @short shows your name.
 *  
 */
function callback_connected( id, name )
{
	$('.loader').slideUp();
	if ( name.charAt(0) == '-' && name.charAt(1) == '-' ) {
		name = "No name";
	}
	$("[rtc_id='"+id+"']").parent().find('.name').text( "You : " + name );
}
/** @short displays 
 *  
 */
var count_other = 0;
function callback_new_user( id, name )
{
	count_other ++;
	if ( name.charAt(0) == '-' && name.charAt(1) == '-' ) {
		name = "Other " + count_other;
	}
	ids[ id ] = name;
	
	$("[rtc_id='"+id+"']").parent().find('.name').text( name );
}
function callback_chat_message_received(id, message )
{
	$("[rtc_id='"+id+"']").find('.name').text( ids[ id ] );	
}
</script>


<?php
	$homeURL = './';
?>
<div id='content'>
<div class='headerfield'>
	<div id='withcenter-vc-header'>
			<div class='icon'><a href='<?=$homeURL?>'><img src='<?=$img?>/icon.png'></a></div>
			<div class='video_chat_menu'>
				<a href='<?=$homeURL?>' class='link home'><img src='<?=$img?>/home.png'>HOME</a>
				<a href='#' class='link about'><img src='<?=$img?>/about.png'>ABOUT</a>
				<a href='#' class='link terms'><img src='<?=$img?>/terms.png'>TERMS</a>
				<a href='#' class='link support'><img src='<?=$img?>/support.png'>SUPPORT</a>
			<?
			if ( login() ) {
				$login_note = 'LOG OUT';
				$log_url = url_bbs()."/logout.php";				
				$login_class = 'logged_in';
			}
			else{ 
				$login_note = 'LOG IN';
				$login_class = 'not_logged_in';
				$log_url = "javascript:void(0)";
			}
			?>
				<a href='<?=$log_url?>' class='link log <?=$login_class?>'><img src='<?=$img?>/log_icon.png'><?=$login_note?></a>					
			</div>
			<div class='login_triangle <?=$login_class?>'></div>
			<div class='drop_down_login <?=$login_class?>'>
				<?
					include widget( array( 'code' => 'login-video-chat', 'name' => 'login-video-chat' ) );
				?>
			</div>
			
	</div>
</div>
	<div id='withcenter-room'>
		<div class='top-menu'>
			<div class='title'>
			<?=$_GET['room_name']?>
			</div>
			<div class='room-settings'>
			<img src='<?=$img?>/settings.png'>
			<div class='triangle'></div>
			<div class='room-settings-content'>				
				<div class='do-command leave'><div class='tooltip'><div class='triangle'></div><div class='tip'>Leave Conversation</div></div></div>
				<div class='do-command camera on'><div class='tooltip'><div class='triangle'></div><div class='tip on'>Turn Video off</div><div class='tip off'>Turn Video on</div></div></div>
				<div class='do-command sound on'><div class='tooltip'><div class='triangle'></div><div class='tip on'>Mute Video</div><div class='tip off'>Unmute Video</div></div></div>	
			</div>
			</div>
			<div class='share-url'>
			<?php
			function curPageURL() { 
				$pageURL = 'http'; 
				if ( $_SERVER["HTTPS"] == "on") {$pageURL .= "s";} 
				$pageURL .= "://"; 
				if ($_SERVER["SERVER_PORT"] != "80") { 
					$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; 
				} else { 
					$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; 
				} 
				return $pageURL; 
			} 
?> 

				Share Conversation <a href="javascript:alert('Copy the address below and send it to your friend.');">(?)</a>:<br>
				
				
				<input type='text' name='copy_address' value="<?=curPageURL();?>">
				
				
				<br>
			</div>
			<div style='clear:both;'></div>
		</div>
		
		<div class='loader'>
			<img src='<?=$img?>/loader.gif'>
			Loading ...
		</div>
				
		<div id='video-chat'></div>
		
		<div class='footer'>© COPYRIGHT(C) 2007 ~ <?=date('Y')?> WithCenter.COM</div>
	</div>	
</div>
</body>
</html>

