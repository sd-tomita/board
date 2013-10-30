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
        {$form.login_id->setLabel('スレッドID')->renderLabel() nofilter}
        {$form.login_id->render([class=>"form-control", placeholder=>$form.thread_id->getLabel()]) nofilter}
        {$form.login_id->renderError() nofilter}
      </div>
      <div class="form-group">
        {$form.login_id->setLabel('アカウントID')->renderLabel() nofilter}
        {$form.login_id->render([class=>"form-control", placeholder=>$form.account_id->getLabel()]) nofilter}
        {$form.login_id->renderError() nofilter}
      </div>
      <div class="form-group">
        {$form.login_id->setLabel('コメント')->renderLabel() nofilter}
        {$form.login_id->render([class=>"form-control", placeholder=>$form.body->getLabel()]) nofilter}
        {$form.login_id->renderError() nofilter}
      </div>
      <div class="text-center">
        <input type="submit" name="submit" value="保存" class="btn btn-success">
      </div>
    </form>
  </div>
</div>
    {/block}