$(function(){
  /* *
   * テスト
   */
  $(".sub_menu").append("<a href='https://www.google.co.jp/'>"+"Google先生"+"</a>");
  $(".sub_menu").append("<a href='https://www.google.co.jp/'>"+"Google先生"+"</a>");
 
  /* *
   * 変数の用意
   */
  var searchSubmit = $("#search-form input[type='submit']");
  var searchMore = $('input[name=more]');
  var loading = $('.loading');
  
  /* *
   * 通信用の使いまわしfunction
   */
  function loadThread(somePid){
    /* *
     * somePid にデフォルト値として1を設定。
     * somePid がnull、0、空文字、undefined だったら"1"になるようにする。
     */
    somePid = somePid || 1;
    searchSubmit.hide();//通信が開始したらすぐ隠す
    searchMore.hide();//これも隠しておかないと通信開始直後｢さらに表示｣がいきなり見える。
    var $form = $("#search-form");
    var query = $form.serialize();
    $.ajax({
      type: "GET",
      url: "/thread/entrance/thread-list", 
      data: query+"&pid="+somePid
    }).done(function(jsondata){
        var data = jsondata;
        $(".data-disp").append('<table>');
        for(var i in data[0]){
          $(".data-disp").append("<tr>"+"<th>"+"<a href='/thread/"+data[0][i].id+"/list'>"+ data[0][i].title +"</a>" +"</th>"+"</tr>");
          $(".data-disp").append("<tr>"+"<td>"+ "最終更新日時："+data[0][i].newest_date +"</td>"+"</tr>");
        }
        $(".data-disp").append("</table>");
        $(".data-disp").attr("data-next_pid",data.next_pid);
    }).fail(function(jsondata){
        alert("NG");
    }).always(function(jsondata){
        searchSubmit.show();//通信が終わったのでsubmitボタンの非表示を解除
        loading.hide();
        
        //｢さらに表示｣ボタンはnext_pidがある限り表示させる
        if($(".data-disp").attr("data-next_pid")){
          searchMore.show();
        }
    });
    
    return this;
  }
  
  /* *
   * 各種イベント別動作
   * (ロード時以外の動作は一旦凍結)
   */
  
  //submitボタンを押したときの動作
  searchSubmit.on('click', function(){
    searchSubmit.hide();
    loading.show();
    $('.data-disp').html("");//これまでappendされたものを消す。
    loadThread();
  });
  
  //｢さらに表示｣ボタンを押したときの動作
  searchMore.on('click', function(){
    searchMore.hide();
    loading.show();
    
    //loadThread()の引数は data-nextpageid の値を指定。    
    loadThread($(".data-disp").attr("data-next_pid"));
  });
  
  //ページのロード時に実行。
  loadThread();
});