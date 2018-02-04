<script type="text/javascript">
  
function tryAgain() {
    history.go(-1);
}

</script>



<div class="container">
  <div class="row valign-wrapper">
    <div class="col s6 offset-s3 valign">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <span class="card-title">Error Occured !</span>
          <p><?  
            if ($file_extension_error) {
              echo "Please choose stl files only.";
            }
            else
            {
              $responseArray = unserialize($response);
              echo $responseArray['message'];  
            }
            
              
           ?></p>
        </div>
        <div class="card-action">
          <a href="#"><input type="button" class="btn" value="Try Again" onclick="tryAgain();"></a>
          
        </div>
      </div>
    </div>
  </div>
</div>