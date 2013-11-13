{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="http://board.sunrisedigital.jp/css/custom_style.css" type="text/css">
{/block}
{block title append} エントリリスト{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">スレッド別エントリリスト</h1>
  </div>
</div>
    
{*------------スレッド表示第二案------------*}
<div class="thread-entrylistbox">
    <div class="thread-titleinfo">
        <i class="icon-tags"></i>thread-{$entry_list->getFirstRecord()->getThread()->getId()}&nbsp;&nbsp;
        {$entry_list->getFirstRecord()->getThread()->getTitle()}&nbsp;&nbsp;
        <i class="icon-time"></i>スレッド作成日時：{$entry_list->getFirstRecord()->getThread()->getCreated_at()}
    </div>
    {foreach $entry_list as $record}
    <dl class="thread-entryinfo">
        <dt>
                <i class="icon-pencil"></i>
                お名前:{$record->getAccount()->getName()}&nbsp;&nbsp;
                記事投稿日時:{$record->getUpdated_at()}&nbsp;&nbsp;
                ID:{$record->getAccount_id()}
        </dt>
        <dd>{$record->getBody()}</dd>
    </dl>
    {/foreach}   
</div>
    
{*------------コメントの投稿フォーム------------*}
{if $sdx_user->hasId()}
<div class="panel panel-default thread-entryform">
  <p><i class="icon-pencil"></i>コメント投稿フォーム</p>
  <div class="panel-body">
    {$form->renderStartTag() nofilter}
      <div class="form-group">
        {$form.body->render([class=>"form-control", placeholder=>$form.body->getLabel()]) nofilter}
        {$form.body->renderError() nofilter}
      </div>
      <div class="text-center">
          <input type="submit" name="submit" value="投稿する！" class="btn btn-success" >
      </div>
    </form>
  </div>
</div>
{/if}
{/block}