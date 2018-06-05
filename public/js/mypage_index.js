$(function(){

    /* 「記事を書く」ボタンクリック時イベント */
    //  モーダル内のフォームをクリアする
    $(document).on('click', '#write_post', function(){
        $('#new_post_modal').find('.form_title').val("");
        $('#new_post_modal').find('.form_body').val("");
        $('#new_post_modal').find('.form_category').val("");
        $('#new_post_modal').find('.form_sub_category').val("");

        // バリデーションメッセージも消す
        $('#new_post_modal').find('label.error').remove();
    });

    /* 新規投稿モーダルにて、「投稿する」ボタンクリック時のイベント */
    // 記事保存後、テーブルを再描画する
    $(document).on('click', '#add_post', function(){

        // バリデーション
        if (!$('#new_post_modal').find('.modal_form').valid()) {
            return false;
        }

        $.ajax(
            {
                url:'/post/add',
                type:'POST',
                dataType:'json',
                data:
                {
                    'title': $('#new_post_modal').find('.form_title').val(),
                    'body' : $('#new_post_modal').find('.form_body').val(),
                    'category_id'     : $('#new_post_modal').find('.form_category').val(),
                    'sub_category_id' : $('#new_post_modal').find('.form_sub_category').val()
                }
            }
        )
        .done(function(data){
            // PHPで取得した全記事データをもとに、テーブル再描画
            redrawTable(data);
        })
        .fail(function(textStatus, jqXHR, errorThrown){
            console.log('fail');
            console.log(textStatus);
            console.log(jqXHR);
            console.log(errorThrown);
        })

        $('#new_post_modal').modal('hide'); // .modal()はjQueryのメソッドではなく、Btstrpのメソッド
    });

    /* 各記事の「編集」ボタンクリック時のイベント。*/
    // 記事編集モーダルの各フォームに、既存の値をセットする。
    $(document).on('click', '.edit_post', function(){

        // バリデーションメッセージを消す
        $('#edit_post_modal').find('label.error').remove();

        var that = this;
        // フォームへ値をセットする前に、ajaxでサブカテゴリーを取得しセレクトボックスにセットしておく
        $.ajax(
            {
                url:'/post/getSubCategory',
                type:'POST',
                dataType:'json',
                data:
                {
                    // 'category_id' : $(this).closest('tr').find('.hidden_category_id').text()
                    'category_id' : $(that).closest('tr').find('.hidden_category_id').text()
                }
            }
        )
        .done(function(data){
            var select = $('#edit_post_modal').find('.form_sub_category');
            select.empty();

            data.forEach(function(item){
                var option = $('<option></option>');
                option.val(item.id);
                option.text(item.sub_category_name);
                select.append(option);
            })

            // 「編集」ボタンがクリックされた行の値を取得
            $tr = $(that).closest('tr');

            $id              = $tr.find('.hidden_id').text();
            $title           = $tr.find('.title').text();
            $body            = $tr.find('.hidden_body').text();
            $category_id     = $tr.find('.hidden_category_id').text();
            $sub_category_id = $tr.find('.hidden_sub_category_id').text();
            
            // 記事編集モーダル内の各フォームに、値をセット
            $('#edit_post_modal').find('.form_id').val($id);
            $('#edit_post_modal').find('.form_title').val($title);
            $('#edit_post_modal').find('.form_body').val($body);
            $('#edit_post_modal').find('.form_category').val($category_id);
            $('#edit_post_modal').find('.form_sub_category').val($sub_category_id);
        })
        .fail(function(textStatus, jqXHR, errorThrown){
            console.log('fail');
            console.log(textStatus);
            console.log(jqXHR);
            console.log(errorThrown);
        })
    });

    /* 記事編集モーダルの「保存する」ボタンクリック時イベント */
    // 記事保存後、テーブルを再描画する
    $(document).on('click', '#edit_post', function(){

        // バリデーション
        if (!$('#edit_post_modal').find('.modal_form').valid()) {
            return false;
        }
        
        $.ajax(
            {
                url:'/post/edit',
                type:'POST',
                dataType:'json',
                data:
                {
                    'id'              : $('#edit_post_modal').find('.form_id').val(),
                    'title'           : $('#edit_post_modal').find('.form_title').val(),
                    'body'            : $('#edit_post_modal').find('.form_body').val(),
                    'category_id'     : $('#edit_post_modal').find('.form_category').val(),
                    'sub_category_id' : $('#edit_post_modal').find('.form_sub_category').val()
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

        $('#edit_post_modal').modal('hide'); // .modal()はjQueryのメソッドではなく、Btstrpのメソッド
    });



    /* 引数に取ったデータをもとに、テーブルを再描画する関数 */
    function redrawTable(data) {

        $('#post_table > tbody > tr').remove();

        // var docFragment = document.createDocumentFragment();

        data.forEach(function(item) {

            var tr = $('<tr></tr>');

            // var td1 = $('<td></td>');
            // var chk = $('<input class="chkbox" type="checkbox" name="post_id[]" >');
            // chk.val(item.Post.id);
            // td1.append(chk);
            // tr.append(td1);

            var td2 = $('<td></td>');
            td2.text(item.title);
            td2.attr('class', 'title');
            tr.append(td2);

            var td3 = $('<td></td>');
            var button = $('<button></button>');
            button.attr('id', item.id);
            button.attr('class', 'edit_post btn btn-primary btn-xs');
            button.attr('data-toggle', 'modal');
            button.attr('data-target', '#edit_post_modal');
            button.text('編集');
            td3.append(button);
            tr.append(td3);

            var td4 = $('<td></td>');
            td4.text(item.category_name);
            tr.append(td4);

            var td5 = $('<td></td>');
            td5.text(item.sub_category_name);
            tr.append(td5);

            var td6 = $('<td></td>');
            td6.text(item.created);
            tr.append(td6);

            // 非表示データ(id, body, category_id, sub_category_id)
            var td7 = $('<td></td>');
            td7.text(item.id);
            td7.attr('class', 'd-none hidden_id');            
            tr.append(td7); 

            var td8 = $('<td></td>');
            td8.text(item.body);
            td8.attr('class', 'd-none hidden_body');            
            tr.append(td8);

            var td9 = $('<td></td>');
            td9.text(item.category_id);
            td9.attr('class', 'd-none hidden_category_id');            
            tr.append(td9); 

            var td10 = $('<td></td>');
            td10.text(item.sub_category_id);
            td10.attr('class', 'd-none hidden_sub_category_id');            
            tr.append(td10); 

            // docFragment.append(tr);
            $('#post_table > tbody').append(tr);
        })

        // $('#post_table > tbody').append(docFragment);
    }

    /* カテゴリーセレクトボックスのChangeイベント */
    // 選択されたカテゴリーの値に応じて、サブカテゴリーセレクトボックスの値を動的に変える
    $(document).on('change', '.form_category', function(){
        
        // 新規投稿と記事編集の２つのモーダルにそれぞれ存在するセレクトボックスを区別するためthisを使う
        var that = $(this);
        $.ajax(
            {
                url:'/post/getSubCategory',
                type:'POST',
                dataType:'json',
                data:
                {
                    'category_id' : that.val()
                }
            }
        )
        .done(function(data){
            var select = that.closest('.modal-body').find('.form_sub_category');
            select.empty();

            data.forEach(function(item){
                var option = $('<option></option>');
                option.val(item.id);
                option.text(item.sub_category_name);
                select.append(option);
            })
        })
        .fail(function(textStatus, jqXHR, errorThrown){
            console.log('fail');
            console.log(textStatus);
            console.log(jqXHR);
            console.log(errorThrown);
        })
    });

    // jquery.validate.jsを使ったフォームバリデーション
    // $('#new_post_modal .modal_form, #edit_post_modal .modal_form').validate({
    // $('#edit_post_modal .modal_form, #new_post_modal .modal_form').validate({
    $('#new_post_modal .modal_form').validate({
        rules : {
            title        : { required: true },
            body         : { required: true },
            category     : { required: true },
            sub_category : { required: true }
        },
        messages : {
            title        : "タイトルを入力してください",
            body         : "本文を入力してください",
            category     : "カテゴリーを選択してください",
            sub_category : "サブカテゴリーを選択してください"
        }
    });
    $('#edit_post_modal .modal_form').validate({
        rules : {
            title        : { required: true },
            body         : { required: true },
            category     : { required: true },
            sub_category : { required: true }
        },
        messages : {
            title        : "タイトルを入力してください",
            body         : "本文を入力してください",
            category     : "カテゴリーを選択してください",
            sub_category : "サブカテゴリーを選択してください"
        }
    });
})