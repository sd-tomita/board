{extends file='default/base.tpl'}
{block title append} indexです{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">indexです</h1>
  </div>
</div>
<div>
    <p>ここにこれからトップページを作っていきます</p>
</div>
<div>
<?php
for($i=0, $i<count($thread->toArray()), $i++)
    {
        echo 'sample."$i"';
    }
?>
</div>
{/block}