$(function(){
  /* *
   * 変数の用意
   */
  var searchSubmit = $("#search-form input[type='submit']");
  var searchMore = $('input[name=more]');
  var loading = $('.loading');
  
  /* *
   * 通信用function
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
    $(".data-disp").addClass("thread_list");
    $.ajax({
      type: "GET",
      url: "/thread/entrance/thread-list", 
      data: query+"&pid="+somePid
    }).done(function(data){
      
        //レコードがあったかどうかの判定
        //data['records']の中身があるかどうか
        if(data['records'].length === 0){
          $(".data-disp").append("<div class='alert alert-warning'>スレッドが見つかりません。</div>");
        }
        for(var i in data.records){
          /* *
           * とりあえず今回は他に方法が思いつかなかったのでHTMLタグをjsで書きます。
           */
          $(".data-disp").append('<table class="table table-bordered">');
          $(".data-disp").append('<thead>');
          
          //なぜかclass="success"だけだとうまく当たらないので"alert-success"にしてます。
          $(".data-disp").append("<tr class='alert-success'> "+"<th>"+"<a href='/thread/"+data.records[i].id+"/list'>"+ data.records[i].title +"</a>" +"</th>"+"</tr>");
          $(".data-disp").append('</thead>');
          
          $(".data-disp").append('<tbody>');
          $(".data-disp").append("<tr>"+"<td>"+ "最終更新日時："+data.records[i].newest_date +"</td>"+"</tr>");
          $(".data-disp").append('</tbody>');
          $(".data-disp").append("</table>");
        }
    
        //ここでdata-next_pid属性を追加しておく。
        //これが｢さらに表示｣ボタンの表示有無判定に使われる
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