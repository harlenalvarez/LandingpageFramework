<div id="dwSlide" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      <?php
        
        
        foreach($images as $image)
        {
            $ext = pathinfo($image);
            switch($ext['extension']){
                case "jpg":
                case "png":
                    $imgCollections[] = $ext['basename'];
                    if($x==0)
                    {
                       echo "<li data-target='#dwSlide' data-slide-to='$x' class='active'></li>"; 
                    }
                    else
                    {
                        echo "<li data-target='#dwSlide' data-slide-to='$x'></li>";
                    }
                    ++$x;
                    break;
                default:
                    break;
                    
            }
            
        }
      ?>
    
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
  <?php 
  
  $x=0;
  $captions = file(ROOT_IMAGES."slideshow/captions/captions.txt",FILE_IGNORE_NEW_LINES);
  
  
  foreach ($imgCollections as $image)
  {
      if($x==0)
          {
          
          ?>
      
          <div class="item active">
            <img src="<?php echo URL_IMAGES_PATH."slideshow/images/$imgCollections[$x]"?>" alt="<?php echo $imgCollections[$x]?>">
            <div class="carousel-caption">
                <h3><?php echo $captions[$x];?></h3>
            </div>
          </div>
          
      <?php
      }
      else
      {
       ?>
            <div class="item">
                   <img src="<?php echo URL_IMAGES_PATH."slideshow/images/$imgCollections[$x]"?>" alt="<?php echo $imgCollections[$x]?>">
                  <div class="carousel-caption">
                      <h3><?php echo $captions[$x]; ?></h3>
                  </div>
            </div>
       <?php   
      }
      ++$x;
  }
  ?> 
   
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#dwSlide" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#dwSlide" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#dwSlide").carousel({
            interval:2000,
            pause: "hover",
            wrap: true
        });  
    });
    
</script>


