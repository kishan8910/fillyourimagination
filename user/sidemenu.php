<script type="text/javascript">
$(".button-collapse").sideNav();
$(function() {
	 var pgurl = window.location.href.substr(window.location.href
.lastIndexOf("?"));

	 $(".vertical-menu a").each(function(){
		var url_href = $(this).attr("href");
	 
		  if(url_href.trim() == pgurl.trim())
		  {

				$(this).addClass("active");
		}
	 })
});

</script>

<ul id="slide-out" class="side-nav fixed">
    <li><div class="user-view">
      <div class="background">
        <img src="../libcommon/images/infillcube_cover.jpg">
      </div>
      <a href=""><img class="circle" src="../libcommon/images/infillcube_icon.png"></a>
      <a href=""><span class="white-text name">Infillcube</span></a>
      <a href=""><span class="white-text email">Fill Your Imagination</span></a>
    </div></li>
<!--     <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li> -->

    <!-- <li><a href='?u=home&b=up' class=''><b>User Profile</b></a></li> -->
    <!-- <li><a href='?u=home&b=rt' class=''><b>Request Termination</b></a></li> -->
    <li><a href='?u=home&b=estimate' class=''><i class="material-icons">fiber_new</i><b>Estimate New Model</b></a></li>
        <li><a href='?u=home&b=user_home' class='' >
      <i class="material-icons">payment</i>
            <b>Payment</b></a></li>
    <!-- <li><a href='?u=lithophane&b=lithophane' class=''><i class="material-icons">burst_mode</i><b>Lithophanes</b></a></li> -->
  
  
  </ul>
  <a href="?u=home&b=sm" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>

