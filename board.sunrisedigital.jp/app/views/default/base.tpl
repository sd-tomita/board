<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
  <link rel="stylesheet" href="/css/footer_area.css" type="text/css">
  <style>
      {*フォームのエラー表示(404等)を整えるためのCSS*}
    .sdx_error{
      font-size: 12px;
      margin: 0;
      padding: 0;
      font-weight: bold;
      list-style: none;
      color: #b94a48;
    }
    .sdx_error > li:before{
      content: "\f14a";
      font-family: FontAwesome;
    }
  </style>
  {block css}{/block}
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  {block js}{/block}
  <title>Board {block title}{/block}</title>
</head>
<body>
  <header class="navbar navbar-inverse">{$sdx_user = $sdx_context->getUser()}
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="/"><i class="icon-comments-alt text-warning"></i> Board</a>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown{if $sdx_user->hasId()} has-id{/if}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-user icon-large"></i> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              {if $sdx_user->hasId()}
              <li class="dropdown-header">{$sdx_context->getVar('signed_account')->getName()}</li>
              <li><a href="/secure/logout"><i class="icon-signout"></i> ログアウト</a></li>
              {else}
              <li><a href="/account/create"><i class="icon-plus-sign-alt"></i> ユーザー登録</a>
              </li>
              <li><a href="/secure/login"><i class="icon-signin"></i> ログイン</a></li>
              {/if}
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </header>
  {block main_contents}{/block}
  <footer class="origin_footer">
  <div class="footer_menu">
    <dl>
      <dt><i class=icon-lock></i> サンライズ関連</dt>
        <dd><a href="#">会社公式</a></dd>
        <dd><a href="#">チャットワーク</a></dd>
        <dd><a href="#">GitHub</a></dd>
    </dl>
    <dl>
      <dt><i class=icon-lock></i> 参考サイト</dt>
        <dd><a href="#">Google</a></dd>
        <dd><a href="#">Yahoo!JAPAN</a></dd>
        <dd><a href="#">サルでもわかるGit入門</a></dd>
    </dl>
    <dl>
      <dt><i class=icon-lock></i> 運営サイト</dt>
        <dd><a href="#">風俗情報ヌキなび</a></dd>
        <dd><a href="#">風俗情報スポニチAAA</a></dd>
        <dd><a href="#">女性求人パピヨンジョブ</a></dd>
        <dd><a href="#">男性求人ガンガン</a></dd>
    </dl>
  </div>
  <div class="footer_end">
    &copy;Copyright Sunrise Digital Corporation. All rights reserved.
  </div>
  </footer>
</body>
</html>