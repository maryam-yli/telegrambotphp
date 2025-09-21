<?php 

ob_start();
// API Key (توکن ربات شما)
$API_KEY = '7725428811:AAGLAzYnkkLSiKPpIo0IsFz5Z3UDCsBsO0w';
// _________________
define('API_KEY',$API_KEY);

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        // اگر cURL خطا داد، اینجا در لاگ سرور ثبت می‌شود
        error_log(curl_error($ch)); 
    }else{
        return json_decode($res);
    }
}
function sendmessage($chat_id, $text, $model){
	bot('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>$mode
	]);
	}
	function sendaction($chat_id, $action){
	bot('sendchataction',[
	'chat_id'=>$chat_id,
	'action'=>$action
	]);
	}

//====================دریافت متغیرها======================//
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$message_id = $update->message->id;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$text = $message->text;
$name = $update->message->from->first_name;
//... بقیه متغیرها که در کد اصلی شما بودند


//====================چک کردن عضویت کانال (با تابع bot قوی‌تر)=================//
$forchaneel = bot('getChatMember',[
	'chat_id' => '@KillToLove_novel', // *** آیدی کانال شما ***
	'user_id' => $from_id
]);
$tch = $forchaneel->result->status;
$type = $update->message->chat->type;

// چک کردن رتبه کاربر در گروه (با تابع bot قوی‌تر)
$info = bot('getChatMember', [
    'chat_id' => $chat_id,
    'user_id' => $from_id
]);
$rank = $info->result->status; // دسترسی به عنوان Object

$reply = $update->message->reply_to_message->message_id;

//====================منطق عضویت اجباری=================//

// 1. ارسال پیام اخطار (فقط یک بار)
if($tch != 'member' && $tch != 'creator' && $tch != 'administrator'){
SendMessage($chat_id,"سلام🌹
$name 
برا اینکه تو گروه بخوای چت کنی باید تو کانال ما جوین بشی وگرنه پیام هات پاک میشه
بعد از ورود به کانال برگرد تو گروه و با خیال راحت از چت کردن لذت ببر
ایدی کانال ما:
🆔: @KillToLove_novel"); // *** آدرس کانال در متن پیام ***
}

// 2. حذف پیام
if($rank != "creator" && $rank != "administrator"){ // اگر کاربر مدیر گروه نبود
    if($text || $photo || $video || $location || $sticker || $document || $contact || $music || $gif || $voice){ // اگر محتوایی ارسال کرد
        if($tch != 'member' && $tch != 'creator' && $tch != 'administrator'){ // اگر عضو کانال نبود
            bot('deleteMessage',[
            'chat_id'=>$chat_id,
            'message_id'=>$message->message_id
          ]);
        }
    }
}

//############################################################################//
// دستور اجتماعی (با آیدی ادمین)
if($text == "/social" && $from_id == 1727460223){ // *** آیدی ادمین خود را اینجا وارد کنید ***
sendaction($chat_id, typing);
        bot('sendmessage', [
                'chat_id' =>$chat_id,
                'text' =>"
+  version:1 +   
**************
* coded by  : *
*  @Mmmmmamad   *
**************
 @Mmmmmamad ",
        ]);
  } 

@unlink ("error_log"); // استفاده از @ برای جلوگیری از هشدار "No such file"
	?>
