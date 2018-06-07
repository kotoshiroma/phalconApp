$(function(){

    var modal_add  = $('#modal_add');
    var modal_edit = $('#modal_edit');

    /* 「サブカテゴリー追加」ボタンクリック時イベント */
    $(document).on('click', '#open_modal_add', function(){
        // モーダル内のフォームをクリアする
        modal_add.find('.form_category').val("");
        modal_add.find('.form_sub_category_name').val("");
        // バリデーションメッセージも消す
        modal_add.find('label.error').remove();
    });

    /* サブカテゴリー追加モーダルにて、「追加する」ボタンクリック時のイベント */
    // サブカテゴリー保存後、テーブルを再描画する
    $(document).on('click', '#submit_add', function(){

        // バリデーション
        if (!modal_add.find('.modal_form').valid()) {
            return false;
        }

        $.ajax(
            {
                url:'/subcategory/add',
                type:'POST',
                dataType:'json',
                data:
                {
                    'category_id'      : modal_add.find('.form_category').val(),
                    'sub_category_name': modal_add.find('.form_sub_category_name').val()
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

    /* サブカテゴリー「編集」ボタンクリック時のイベント。*/
    // 編集モーダルの各フォームに、既存の値をセットする。
    $(document).on('click', '.open_modal_edit', function(){

        // バリデーションメッセージを消す
        modal_edit.find('label.error').remove();

        // 「編集」ボタンがクリックされた行の値を取得
        $tr = $(this).closest('tr');

        $id                = $tr.find('.hidden_id').text();
        $category_id       = $tr.find('.hidden_category_id').text();
        $sub_category_name = $tr.find('.sub_category_name').text();
        
        // 記事編集モーダル内の各フォームに、値をセット
        modal_edit.find('.form_id').val($id);
        modal_edit.find('.form_category').val($category_id);
        modal_edit.find('.form_sub_category_name').val($sub_category_name);
    });

    /* サブカテゴリー編集モーダルの「保存する」ボタンクリック時イベント */
    // サブカテゴリー保存後、テーブルを再描画する
    $(document).on('click', '#submit_edit', function(){

        // バリデーション
        if (!modal_edit.find('.modal_form').valid()) {
            return false;
        }

        $.ajax(
            {
                url:'/subcategory/edit',
                type:'POST',
                dataType:'json',
                data:
                {
                    'id'                : modal_edit.find('.form_id').val(),
                    'category_id'       : modal_edit.find('.form_category').val(),
                    'sub_category_name' : modal_edit.find('.form_sub_category_name').val(),
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

        $('#sub_category_table > tbody > tr').remove();

        // var docFragment = document.createDocumentFragment();

        data.forEach(function(item) {

            var tr = $('<tr></tr>');

            // var td1 = $('<td></td>');
            // var chk = $('<input class="chkbox" type="checkbox" name="post_id[]" >');
            // chk.val(item.Post.id);
            // td1.append(chk);
            // tr.append(td1);

            var td_sub_category_name = $('<td></td>');
            td_sub_category_name.text(item.sub_category_name);
            td_sub_category_name.attr('class', 'sub_category_name');
            tr.append(td_sub_category_name);

            var td_category_name = $('<td></td>');
            td_category_name.text(item.category_name);
            td_category_name.attr('class', 'category_name');
            tr.append(td_category_name);


            var td_editBtn = $('<td></td>');
            var button = $('<button></button>');
            button.attr('id', item.id);
            button.attr('class', 'open_modal_edit btn btn-primary btn-xs');
            button.attr('data-toggle', 'modal');
            button.attr('data-target', '#modal_edit');
            button.text('編集');
            td_editBtn.append(button);
            tr.append(td_editBtn);

            var td_created = $('<td></td>');
            td_created.text(item.created);
            tr.append(td_created);

            var td_modified = $('<td></td>');
            td_modified.text(item.modified);
            tr.append(td_modified);

            // 非表示データ
            var td_hidden_id = $('<td></td>');
            td_hidden_id.text(item.id);
            td_hidden_id.attr('class', 'd-none hidden_id');            
            tr.append(td_hidden_id);

            var td_hidden_category_id = $('<td></td>');
            td_hidden_category_id.text(item.category_id);
            td_hidden_category_id.attr('class', 'd-none hidden_category_id');            
            tr.append(td_hidden_category_id);

            // docFragment.append(tr);
            $('#sub_category_table > tbody').append(tr);
        })

        // $('#post_table > tbody').append(docFragment);
    }

    // jquery.validate.jsを使ったフォームバリデーション
    $('#modal_add .modal_form').validate({
        rules : {
            category          : { required: true },
            sub_category_name : { required: true }
        },
        messages : {
            category          : "カテゴリーを選択してください",
            sub_category_name : "サブカテゴリー名を入力してください"
        }
    });
    $('#modal_edit .modal_form').validate({
        rules : {
            category          : { required: true },
            sub_category_name : { required: true }
        },
        messages : {
            category          : "カテゴリーを選択してください",
            sub_category_name : "サブカテゴリー名を入力してください"
        }
    });
})