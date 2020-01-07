var group={"name":"","members":[]};

function addToGroup(id){
    group.members.push(id);
    if(group.members.length!=0){
        $("#group-member-widget").fadeIn();
    }
    if(group.name){
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

function createGroup(){
   if(group.name && group.members.length>2){
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
                console.log(response);
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