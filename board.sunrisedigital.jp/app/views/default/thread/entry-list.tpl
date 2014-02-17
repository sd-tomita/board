{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/list.css" type="text/css">
{/block}
{block title append} エントリリスト{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">スレッド別エントリリスト</h1>
  </div>
</div>
    
{*------------エントリ表示------------*}
<div class="thread-entrylistbox">
    <div class="thread-titleinfo">
        <i class="fa fa-tags" ></i>thread-{$thread_info->getId()}&nbsp;&nbsp;
        {$thread_info->getTitle()}&nbsp;&nbsp;
        <i class="fa fa-time" /></i>スレッド作成日時：{$thread_info->getFormatedDateByZend('created_at', 'yyyy年MM月dd日(E) HH時mm分ss秒')}
    </div>
    {foreach $entry_list as $record}
    <dl class="thread-entryinfo">
        <dt>
                <i class="fa fa-pencil"></i>
                お名前:{$record->getAccount()->getName()}&nbsp;&nbsp;
                記事投稿日時:{$record->getFormatedDateByZend('updated_at', 'yyyy年MM月dd日(E) HH時mm分ss秒')}&nbsp;&nbsp;
                ID:{$record->getAccount_id()}
        </dt>
        <dd>{$record->getBody()|sdx_autolink_ex|nl2br|replace:'<br />':'<br>' nofilter}</dd>
    </dl>
    {/foreach}
    {if $entry_list->getFirstRecord()->isNull()}
    <div class="thread-entrylistbox">
      <div class="alert alert-warning">
        <i class="fa fa-pencil-square-o"></i> まだ書き込みはありません
      </div>
    </div>
    {/if}

</div>
    
{*------------コメントの投稿フォーム------------*}
{if $sdx_user->hasId() && ($sdx_context->getUser()->getAttribute('post_limit_data')->is_limited)}
  <div id="entry-form" class="alert alert-danger">
    <p><strong><i class="fa fa-exclamation-circle"></i> 連続投稿数が上限値となりました。</strong></p><hr>
    <figure>
      <figcaption><i class="fa fa-user"></i> 連続投稿制限について</figcaption>
      <p>サーバー負荷軽減のため、一定時間内に同一アカウントから複数回のエントリが確認された際に
      新規投稿を制限させていただく場合がございます。
      お手数ですが、一旦ログアウトし再度ログインをお願いいたします。</p>
    </figure>
  </div>


{elseif $sdx_user->hasId()}
<div id="entry-form" class="panel panel-default thread-entryform">
  <p><i class="fa fa-pencil"></i>コメント投稿フォーム</p>
  <div class="panel-body">
    {$form->renderStartTag() nofilter}
      <div class="form-group">
        {$form.body->render([class=>"form-control", placeholder=>'コメントを入力してください']) nofilter}
        {$form.body->renderError() nofilter}
      </div>
      <div class="text-center">
          <input type="submit" name="submit" value="投稿する！" class="btn btn-success">
      </div>
    </form>
  </div>
</div>
{/if}

{/block}