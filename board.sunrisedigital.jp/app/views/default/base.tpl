<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
  <style>
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
    .origin_footer{
        padding: 10px;
	border-top: solid 1px #CCC;
	background-color: #101010;
	color: #FFF;
	font-size: 100%;
	text-align: center;
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
      &copy;Copyright Sunrise Digital Corporation. All rights reserved. 
  </footer>
</body>
</html>