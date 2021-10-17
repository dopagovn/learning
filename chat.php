<?php
        require './backend/web_config.php';
        load_top();
?>
<link rel="stylesheet" href="./frontend/homeStyle.css" > <!-- thêm cái ./ vô -->
<div class="khoi1" >
       <form  action="#" method="post" name="seach">
               <p>M.S.A</p>
               <input type="text" name="seach" /> <br/>
               <select  >
                   <option> conver 1</option>
                     <option>conver 2</option>
                      <option>conver 3</option>
                       <option>conver 4</option>
               </select><br/>
           <dl>
                   <dt> <a href="chat.php" type="auto" target="_blank"> poin1</a>  </dt>   
                   <dt> <a href="chat.php" type="auto" target="_blank">  poin2 </dt>
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin3  </dt>  
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin4  </dt>
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin5  </dt>
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin6  </dt>
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin7</a>  </dt>   
                   <dt>  <a href="chat.php" type="auto" target="_blank">  poin8 </dt>
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin9  </dt>  
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin10  </dt>
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin11 </dt>
                   <dt>   <a href="chat.php" type="auto" target="_blank"> poin12</a>  </dt>   
                   <dt> <a href="chat.php" type="auto" target="_blank">  poin13 </dt>
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin14 </dt>  
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin15</dt>
                   <dt>  <a href="chat.php" type="auto" target="_blank"> poin16 </dt>
                   
          </dl>       

       </form>      
</div>

<div class="khoi2" align="center" >
       <form   action="#" method="post" name="seach">
               <p> Maiin</p><br/><br/><br/><br/><br/><br/><br/><br/>
               
                <input type="text" name= "write">
        </form> 
</div>
<div class="khoi3" align="right" >
        <form action="#" method="post" name="seach">
                
                <select id="select" >
                  
                       <option>profile</option>
               </select>
       </form>   
</div>     
<?php load_footer(); ?> <!-- Nếu Load top với footer rồi thì không cần thẻ <html> m chỉ cần design mấy cái này thôi hay thẻ <body> nữa -->