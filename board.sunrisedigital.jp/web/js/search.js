/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* *
 * ページ読み込み時の処理。いきなりスレッド一覧を出す。
 * ここでは特に条件は何も指定せずシンプルにthread-listの
 * HTMLを呼ぶだけ。
 */
$(function(){
  $.get("/thread/entrance/thread-list").done(function(data){
    $('.data-disp').append(data);
  });      
});

/* *
 * 検索開始ボタンを押した時の処理
 */
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
        $('.data-disp').html(data);
    }).fail(function(data){
          alert("ng");
    }).always(function(data){
        //通信完了時の処理。ここで送信ボタンを元に戻す
        $("#search-form input[type='submit']").attr('value', '検索開始').attr('disabled', false);        
    });
  });
});