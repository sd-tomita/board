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
        <i class="fa fa-tags" ></i>thread-{$entry_list->getFirstRecord()->getThread()->getId()}&nbsp;&nbsp;
        {$entry_list->getFirstRecord()->getThread()->getTitle()}&nbsp;&nbsp;
        <i class="fa fa-time" /></i>スレッド作成日時：{$entry_list->getFirstRecord()->getThread()->getFormatedDateByZend('created_at', 'yyyy年MM月dd日(E) HH時mm分ss秒')}
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
</div>
    
{*------------コメントの投稿フォーム------------*}
{if $sdx_user->hasId()}
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