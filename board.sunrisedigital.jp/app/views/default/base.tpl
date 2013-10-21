<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
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
              <li class="dropdown-header">{$sdx_context->get('signed_account')->getName()}</li>
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
</body>
</html>