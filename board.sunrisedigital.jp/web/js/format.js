// {}は new オブジェクト();とやっていることはほぼ同じ
var BoardSdjpObj = BoardSdjpObj||{};

/** 
 * 日付フォーマットを変換する
 * "yyyy-mm-dd hh:mm:ss" 
 *   → "yyyy年mm月dd日(曜日) hh時mm分ss秒 "
 */
BoardSdjpObj.formatDate = function(str) {
  // デフォルト値を設定
  str = str || "no_entry";

  // 日付以外が引数に入っているようだったら即returnする。
  // Date()に日付以外を渡すと正常に動かないため。
  if(!str.match(/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}\:\d{2}/)){
    return $("#tpl_no_entry").text();
  }

  //Chromeではないブラウザ対策
  // yyyy-mm-dd ⇒ yyyy/mm/dd にしてからDate()に渡す
  var date = new Date(str.replace(/-/g,'/'));

  var week = ["日","月","火","水","木","金","土"];//日本語曜日表示用
  var month = date.getMonth()+1;//そのまま出力すると0月～11月表記になるので。

  //変換開始
  var formatted = 
    date.getFullYear()+"年"
    +month +"月"
    +date.getDate()+"日"
    +"("+week[date.getDay()]+")"+"　"
    +date.getHours()+"時"
    +date.getMinutes()+"分"
    +date.getSeconds()+"秒";

  return formatted;
};
