$(document).ready(function(){
    // Example AJAX call
    $("#loadData").click(function(){
        $.get('/pegawai/data', function(res){
            $("#result").html(res);
        });
    });
});
