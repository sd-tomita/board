{extends file='default/base.tpl'}
{block css}
{/block}
{block title append} スレッド検索ページ{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">検索用ページ</h1>
  </div>

  <div class="panel-body">
   {$form->renderStartTag() nofilter}
   <div class="panel panel-default panel-info">
     <div class="panel panel-heading">
       ジャンルを指定できます
     </div>
     <div class="panel panel-body">
       {$form.genre->setDefaultEmptyChild('指定なし')->render() nofilter}
     </div>
   </div>

   <div class="panel panel-default panel-info">
     <div class="panel panel-heading">
       タグを指定できます
     </div>
     <div class="panel panel-body">
       {$form.tag->render() nofilter}
     </div>
   </div>

   <button type="submit" class="btn-primary btn-large"><i class="fa fa-search"></i> スレッド検索</button>
   </form>
  </div>
</div>
{/block}