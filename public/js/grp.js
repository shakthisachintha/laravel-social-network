var group={"name":"","members":[]};

function addToGroup(id){
    duplicate=0;
    group.members.forEach(element=>{
        if(element==id){
            duplicate=1;
        }
    });
    if(duplicate==0){
        group.members.push(id);
    }else{
        return 0;
    }
    
    if(group.members.length!=0){
        $("#group-member-widget").fadeIn();
    }
    if(group.name && group.members.length>=2){
        $("#create-grp-btn").removeAttr("disabled");
    }
    followers.forEach(element => {
        if(element.id==id){
            $("#group-member-list").append('<a onclick="showDelete(this.id)" id="badge-'+element.id+'" href="javascript:;" style="font-size:13px" class="badge ml-1 p-3 mr-1 mt-2 badge-info grpmember">'+element.name+'</a>');
            return
        }
    });
    
}

function resetGroups(){
    group={"name":"","members":[]};
    $("#group-name").val(" ");
    $("#group-member-list").html("");;
    $("#create-grp-btn").attr("disabled","disabled");
}

function setName(name){
    group.name=name;
    if(group.members.length>=2){
        $("#create-grp-btn").removeAttr("disabled");
    }
}

function showGroupChat(id){

}

function showGroupChats(id){

}

function deleteGroupChat(id){
    BootstrapDialog.show({
        title: 'Chat Delete!',
        message: 'Are You Sure To Delete Group Chat ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);

                $.ajax({
                    url: BASE_URL+'/group-chat/delete-chat',
                    type: "POST",
                    timeout: 5000,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        dialog.close();
                        if (response.code == 200){
                            $('.dm .chat').html(" <p style='padding: 20px;'>Group Chat Deleted! </p> ");
                            $('#chat-people-list-'+id).remove();
                        }else{
                            $('#errorMessageModal').modal('show');
                            $('#errorMessageModal #errors').html('Something Went Wrong!');
                        }
                    },
                    error: function(response){
                        console.log(response);
                        dialog.close();
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something Went Wrong!');
                    }
                });
            }
        }, {
            label: 'No!',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}

function sendGroupMessage(e){
    if (e.which == 13 && ! e.shiftKey) {
        var id = $('#form-message-write input').val();
        var message = $('#form-message-write textarea').val();
        $('#form-message-write textarea').attr('disabled', 'disable');

        if (message.trim() != '') {
            var data = new FormData();
            data.append('id', id);
            data.append('message', message);

            $.ajax({
                url: BASE_URL + '/group-chat/send',
                type: "POST",
                timeout: 5000,
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': CSRF},
                success: function (response) {
                    if (response.code == 200) {
                        console.log(response);
                        $('.dm .chat .message-list .alert').remove();
                        $('#form-message-write textarea').val("");
                        $('#form-message-write textarea').removeAttr('disabled');
                        $('.dm .chat .message-list').append(response.html);
                        $(".dm .chat .message-list").animate({ scrollTop: $('.dm .chat .message-list').prop("scrollHeight")}, 1000);
                    } else {
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something went wrong!');
                    }
                },
                error: function (response) {
                    console.log(response);
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html('Something went wrong!');
                }
            });
        }
        return false;
    }
}

function fetchGroupList(){
    $.ajax({
        url: BASE_URL + '/direct-messages/people-list',
        type: "POST",
        timeout: 5000,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $('.dm .friends-list .alert').remove();
                $('.dm .friends-list').html(response.html);
                if (initial_dm == 0) {
                    showFirstChat();
                    initial_dm = 1;
                }
            }
        },
        error: function () {

        }
    });
}

function deleteGroupChatMessage(id){
    alert("group message delete" + id);
    BootstrapDialog.show({
        title: 'Message Delete!',
        message: 'Are you sure to delete message ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/group-chat/delete-message',
                    type: "POST",
                    timeout: 5000,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        dialog.close();
                        if (response.code == 200){
                            $('.dm .chat #chat-message-'+id).remove();
                        }else{
                            $('#errorMessageModal').modal('show');
                            $('#errorMessageModal #errors').html('Something went wrong!');
                        }
                    },
                    error: function(){
                        dialog.close();
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something went wrong!');
                    }
                });
            }
        }, {
            label: 'No!',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}

function createGroup(){
   if(group.name && group.members.length>=2){
       $.ajax({
            url: BASE_URL + '/group-chat/create',
            type: "POST",
            timeout: 5000,
            contentType: "application/json",
            cache: false,
            processData: false,
            data:JSON.stringify(group),
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (response) {
                if(response.code==200){
                    console.log(response);
                    $('.dm .chat').html(response.html);
                    $('#grpChatModal').modal('hide');
                    resetGroups();
                }else{
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html("Sorry! Something Went Wrong.<br>Group Creation Failed.");
                }
            },
            error:function(data){
                console.log(data);
            }
       });
   }
}

function showDelete(id){
    $("#"+id).html('<i class="fas fa-times"></i>');
}

function showList(){
    $("#search-user-widget").fadeIn();
}

function hideList(){
    $("#search-user-widget").fadeOut();
}

function searchUserListGroup() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("modal-search-group");
    filter = input.value.toUpperCase();
    table = document.getElementById("modal-table-group");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}