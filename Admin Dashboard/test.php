<?php 
                                // check receiver
                                if($messages['ReceiverID'] == $_SESSION['Admin_id']){?>
                                  <div class="mssOut">
                                      <div class="message col-10"><?php echo $messages['Message'] ?></div>
                                  </div>
                                  <?php } else{?>
                                    <div class="mssOut">
                                        <div class="message col-10"><?php echo $messages['Message'] ?></div>
                                    </div>
                                 
                                <?php } ?>
                                <?php 
                                // check sender
                                if($messages['SenderID'] == $row_user['UserID']){?>
                                    <div class="mssOut me">
                                      <div class="message col-10 me"><?php echo $messages['Message'] ?></div>
                                    </div>
                                    <?php }else{?>
                                      <div class="mssOut me">
                                        <div class="message col-10 me"><?php echo $messages['Message'] ?></div>
                                      </div>

                                <?php } ?>