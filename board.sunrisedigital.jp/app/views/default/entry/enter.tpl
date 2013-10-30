{extends file='default/base.tpl'}
{block title append} コメント投稿ページです{/block}
{block main_contents}
    <div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">コメント投稿ページになる予定です</h1>
  </div>
</div>
    <p>以下が投稿フォームです。まだデータベースには接続していません。</p>    
{*コメントの投稿フォーム*}
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">投稿フォーム</h3>
  </div>
  <div class="panel-body">
    {$form->renderStartTag() nofilter}
      <div class="form-group">
        {$form.thread_id->setLabel('スレッドID')->renderLabel() nofilter}
        {$form.thread_id->render([class=>"form-control", placeholder=>$form.thread_id->getLabel()]) nofilter}
        {$form.thread_id->renderError() nofilter}
      </div>
      <div class="form-group">
        {$form.account_id->setLabel('アカウントID')->renderLabel() nofilter}
        {$form.account_id->render([class=>"form-control", placeholder=>$form.account_id->getLabel()]) nofilter}
        {$form.account_id->renderError() nofilter}
      </div>
      <div class="form-group">
        {$form.body->setLabel('コメント')->renderLabel() nofilter}
        {$form.body->render([class=>"form-control", placeholder=>$form.body->getLabel()]) nofilter}
        {$form.body->renderError() nofilter}
      </div>
      <div class="text-center">
        <input type="submit" name="submit" value="投稿" class="btn btn-success">
      </div>
    </form>
  </div>
</div>
    {/block}