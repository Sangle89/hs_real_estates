function changeStatus(table, id, field) {
    var field_id = $('#'+field+id);
    $.ajax({
            url: base_url + 'admincp/ajax/update_status',
            type: 'post',
            dataType: 'json',
            data: {table: table, id: id, field: field, value: field_id.attr('data-status')},
            beforeSend: function(){
                $('#loading').css('display','block');
            },
            success: function(res) {
                field_id.html(res.label);
                field_id.attr('data-status', res.status);
                $('#loading').css('display','none');
            }
       }).done(function(res){
            
            //elem.html(res);
       }); 
} 
function removeThumb(obj) {
    $(obj).parent('.thumb').remove();
}

function filterCity() {
    $('#btnSearch').click(function(){
        var country = $('select[id="country"] option:selected').val();
        var form = $('#formSearch');
        window.location.href = form.attr('action') + '/' + country;
   });
}
function filterProduct() {
    $('#btnSearch').click(function(){
        var form = $('#formSearch');
        var category = form.find('select[name="category_id"] option:selected').val();
        var sku = form.find('input[name="sku"]').val();
        var title = form.find('input[name="title"]').val();
        $.ajax({
           url: form.attr('action'),
           dataType: 'html',
           type: 'post',
           data: form.serialize(),
           success: function(response) {
                $('#content .table-form tbody').html(response);
           }
        });
        //window.location.href = form.attr('action') + '/' + category + '/' + sku + '/' + title;
   });
}
function filterProject() {
    $('#btnSearch').click(function(){
        var form = $('#formSearch');
        var category = form.find('select[name="category_id"] option:selected').val();
        var title = form.find('input[name="title"]').val();
        $.ajax({
           url: form.attr('action'),
           dataType: 'html',
           type: 'post',
           data: form.serialize(),
           success: function(response) {
                $('#content .table-form tbody').html(response);
           }
        });
   });
}

$(document).ready(function(){
   $('input[name="checkall"]').change(function(){
       // alert('checkall');
        $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
   }); 
});

function checkAll() {
    $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
}