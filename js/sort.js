$(function () {
  $('.drag').draggable({
    /* class="drag"が指定されている要素をdraggableに */
    containment: '#drag-area' /* ドラッグできる範囲 */,
    cursor: 'move' /* ドラッグ時のカーソル形状 */,
    opacity: 0.6 /* ドラッグ中の透明度 */,
    scroll: true /* ウィンドウ内をスクロールしたい */,
    zIndex: 10 /* ドラッグ中の重ね順を一番上に */,
    /* ==========STOP処理====================================== */
    stop: function (event, ui) {
      /* ドラッグ終了時に起動 */
      var myNum = $(this).data('num'); /* data-num="値" の値を取得 */
      var myLeft =
        ui.offset.left -
        $('#drag-area').offset()
          .left; /* leftの座標　= 要素の座標 - #drag-areaの座標 */
      var myTop =
        ui.offset.top -
        $('#drag-area').offset()
          .top; /* topの座標 　= 要素の座標 - #drag-areaの座標 */
      /* ==========AJAX通信================= */
      $.ajax({
        type: 'POST' /* typeパラメーター：POSTかGETか */,
        url: './function/update.php' /* urlパラメーター：飛ばす先のファイル名（今回は自分に戻ってくる） */,
        data: {
          /* dataパラメーター：データをphpに渡す data:{ foo:'引数', bar:'引数' }　でPHP側は $_POST['foo'] で'引数'の値を受け取る */
          id: myNum /* key:valueの関係、つまりidのというkeyとそれに入れる値valueはmyNumとなる */,
          left: myLeft,
          top: myTop,
        },
      })
        .done(function () {
          /* ajaxの通信に成功した場合の処理 */ console.log('成功');
        })
        .fail(function (XMLHttpRequest, textStatus, errorThrown) {
          /* ajaxの通信に失敗した場合エラー表示 */ console.log(
            XMLHttpRequest.status,
          );
          console.log(textStatus);
          console.log(errorThrown);
        });
      /* ==========/AJAX通信================= */
      console.log('左: ' + myLeft); /* x座標がとれている */
      console.log('上: ' + myTop); /* y座標がとれている */
    },
    /* ==========/STOP処理====================================== */
  });
});
