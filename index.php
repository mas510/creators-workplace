<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>クリエイターの作業環境 - CREATORS WORKPLACE -</title>
 <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
</head>

<body>
<header>
  <h1 class="header-logo"><a href="/creators-workplace"><img src="./images/logo.png" alt="クリエイターの作業環境 - CREATORS WORKPLACE -" width="334"</a></h1>
</header>

<div class="content-body">
<?php
//PHPからTwitterAPIを操作するライブラリの読み込み
require_once('TwistOAuth.phar');

//OAuthオブジェクト生成
//TwitterAPPで発行したアクセストークン
$consumer_key = '8ndLA8VkRFpzjYPfnOoi5rXfN';
$consumer_secret = 'mGRVQpiAlnVbOwK9jKBKKfgpthDbGiTHHQY8HFLcUfw6W9vcvy';
$access_token = '132437582-xWj7yIP2BDyDIoNt4JmPiRE3beYAIZJQy0XfVH1x';
$access_token_secret = 'C7YKDI8cGZ5TBnQKdXEmrBKkTka7l2VId1CNn658cYX9T';
//ライブラリにアクセストークンを渡す
$connection = new TwistOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

// キーワードによるツイート検索
$tweets_params = ['q' => '作業環境 filter:images -RT -twitpic' ,'result_type'=>'recent' ,'count' => '10'];
$tweets = $connection->get('search/tweets', $tweets_params)->statuses;

foreach ($tweets as $value) {
  $text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
  // 検索キーワードをマーキング
  $keywords = preg_split('/,|\sOR\s/', $tweets_params['q']); //配列化
  foreach ($keywords as $key) {
    $text = str_ireplace($key, '<span class="keyword">'.$key.'</span>', $text);
  }
  // ツイート表示のHTML生成
  disp_tweet($value, $text);
}

function disp_tweet($value, $text){
  //取得したツイート情報から必要な情報を抽出
  $screen_name = $value->user->screen_name;//スクリーンネーム
  $tweet_id = $value->id_str;//文字列型のツイートID
  $url = 'https://twitter.com/' . $screen_name . '/status/' . $tweet_id;//ツイートURL
  $value_media = $value->extended_entities->media[0]->media_url;//画像URL

  //HTML生成
  echo '<div class="card"><a class="card-linkarea" href ="' . $url . '" target="_blank">' . '<div class="card-thumb thumb" style ="background-image: url(' . $value_media . ');"></div></a>' . '</div>'  . PHP_EOL;
}
?>

<div class="btn-more">
  <a href="#"><img src="./images/btn.png" width="212"></a>
</div>

<span class="frame frame-top"></span>
<span class="frame frame-bottom"></span>
<span class="frame frame-right"></span>
<span class="frame frame-left"></span>


<footer class="footer">
  <a class="copy" href="/creators-workplace">クリエイターの作業環境<br>- creators workplaces viewer -</a>
</footer>
</body>
</html>
