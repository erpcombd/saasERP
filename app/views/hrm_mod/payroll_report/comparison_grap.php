<?

session_start();

require "../../config/inc.all.php";

?>

<link type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<style>
 *, *:before, *:after {
  -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
 }

body {
  background: #999;
}



.container {
  width: 100%;
  margin: 20px;
  background: #fff;
  padding: 20px;
  overflow: hidden;
  float: left;
}




.rounded .progress-track,
.rounded .progress-fill {
  border-radius: 3px;
  box-shadow: inset 0 0 5px rgba(0,0,0,.2);
}



/* Vertical */

.vertical .progress-bar {
  float: left;
  height: 300px;
  width: 40px;
  margin-right: 25px;
}

.vertical .progress-track {
  position: relative;
  width: 40px;
  height: 100%;
  background: #ebebeb;
}

.vertical .progress-fill {
  position: relative;
  background: #825;
  height: 50%;
  width: 40px;
  color: #fff;
  text-align: center;
  font-family: "Lato","Verdana",sans-serif;
  font-size: 12px;
  line-height: 20px;
}

.rounded .progress-track,
.rounded .progress-fill {
  box-shadow: inset 0 0 5px rgba(0,0,0,.2);
  border-radius: 3px;
}
</style>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script>
  $('.horizontal .progress-fill span').each(function(){
  var percent = $(this).html();
  $(this).parent().css('width', percent);
});


$('.vertical .progress-fill span').each(function(){
  var percent = $(this).html();
  var pTop = 100 - ( percent.slice(0, percent.length - 1) ) + "%";
  $(this).parent().css({
    'height' : percent,
    'top' : pTop
  });
});
</script>
<div class="container vertical rounded">
  <h2>Vertical, Rounded</h2>
  <div class="progress-bar">
    <div class="progress-track">
      <div class="progress-fill">
        <span>100%</span>
      </div>
    </div>
  </div>

  <div class="progress-bar">
    <div class="progress-track">
      <div class="progress-fill">
        <span>75%</span>
      </div>
    </div>
  </div>

  <div class="progress-bar">
    <div class="progress-track">
      <div class="progress-fill">
        <span>60%</span>
      </div>
    </div>
  </div>

  <div class="progress-bar">
    <div class="progress-track">
      <div class="progress-fill">
        <span>20%</span>
      </div>
    </div>
  </div>

  <div class="progress-bar">
    <div class="progress-track">
      <div class="progress-fill">
        <span>34%</span>
      </div>
    </div>
  </div>

  <div class="progress-bar">
    <div class="progress-track">
      <div class="progress-fill">
        <span>82%</span>
      </div>
    </div>
  </div>
</div>













