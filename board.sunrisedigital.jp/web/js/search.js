/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//js読み込み確認用。読み込みができていたら消す。
//$(document).ready(function()
//  {
//    alert("jqueryの読み込みが完了しました");
//  });


//サーバー通信
$(function(){
  $("#search-form input[type='submit']").click(function(){
    /* *
     * フォームの値を取得、Ajax送信まで。
     */
    //各種データを取得。serialize()でまとめてとる。
    //→こうなるはず　genre_id=○○&tag_id[△△]=△△
    var $form = $("#search-form");
    var query = $form.serialize();
      
    $.ajax({
      type: "GET",
      url: "/thread/entrance/thread-list", 
      data: query,
    }).done(function(data){
        $('.thread_list').remove();//古いdataの削除
        $('.data-disp').append(data);
    }).fail(function(data){
          alert("ng");
    });          
  });
});

