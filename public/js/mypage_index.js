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
                    'body' : $('#new_post_modal').find('.form_body').val()
                }
            }
        )
        .done(function(data){
            console.log(data);
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