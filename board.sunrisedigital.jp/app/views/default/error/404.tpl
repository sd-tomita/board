{extends 'default/base.tpl'}
{block title}ここにタイトル{/block}
 
{block main_contents}
<h2>404Error</h2>
<ul>
<li>{$message}</li>
<li>Module:{$module}</li>
<li>Controller:{$controller}</li>
<li>Action:{$action}</li>
</ul>
{/block}


