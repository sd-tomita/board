<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/top.css" type="text/css">
  <link rel="stylesheet" href="/css/footer.css" type="text/css">
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
        <a class="navbar-brand" href="/"><i class="fa fa-comments text-warning"></i> Board</a>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown{if $sdx_user->hasId()} has-id{/if}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user fa-large"></i> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              {if $sdx_user->hasId()}
              <li class="dropdown-header">{$sdx_context->getVar('signed_account')->getName()}</li>
              <li><a href="/secure/logout"><i class="fa fa-sign-out"></i> ログアウト</a></li>
              {else}
              <li><a href="/account/create"><i class="fa fa-sign-in"></i> ユーザー登録</a>
              </li>
              <li><a href="/secure/login"><i class="fa fa-sign-in"></i> ログイン</a></li>
              {/if}
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </header>
  {block main_contents}{/block}
  <footer class="origin_footer">
  <div class="footer_end">
    &copy;Copyright Sunrise Digital Corporation. All rights reserved.
  </div>
  </footer>
</body>
</html>