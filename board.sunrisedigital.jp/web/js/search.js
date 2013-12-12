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
  $("#search-form input[type='submit']").on('click', function(){
    //通信終わるまで送信ボタン無効化
    $("#search-form input[type='submit']").attr('value', 'please wait...').attr('disabled', true);
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
        $('input[name="more"]').remove();
        $('.data-disp').append(data);
        $('.data-disp').append('<input type=button name="more" value="more">');
    }).fail(function(data){
          alert("ng");
    }).always(function(data){
        //通信完了時の処理。ここで送信ボタンを元に戻す
        $("#search-form input[type='submit']").attr('value', '検索開始').attr('disabled', false);        
    });
  });
});