{extends file='default/base.tpl'}
{block title append} コメント投稿ページです{/block}
{block main_contents}
    <div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">コメント投稿ページになる予定です</h1>
  </div>
</div>
    <p>以下が投稿フォームです</p>    
{*コメントの投稿フォーム*}
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">投稿フォーム</h3>
  </div>
  <div class="panel-body">
    {*$form->renderStartTag() nofilter*}
      <div class="form-group">
      </div>
      <div class="form-group">
      </div>
      <div class="form-group">
      </div>
      <div class="text-center">
        <input type="submit" name="submit" value="保存" class="btn btn-success">
      </div>
    </form>
  </div>
</div>
    {/block}