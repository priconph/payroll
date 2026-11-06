var dtNavCode 
let getNavCodePkid 
$(document).ready(function(){
    dtNavCode = $('#tbl_nav_code').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "lengthMenu"        : [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "iDisplayLength"    : 10,
        "sAjaxSource"       : "server_side_scripts/configuration/nav_code_main.php",
    });


    $('#formCreateUpdateNavCode').submit(function (e) {
        e.preventDefault();
        let action = {
            "action" : "create_update_nav_code" 
        }
        let data = $.param(action) + "&" + $(this).serialize();
        $.ajax({
            type: "POST",
            url: "handler/handler_nav_code.php",
            data: data,
            dataType: "json",
            success: function (data) {
                if(data['result']=="success"){
                    alert("Created Successfully");
                    $('.reset-value').val('')
                    $('#modalCreateUpdateNavCode').modal('hide');
                    dtNavCode.ajax.reload(null, false);
                }else{
                    alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
                }
            },error: function (data){
                console.log('error: '+data);
                alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
            }
        });
    });
    
    $('#tbl_nav_code tbody').on('click','tr .fa-edit', function(){
        getNavCodePkid    = this.id;

        $('#navCodePkid').val(getNavCodePkid)
        GetNavCodeDetailsToEdit(getNavCodePkid)
    });
    
    function GetNavCodeDetailsToEdit(getNavCodePkid){
        let action = {
            "action" : "get_nav_code_by_id",
            "pkid"   : getNavCodePkid
        }
        let details = $.param(action) + "&" + $(this).serialize();
        $.ajax({
            type: "POST",
            url: "handler/handler_nav_code.php",
            data: details,
            dataType: "json",
            success: function (data) {
                for(var i=0;i<data['ctr'];i++){
                    $('#navCodeDepartment').val(data['nav_code_dept'][i])
                    $('#department').val(data['department'][i])
                    $('#navCodeSection').val(data['nav_code_sect'][i])
                    $('#section').val(data['section'][i])
                    $('#navCodeDivision').val(data['nav_code_div'][i])
                    $('#division').val(data['division'][i])
                }
            },error: function (data){
                console.log('error: '+data);
            }
        });
    }

    $("#modalCreateUpdateNavCode").on('hidden.bs.modal', function () {
        $('.reset-value').val('')
    });

    $(document).on('click','.navCodeChangeStatus', function(){
        let getNavCodeStatus    = $(this).attr('status');
        getNavCodePkid          = this.id;
        console.log('this', getNavCodeStatus);
        $('#navCodeStatusPkid').val(getNavCodePkid)
        $('#navCodeStatus').val(getNavCodeStatus)

        if(getNavCodeStatus == 0){
            $("#navCodeChangeStatusLabel").text('Are you sure you want to activate?'); 
        }else{
        $("#navCodeChangeStatusLabel").text('Are you sure you want to deactivate?');
        }
    });

    $('#formNavCodeChangeStatus').submit(function (e) {
        e.preventDefault();
        let action = {
            "action" : "nav_code_change_status_by_id",
            "pkid"   : getNavCodePkid
        }
        let data = $.param(action) + "&" + $(this).serialize();
        $.ajax({
            type: "POST",
            url: "handler/handler_nav_code.php",
            data: data,
            dataType: "json",
            success: function (data) {
                if(data['result']=="success"){
                    $('.reset-value').val('')
                    $('#modalNavCodeChangeStatus').modal('hide');
                    dtNavCode.ajax.reload(null, false);
                }else{
                    alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
                }
            },error: function (data){
                console.log('error: '+data);
                alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
            }
        });
    });

});


