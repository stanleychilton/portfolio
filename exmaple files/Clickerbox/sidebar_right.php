<?php
$page = $pagenum;
echo "<div id='chardiv' id='texteditb'><h4>";
if($page == 0 || $page == 2 || $page == 7 || $page == 8){
	echo "Recent Anonymous posts:";
}else{
	echo "Recent Public posts:";
}
echo "</h4></div>";
?>
<div class="result" style = 'padding-right: 0px;padding-left:0px'></div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script type="text/javascript">
	var reachedMax = false;
	var page = <?php echo $pagenum ?>;
	
	$(document).ready(function () {
        update();
    });

            function update() {
                if (reachedMax)
                    return;

                $.ajax({
                   url: 'ajax/recents.php',
                   method: 'POST',
                   dataType: 'text',
                   data: {
                       update: 1,
					   page: page
                   },
                   success: function(responses) {
                        if (responses == "reached Max")
                            reachedMax = true;
                        else {
                            $(".result").html(responses);
                        }
                    }
                });
            }
			
	$(document).ready(function(){
		setInterval(update,10000);
	});
</script>
<?php
	include('sidebar_ad.php');
?>
	