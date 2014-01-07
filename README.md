board
=====

概要
----

掲示板用リポジトリです。  

ルール(*2014/01/06時点)
-----------------------
作業用feat/board/xxxxx を機能ごとに作っていきます。  
既にブランチを作ってごっちゃになってきているので、今回に限り  
master = proj/board と置き換えて、フィートブランチは命名規則  
(feat/board/xxxxxx)に従うようにしています。  

フィートブランチでの作業内容が完了し、問題が無ければ  
master(仮想proj/board)にマージしていく　ということにします。  
基本的にはmaster 以外のブランチは常時1つだけという状態を保つ  
ようにしようと考えています。  

基本の流れとしては  
1)自分のパソコンでの作業、コミット  

2)SunriseDigitalStudy/tomita_boardへPush  
  MasterにはPushしない。  

3)MasterへPullRequestを出す。  
  ここでレビュー等実施  

4)レビュー後にMerge する。  

その他
------
2013/11/22 この手の説明関係は 本README.md にまとめることにしました。  
2014/01/06 ルールを変更しました。  


* Copyright 2013-2014, Yuichiro Tomita *  
