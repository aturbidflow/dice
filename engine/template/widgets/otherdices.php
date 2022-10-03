<?php

class WaitingDices extends Widget {

    function Widget($id=''){ 
        ?>
        <script type="text/javascript">
            function update(){                
                $("#await-dices-panel").html('<h2>Ожидающие подтверждения</h2><br/><img src="/images/loader.gif" alt="Loading..." />').load('/admin/ajax/updateOtherDices.php');
            }
            var refreshId = setInterval(function(){update()}, 5000);
            $.ajaxSetup({ cache: false });
            var currentUser = '<?php Users::getCurrentUser()->Login(); ?>';
            $('.delete-link, .approve-link, .decline-link').live('click',function(e){
                if ($(this).attr('data-user') != currentUser){
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('href')
                    });
                    update();
                }
            })
        </script>
        <div id="await-dices-panel">
            <?php Template::Widget('awaiting'); ?>
        </div>
<?php    }
    
}