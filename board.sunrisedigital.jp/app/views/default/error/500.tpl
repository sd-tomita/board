500Error<br />
{*-----------------------------------------------
 ログイン状態で存在しないスレッドに書き込もうとしても
 ここに飛びます。すると以下のようなエラーを出力します。
 
 * 500Error
 * SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`board`.`entry`, CONSTRAINT `fk_entry_thread` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`) ON DELETE CASCADE)
 * Module:default
 * Controller:thread
 * Action:save-entry
 
 開発者サイド以外にはエラーであること以外は開示しないようにするため
 各パラメータは一旦非表示にします。
------------------------------------------------*}
{*{$message}<br />
Module:{$module}<br />
Controller:{$controller}<br />
Action:{$action}<br />*}