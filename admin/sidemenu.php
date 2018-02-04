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
    <!-- <li><div class="user-view">
      <div class="background">
        <img src="images/office.jpg">
      </div>
      <a href="#!user"><img class="circle" src="images/yuna.jpg"></a>
      <a href="#!name"><span class="white-text name">John Doe</span></a>
      <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
    </div></li>
    <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li> -->
    <li><a href='?u=home&b=admin_home' class='' ><b>Home</b></a></li>
    <!-- <li><a href='?u=home&b=up' class=''><b>User Profile</b></a></li> -->
    <!-- <li><a href='?u=home&b=rt' class=''><b>Request Termination</b></a></li> -->
    <li><a href='?u=home&b=list_users' class=''><b>List Users</b></a></li>
  
  
  </ul>
  <a href="?u=home&b=sm" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>

