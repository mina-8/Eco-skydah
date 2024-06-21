<div class="content-wrappers">   
        <div class="container-fluid overflow-hidden py-5 px-lg-0">
            <div class="container feature px-lg-0 py-5">
                <div class=" col-12 mx-auto border p-3 bg-white"><h6 class="mb-0"><?php echo $_SESSION['Admin_name'] ?></h6></div>
                
                <div class="chat-container col-12 mx-auto border p-3 bg-white main-chat" id="chatload">
                    
                                  <div class="mssOut">
                                      <div class="message col-10">
                                        مرحبا سوف يتواصل معك خدمة العملاء في اقرب وقت ممكن
                                      </div>
                                  </div>
                                  
                                  <?php 
                                    if(isset($message)){?>
                                        <div class="mssOut me">
                                          <div class="message col-10 me"><?php echo $message ?></div>
                                        </div>
                                  <?php  }
                                  ?>
                                    <!-- <div class="mssOut me">
                                      <div class="message col-10 me"></div>
                                    </div> -->
                                    

                      
                    
                </div>
                
                <div class=" col-12 mx-auto border p-3 bg-white">
                  <form class="" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="input-group">
                      <textarea type="text" name="message" class="form-control me-2 rounded" placeholder="Write Here ..."></textarea>
                      <div class="input-group-append">
                      
                      <input class="btn btn-primary px-5" style="height: 62px;" type="submit" value="Send"/>
                      </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
          
          
        </div>