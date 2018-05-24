$(function(){

    $(document).on('click', '#add_post', function(){
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

            // $('#post_table tbody tr').remove();
            $('#post_table > tbody > tr').remove();

            var docFragment = document.createDocumentFragment();

            data.forEach(function(item) {

                var tr = $('<tr></tr>');

                // var td1 = $('<td></td>');
                // var chk = $('<input class="chkbox" type="checkbox" name="post_id[]" >');
                // chk.val(item.Post.id);
                // td1.append(chk);
                // tr.append(td1);

                var td2 = $('<td></td>');
                td2.text(item.title);
                tr.append(td2);

                var td3 = $('<td></td>');
                var button = $('<button></button>');
                button.attr('id', item.id);
                button.attr('class', 'btn btn-primary btn-xs');
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

                // docFragment.append(tr);
                $('#post_table > tbody').append(tr);
            })

            // $('#post_table > tbody').append(docFragment);
        })
        .fail(function(textStatus, jqXHR, errorThrown){
            console.log('fail');
            console.log(textStatus);
            console.log(jqXHR);
            console.log(errorThrown);
        })

        $('#new_post_modal').modal('hide'); // .modal()はjQueryのメソッドではなく、Btstrpのメソッド
    });
})