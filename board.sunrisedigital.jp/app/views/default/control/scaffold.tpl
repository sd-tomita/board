{extends file='default/base.tpl'}
 
{block title append} {$page_name}{/block}
 
{block css append}
<link rel="stylesheet" type="text/css" href="/css/sdx/scaffold.bootstrap.css">
{/block}
 
{block main_contents}{include 'sdx/include/scaffold/html.tpl'}{/block}