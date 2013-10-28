{extends file='default/base.tpl'}
{block title append} indexです{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">indexです</h1>
  </div>
</div>
<div>
    <ul>
          {foreach $threadlist as $record}
             <li>{$record->getTitle()}</li>
          {/foreach}
    </ul>
</div>

{/block}