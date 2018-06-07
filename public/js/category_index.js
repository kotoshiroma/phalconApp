$(function(){

    var modal_add  = $('#modal_addCategory');
    var modal_edit = $('#modal_editCategory');

    /* 「カテゴリー追加」ボタンクリック時イベント */
    $(document).on('click', '#open_modal_addCategory', function(){
        // モーダル内のフォームをクリアする
        modal_add.find('.form_category_name').val("");
        // バリデーションメッセージも消す
        modal_add.find('label.error').remove();
    });

    /* カテゴリー追加モーダルにて、「追加する」ボタンクリック時のイベント */
    // カテゴリー保存後、テーブルを再描画する
    $(document).on('click', '#submit_add', function(){

        // バリデーション
        if (!modal_add.find('.modal_form').valid()) {
            return false;
        }

        $.ajax(
            {
                url:'/category/add',
                type:'POST',
                dataType:'json',
                data:
                {
                    'category_name': modal_add.find('.form_category_name').val(),
                }
            }
        )
        .done(function(data){
            // PHPで取得した全カテゴリーをもとに、テーブル再描画
            redrawTable(data);
        })
        .fail(function(textStatus, jqXHR, errorThrown){
            console.log('fail');
            console.log(textStatus);
            console.log(jqXHR);
            console.log(errorThrown);
        })

        modal_add.modal('hide'); // .modal()はjQueryのメソッドではなく、Btstrpのメソッド
    });

    /* カテゴリー「編集」ボタンクリック時のイベント。*/
    // 編集モーダルの各フォームに、既存の値をセットする。
    $(document).on('click', '.open_modal_editCategory', function(){

        // バリデーションメッセージを消す
        modal_edit.find('label.error').remove();

        // 「編集」ボタンがクリックされた行の値を取得
        $tr = $(this).closest('tr');

        $id            = $tr.find('.hidden_id').text();
        $category_name = $tr.find('.category_name').text();
        
        // 記事編集モーダル内の各フォームに、値をセット
        modal_edit.find('.form_id').val($id);
        modal_edit.find('.form_category_name').val($category_name);
    });

    /* カテゴリー編集モーダルの「保存する」ボタンクリック時イベント */
    // カテゴリー保存後、テーブルを再描画する
    $(document).on('click', '#submit_edit', function(){

        // バリデーション
        if (!modal_edit.find('.modal_form').valid()) {
            return false;
        }

        $.ajax(
            {
                url:'/category/edit',
                type:'POST',
                dataType:'json',
                data:
                {
                    'id'            : modal_edit.find('.form_id').val(),
                    'category_name' : modal_edit.find('.form_category_name').val(),
                }
            }
        )
        .done(function(data){

            redrawTable(data);
        })
        .fail(function(textStatus, jqXHR, errorThrown){
            console.log('fail');
            console.log(textStatus);
            console.log(jqXHR);
            console.log(errorThrown);
        })

        modal_edit.modal('hide'); // .modal()はjQueryのメソッドではなく、Btstrpのメソッド
    });



    /* 引数に取ったデータをもとに、テーブルを再描画する関数 */
    function redrawTable(data) {

        $('#category_table > tbody > tr').remove();

        // var docFragment = document.createDocumentFragment();

        data.forEach(function(item) {

            var tr = $('<tr></tr>');

            // var td1 = $('<td></td>');
            // var chk = $('<input class="chkbox" type="checkbox" name="post_id[]" >');
            // chk.val(item.Post.id);
            // td1.append(chk);
            // tr.append(td1);

            var td2 = $('<td></td>');
            td2.text(item.category_name);
            td2.attr('class', 'category_name');
            tr.append(td2);

            var td3 = $('<td></td>');
            var button = $('<button></button>');
            button.attr('id', item.id);
            button.attr('class', 'open_modal_editCategory btn btn-primary btn-xs');
            button.attr('data-toggle', 'modal');
            button.attr('data-target', '#modal_editCategory');
            button.text('編集');
            td3.append(button);
            tr.append(td3);

            var td4 = $('<td></td>');
            td4.text(item.created);
            tr.append(td4);

            var td5 = $('<td></td>');
            td5.text(item.modified);
            tr.append(td5);

            // 非表示データ
            var td7 = $('<td></td>');
            td7.text(item.id);
            td7.attr('class', 'd-none hidden_id');            
            tr.append(td7); 

            // docFragment.append(tr);
            $('#category_table > tbody').append(tr);
        })

        // $('#post_table > tbody').append(docFragment);
    }

    // jquery.validate.jsを使ったフォームバリデーション
    $('#modal_addCategory .modal_form').validate({
        rules : {
            category_name : { required: true }
        },
        messages : {
            category_name : "カテゴリー名を入力してください"
        }
    });
    $('#modal_editCategory .modal_form').validate({
        rules : {
            category_name : { required: true }
        },
        messages : {
            category_name : "カテゴリー名を入力してください"
        }
    });
})