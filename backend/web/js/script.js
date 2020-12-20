var previous_time = 0
var scoll_div = document.getElementById('messages-container');
scoll_div.scrollTop = scoll_div.scrollHeight;
function updateListen(audio, id, class_id, duration) {
    if (previous_time + 2 > audio.currentTime) {
        if (Math.ceil(audio.currentTime) == duration) {
            console.log("done");
            var formData = new FormData();
            formData.append("upload_id", id);
            formData.append("class_id", class_id);
            $.ajax({
                method: "post",
                dataType: "json",
                url: "/admin/admin-user-dashboard/listen-complete",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success == 1) {
                        $.pjax.reload({container: "#student-uploads-view"});
                    }
                }
            });
        }
        previous_time = audio.currentTime
    } else {
        audio.currentTime = previous_time;
    }
}