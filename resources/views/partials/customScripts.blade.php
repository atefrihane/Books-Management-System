<script>
    $(document).ready(function () {

        $('.table').DataTable({

       
            "bLengthChange": false,
            "pageLength": 10,
            "columnDefs": [{
                "targets": "is-wrapped",
                render: function (data, type, row) {
                    if (data.length > 50) {
                        return data.substr(0, 100) + '...';

                    } else {
                        return data.substr(0, 50);
                    }

                }
            }, ],
            responsive: true,
        });


        $(".img-upload").hover(
            function () {
                $(this).addClass('make-it-slow').css('cursor', 'pointer');
            },
            function () {
                $(this).removeClass('make-it-slow');
            }
        );

        // $("input[type=text]").attr('maxlength', '150');
        // $("input[type=email]").attr('maxlength', '150');

        // $("input[type=number]").attr({
        //     "max": 999999,
        //     "min": 1

        // });
        // $("textarea").attr('maxlength', '500');
    });

    //disable edit sent message
    $(".mailbox-read-message > .note-editable").attr("contenteditable", false);

   
</script>
